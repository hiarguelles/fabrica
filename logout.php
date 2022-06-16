<?php
session_start();
require_once "controlador/funcionesGenerales.php";
$logout = new funcionesGenerales();
$logout->destroySession();
header("Location: index.php");
