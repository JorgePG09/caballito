<?php
if (!empty($_POST["btningresar"])) {
    if (empty($_POST["usuario"]) and empty($_POST["password"]) ) {
        echo '<div class="alert alert-danger">LOS CAMPOS ESTAN VACIOS</div>';
    }
    else {
        $usuario = $_POST["usuario"];
        $clave = $_POST["password"];
        $opcion = $_POST["combo"];
        $sql=$conn->query("select * from login where usuario= '$usuario' and pass='$clave' and opcion='$opcion'");
        if ($datos=$sql->fetch_object()) {
            if ($opcion=='user') {     
                $_SESSION['loggedin'] = true;          
                header("location:index1.php");
            }elseif($opcion=='admin') {
                $_SESSION['loggedin'] = true;
                header("location:index.php");
            }
            }else {
           echo '<div class="alert alert-danger">ACCESO DENEGADO</div>';
        }
    }
}

?>