<?php
session_start();
if (!isset($_SESSION['loggedin']) or $_SESSION['loggedin'] !== true){
    header("location:login.php");
    exit();
}
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <title>CABALLITO ASISTENCIA</title>
    <link rel="stylesheet" href="http://localhost/pruebas1/assets/css/estilos1.css">
</head>

<body>

    <header class="header">
        
        <div class="container">
            <div class="btn-menu">
                <label for="btn-menu">☰</label>
            </div>
            
            <div class="logo">
                <h1>REGISTRO DE ASISTENCIA CABALLITO DE FINA ESTAMPA</h1>
            </div>
                        
            <nav class="menu">
                <a href="index.php">Inicio</a>
                <a href="helper/logout.php">LogOut</a>
                
            </nav>             
            <div class="imagen">
                <img src="images/ima1.png">
            </div>
        </div>
    </header>
    <div class="capa"></div>
    <input type="checkbox" id="btn-menu">
    <div class="container-menu">
        <div class="cont-menu">
            <nav>
                <a href="bpeques1.php" align="center">BASICO PEQUES</a>
                <a href="apeques1.php" align="center">AVANZADO PEQUES</a>
                <a href="ava1_1.php" align="center">AVANZADO I</a>
                <a href="ava2_1.php" align="center">AVANZADO II</a>
                <a href="ava3_1.php" align="center">AVANZADO III</a>
                <a href="inicp1.php" align="center">INICIANTE PEQUE</a>
                <a href="iniju1.php" align="center">INICIANTE JUNIOR</a>
                <a href="inica1.php" align="center">INICIANTE ADULTO</a>
                <a href="intera1.php" align="center">INTERMEDIO ADULTO</a>
                <a href="basia1.php" align="center">BASICO ADULTO</a>
                <a href="basijusa1.php" align="center">BASICO JUNIOR SABADO</a>
                <a href="inijusa1.php" align="center">INICIANTE JUNIOR SABADO</a>
                <a href="iniasa1.php" align="center">INICIANTE ADULTO SABADO</a>
                <a href="intersa1.php" align="center">INTERMEDIO SABADO</a>
            </nav>
            <label for="btn-menu">✖️</label>
        </div>
    </div>