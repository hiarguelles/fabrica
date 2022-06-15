<?php
session_start();
require_once 'modelo/Logginuser.php';
require_once 'modelo/Conecta240.php';
require_once "controller/funcionesGenerales.php";

$destroySession = new funcionesGenerales();
$destroySession->destroySession();
$destroySession->deslogueauser($_SESSION['idusuario']);

$conexion240 = new Conecta240('MegaAmexOnline');
$conexion240->updateBitacoraLoggout($_SESSION['idusuario'],1);

header("Location: index.php?msg=22");
