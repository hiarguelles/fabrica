<?php
session_start();
require_once('../modelo/conexion.php');
require_once('../modelo/classData.php');
if(!$_POST['hddID']) {
    echo 'No autorizado';
    die();
}
else{
    $data= new classData();
    $id= $_POST['hddID'];
    $user= $_SESSION['id_user'];

    foreach($_POST AS $key=>$value){
        echo 'DATOS='.$key.' => '.$value.'<br>';
    }
    //$data->insertData($arrayData){
    echo '<script type="text/javascript">';
    echo 'setVtaEval('.$id.', \''.$user.'\',\''.strftime('%r').'\');';
    echo '</script>';
}

