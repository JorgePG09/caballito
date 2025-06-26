<?php 
// Incluye tu archivo de conexión a la base de datos
require_once 'helper/conexion.php';
include('includes/header1.php')
?>
<section>
 <?php
    // Define tu consulta SQL
    // Reemplaza 'nombre_de_tu_tabla' con el nombre real de tu tabla
    $sql = "SELECT * FROM inica";
    $resultado = $conn->query($sql);
    if ($resultado->num_rows > 0) {
        // Iniciar la tabla HTML
        echo "<table>";
        echo "<thead><tr>";
        // Obtener los nombres de las columnas para los encabezados de la tabla
        // Esto hace que la tabla sea dinámica a la estructura de tu base de datos
        $primera_fila = $resultado->fetch_assoc();
        foreach ($primera_fila as $nombre_columna => $valor) {
            echo "<th>" . htmlspecialchars($nombre_columna) . "</th>";
        }
        echo "</tr></thead>";
        echo "<tbody>";

        // Mover el puntero de vuelta al principio del conjunto de resultados
        // para que la primera fila también se muestre como dato
        $resultado->data_seek(0);

        // Imprimir los datos de cada fila
        while($fila = $resultado->fetch_assoc()) {
            echo "<tr>";
            foreach ($fila as $valor) {
                // htmlspecialchars es VITAL para la seguridad, evita ataques XSS
                echo "<td>" . htmlspecialchars($valor) . "</td>";
                
            }
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<p style='text-align: center;'>No se encontraron resultados en la tabla.</p>";
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
    ?>
<?php 
include('includes/footer.php')
?>
</section>