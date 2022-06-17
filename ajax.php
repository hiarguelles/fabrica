<?php
session_start();
require_once('controlador/funcionesGenerales.php');
require_once('modelo/muestraAjax.php');
require_once('modelo/ConectaFDC.php');

switch ($_GET['action']){
    case 'bandeja':
        //recuperar variables en su caso
        $ajax  = new muestraAjax();
        $connectSQL  = new ConectaFDC();
        $res = $ajax->GetTableData();
        echo $res;
       break;
}


