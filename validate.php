<?php
session_start();
include_once('app_data/functions.php');
if (!empty($_POST['user']) && !empty($_POST['password'])) {
    $secret="BDF";
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
    die();
}
else{
    $url="index.php?&message=errorPOST";
    header("location: $url");
    die();
}