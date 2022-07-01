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
    $array=array();
    $id= $_POST['hddID'];
    $id_user= $_SESSION['id_user'];
    $id_evaluacion= is_null($_POST['checkIden']) ? '0' : '1';
    $caso= $id;
    $identificacion= is_null($_POST['checkIden']) ? '0' : '1';
    $talon = !isset($_POST['checkTalon']) ? '0' : '1';
    $foto = !isset($_POST['checkFoto']) ? '0' : '1';
    $contrato= !isset($_POST['checkCon']) ? '0' : '1';
    $firma = !isset($_POST['checkFirma']) ? '0' : '1';
    $privacidad= !isset($_POST['checkPriv']) ? '0' : '1';
    $comentarios= !isset($_POST['txtComenta']) ? 'Sin observaciones' : trim($_POST['txtComenta']);

    $sql= "INSERT INTO EVALUACION(caso, id_usuario, fecha,";
    $sql.= " identificacion, talon, foto,  ";
    $sql.= " contrato, firma, privacidad, ";
    $sql.= " comentarios)VALUES(";
    $sql.= " ?, ?, CURRENT_TIMESTAMP, ";
    $sql.= " ?, ?, ?, ?, ?, ?, ?);";
    $arrayTMP= array("query" => $sql, "params" => array( $caso, $id_user, $identificacion, $talon, $foto, $contrato, $firma, $privacidad, $comentarios));
    array_push($array, $arrayTMP);

    //LIBERAR VENTA
    $sql= "UPDATE  tabla_bloqueo ";
    $sql.= " SET status_lock='F', id_usuario=?, fec_lock= CURRENT_TIMESTAMP ";
    $sql.= " WHERE caso=? AND id_usuario=? AND status_lock='T' ";
    $arrayTMP= array("query" => $sql, "params" => array($id_user, $id, $id_user));
    array_push(	$array, $arrayTMP);
    //MARCAR VENTA EVALUADA
    $sql= "UPDATE  BaseOrigen  SET validado=1 WHERE caso=?";
    $arrayTMP= array("query" => $sql, "params" => array($id));
    array_push(	$array, $arrayTMP);

    //INSERT ARRAY SQL'S
    if($data->insertDataPDO($array, false)){
        echo '<script type="text/javascript">';
        echo "alert('Evaluación grabada correctamente');";
        echo 'window.opener.setVtaEval('.$id.', \''.$id_user.'\',\''.strftime('%r').'\');';
        echo 'window.close();';
        echo '</script>';
        exit();
    }
    else{
        exit();
    }

}

