<?php
session_start();
require_once('controlador/funcionesGenerales.php');
require_once('modelo/muestraAjax.php');
require_once('modelo/classData.php');

switch ($_GET['action']){
    case 'bandeja':
        //recuperar variables en su caso
        $search= isset($_GET['search']) ? $_GET['search'] : '';
        $ajax  = new muestraAjax();
        $res = $ajax->GetTableData($search);
        echo json_encode($res);
       break;
}


