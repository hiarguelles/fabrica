<?php
session_start();
require_once('controlador/funcionesGenerales.php');
require_once('modelo/muestraAjax.php');
require_once('modelo/classData.php');

switch ($_GET['action']){
    case 'bandeja':
        //recuperar variables en su caso
        $ajax  = new muestraAjax();
        $res = $ajax->GetTableData();
        echo json_encode($res);
       break;
}


