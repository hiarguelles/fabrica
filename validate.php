<?php
session_start();
require_once('controlador/funcionesGenerales.php');
require_once('modelo/LogUser.php');
require_once('modelo/ConectaFDC.php');

if (!empty($_POST['txtUser']) && !empty($_POST['txtPass'])) {

    $conn  = new LogUser();
    $connectSQL  = new ConectaFDC();
    $u= $_POST['txtUser'];
    $p=$_POST['txtPass'];
    $res = $conn->validaUsuario($u, $p);


    /*$secret="BDF";
    //$conexion  = new Logginuser('amex_online');
    //$conecta240  = new Conecta240('MegaAmexOnline');
    //$result = $conexion->validaUsser($_POST['usser'],$_POST['password']);
    $u= $_POST['user'];
    $p= $_POST['password'];
    $f= encrypt($p, $secret) ;
    if($u=="agente01" && $p=="user*12345"){
        $_SESSION['id_user']= $u;
        $_SESSION['menu']= "agente";
        $url="index.php?&message=OK";   
        //create session
        //redirect to menu.index.php    
        $url="fabrica_main.php";
    }
    else{
        $url="index.php?&message=".$f;
    }
    header("location: $url");
    die();*/
}
else{
    $url="index.php?&message=errorPOST";
    header("location: $url");
    die();
}