<?php
 if (!empty($_GET["id"]) and !empty($_GET["ta"])) {
    $id=$_GET["id"];
    $ta=$_GET["ta"];
    $sql=$conn->query("delete from $ta where Alumno_id=$id");
    if ($sql==true) { ?>
        <script>
            $(function notificacion(){
                new PNotify({
                    title:"CORRECTO",
                    type:"success",
                    text: "REGISTRO BORRADO CORRECTAMENTE",
                    style: "bootstrap3"
                })
            })
        </script>
    <?php }else { ?>
        <script>
            $(function notificacion(){
                new PNotify({
                    title:"INCORRECTO",
                    type:"error",
                    text: "ERROR AL ELIMINAR",
                    style: "bootstrap3"
                })
            })
        </script>
    <?php }
 }
?>