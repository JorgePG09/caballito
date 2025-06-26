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
                <a href="bpeques.php" align="center">BASICO PEQUES</a>
                <a href="apeques.php" align="center">AVANZADO PEQUES</a>
                <a href="ava1.php" align="center">AVANZADO I</a>
                <a href="ava2.php" align="center">AVANZADO II</a>
                <a href="ava3.php" align="center">AVANZADO III</a>
                <a href="inicp.php" align="center">INICIANTE PEQUE</a>
                <a href="iniju.php" align="center">INICIANTE JUNIOR</a>
                <a href="inica.php" align="center">INICIANTE ADULTO</a>
                <a href="intera.php" align="center">INTERMEDIO ADULTO</a>
                <a href="basia.php" align="center">BASICO ADULTO</a>
                <a href="basijusa.php" align="center">BASICO JUNIOR SABADO</a>
                <a href="inijusa.php" align="center">INICIANTE JUNIOR SABADO</a>
                <a href="iniasa.php" align="center">INICIANTE ADULTO SABADO</a>
                <a href="intersa.php" align="center">INTERMEDIO SABADO</a>
            </nav>
            <label for="btn-menu">✖️</label>
        </div>
    </div>