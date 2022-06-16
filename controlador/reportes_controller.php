<?php
require_once("modelo/listDataUsers.php");
$per = new listDataUsers('Brad_DesInteresate');

$arrayHeaders= array();

$time= strftime('%d/%m/%Y %r');
$fec_ini= isset($_GET['fec_ini']) ? $_GET['fec_ini'] : strftime('01/%m/%Y');
$fec_fin= isset($_GET['fec_fin']) ? $_GET['fec_fin'] : strftime('%d/%m/%Y');
$reporte=$per->validateAccessModuleRep($_SESSION['idusuario']);
if(isset($_GET['report'])){
    if($_GET['report']==1){
        $arraResult=$per->getReporteGeneral($fec_ini,$fec_fin);
        unset($arrayHeaders);
        $arrayHeaders= array();
        array_push($arrayHeaders, "Cuenta",  "Tarjeta", "Nombre", "Producto", "Edad",  "Campaña",
     "Calificado","FechaCalificacion");
    }
}else{
    $arraResult=$per->getReporteGeneral($fec_ini,$fec_fin);
    unset($arrayHeaders);
    $arrayHeaders= array();
    array_push($arrayHeaders, "Cuenta",  "Tarjeta", "Nombre", "Producto", "Edad",  "Campaña",
 "Calificado","FechaCalificacion");
}