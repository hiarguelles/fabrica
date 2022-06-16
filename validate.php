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

    if(count($res)>0){
        $_SESSION['id_user']=$res[0]['id_usuario'];
        $_SESSION['agente']=$res[0]['usuario'];
        $_SESSION['puesto']=$res[0]['puesto'];
        $_SESSION['menu']=$res[0]['menu'];
        header("location: fabrica_main.php");
        die();
    }
    else{
        $url="index.php?&message=errorUSU";
        header("location: $url");
        die();
    }


}
else{
    $url="index.php?&message=errorPOST";
    header("location: $url");
    die();
}