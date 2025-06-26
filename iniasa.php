    <?php
    require_once 'helper/conexion.php'; // Tu archivo de conexión
    include('includes/header.php');
    include('helper/controlador_eliminar.php');
    $mensaje = '';
    
    // --- NOMBRES DE LAS COLUMNAS DE FECHA ---
    // ESTO ES CLAVE: Define aquí las columnas de fecha que tienes en tu DB
    // Asegúrate de que coincidan exactamente con los nombres de las columnas en tu tabla
    $columnas_fechas = ['07_jun', '14_jun', '21_jun', '28_jun'];
    // --- Lógica para PROCESAR la actualización ---
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['asistencia'])) {
        $actualizaciones_exitosas = 0;
        $errores_actualizacion = 0;

        foreach ($_POST['asistencia'] as $id_alumno => $datos_fechas) {
            $id_alumno = (int)$id_alumno; // Asegurarse de que es un entero

            $updates = [];
            $params = [];
            $types = "";

            foreach ($columnas_fechas as $columna_fecha) {
                if (isset($datos_fechas[$columna_fecha])) {
                    $updates[] = "`" . $columna_fecha . "` = ?"; // Envuelve el nombre de la columna con comillas inversas por si tiene caracteres especiales
                    $params[] = $datos_fechas[$columna_fecha];
                    $types .= "s"; // Asumimos que los estados son strings (Asistencia, Falta, etc.)
                }
            }

            if (!empty($updates)) {
                $sql_update = "UPDATE iniasa SET " . implode(", ", $updates) . " WHERE Alumno_id = ?"; // Ajusta Alumno_id a tu columna real de ID
                $stmt = $conn->prepare($sql_update);

                if ($stmt) {
                    $params[] = $id_alumno; // Añadir el ID del alumno al final de los parámetros
                    $types .= "i"; // 'i' para el id_alumno

                    // Usar call_user_func_array para bind_param con un número dinámico de argumentos
                    // Esto es necesario porque bind_param no acepta un array directamente
                    array_unshift($params, $types); // Añadir los tipos al principio del array de parámetros
                    call_user_func_array([$stmt, 'bind_param'], refValues($params)); // bind_param necesita referencias

                    if ($stmt->execute()) {
                        $actualizaciones_exitosas++;
                    } else {
                        $errores_actualizacion++;
                        // Opcional: loggear el error específico $stmt->error
                        error_log("Error al actualizar ID " . $id_alumno . ": " . $stmt->error);
                    }
                    $stmt->close();
                } else {
                    $errores_actualizacion++;
                    error_log("Error al preparar la consulta para ID " . $id_alumno . ": " . $conexion->error);
                }
            }
        }
        
        ?>
        <br><br><br><br><br><br><br>
        <?php 
        if ($errores_actualizacion == 0 && $actualizaciones_exitosas > 0) {
            $mensaje = "<div class='mensaje exito'>¡Asistencia actualizada exitosamente para " . $actualizaciones_exitosas . " alumnos!</div>";
        } elseif ($actualizaciones_exitosas > 0) {
            $mensaje = "<div class='mensaje error'>Se actualizaron " . $actualizaciones_exitosas . " alumnos, pero hubo errores en " . $errores_actualizacion . " alumnos.</div>";
        } else {
            $mensaje = "<div class='mensaje error'>No se pudo actualizar ningún registro o no se enviaron datos válidos.</div>";
        }
    }

    // Función auxiliar para bind_param (necesita referencias)
    function refValues($arr){
        if (strnatcmp(phpversion(),'5.3') >= 0) // PHP >= 5.3.0
        {
            $refs = array();
            foreach($arr as $key => $value)
                $refs[$key] = &$arr[$key];
            return $refs;
        }
        return $arr;
    }

    // --- Lógica para MOSTRAR el formulario ---
    echo $mensaje; // Mostrar el mensaje si existe

    // Construye la parte SELECT de la consulta con todas las columnas de fecha
    $select_columns_sql = "Alumno_id, NOMBRE_APELLIDO, COD_RECIBO";
    foreach ($columnas_fechas as $col) {
        $select_columns_sql .= ", `" . $col . "`"; // Asegura que las columnas con caracteres especiales estén entre comillas inversas
    }

    $sql_select = "SELECT " . $select_columns_sql ." FROM iniasa ORDER BY Alumno_id"; // Ajusta el nombre de tu tabla
    $resultado = $conn->query($sql_select);

    if ($resultado->num_rows > 0) {
        echo "<form method='POST' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";

        echo "<section>";
        echo "<table>";
        echo "<thead><tr>";
        echo "<th>ID Alumno</th>";
        echo "<th>Nombre y Apellido</th>";
        // Encabezados de las fechas
        foreach ($columnas_fechas as $columna_fecha) {
            echo "<th>" . htmlspecialchars(str_replace('_', '.', $columna_fecha)) . "</th>"; // Formatear para mostrar bonito (ej. 03.jun)
        }
        echo "<th>COD RECIBO</th>";
        echo "</tr></thead>";
        echo "<tbody>";

        while($fila = $resultado->fetch_assoc()) {
            echo "<tr>";
            echo "<td><center>" . htmlspecialchars($fila['Alumno_id']) . "<center></td>";
            echo "<td>" . htmlspecialchars($fila['NOMBRE_APELLIDO']) . "</td>";
            // Para cada columna de fecha, crear un select
            foreach ($columnas_fechas as $columna_fecha) {
                $estado_actual = $fila[$columna_fecha]; // Obtener el estado actual de la DB
                echo "<td>";
                echo "<select name='asistencia[" . $fila['Alumno_id'] . "][" . $columna_fecha . "]'>";
                // Opciones de asistencia. Puedes agregar más (ej. Tardanza, Justificado)
                echo "<option value= '' " . ($estado_actual == '' ? ' selected' : '') . ">-</option>"; // Opción por defecto
                echo "<option value='Asistencia'" . ($estado_actual == 'Asistencia' ? ' selected' : '') . ">Asistencia</option>";
                echo "<option value='Falta'" . ($estado_actual == 'Falta' ? ' selected' : '') . ">Falta</option>";

                echo "</select>";                
                echo "</td>";
            }
            echo "<td><center>" . htmlspecialchars($fila['COD_RECIBO']) . "</center></td>";?>
            <td><a href="iniasa.php?id=<?=$fila['Alumno_id']?>&ta=iniasa">eliminar</a>
            </td>
            <?php 
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "</section>";
        echo "<button type='submit' class='boton-guardar'>Guardar Toda la Asistencia</button>";
        echo "</form>";
    } else {
        echo "<p style='text-align: center;'>No se encontraron alumnos para registrar asistencia.</p>";
    }

    $conn->close();
    include('includes/footer.php')
    ?>