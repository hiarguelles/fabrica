<?php
require_once("modelo/muestraCatalogos.php");
require_once("decodifica_redirect_.php");
$per = new muestraCatalogos('Brad_DesInteresate');

//$cat_calificaciones = $per->obtieneCalificacion();

$Desencript=encrypt_decrypt('decrypt',$_GET['CADENA']);
$cadenaFinal=explode("&",$Desencript);
//echo $Desencript;
if( explode("=",$cadenaFinal[0])[0]=="ID" ) {
    $ID=explode("=",$cadenaFinal[0])[1];
    $IDLLAMADA=explode("=",$cadenaFinal[1])[1];
    $AGENTE=explode("=",$cadenaFinal[2])[1];
    $datos=$per->obtenDatosOUT($ID);
    $cat_calificaciones=$per->obtieneTipoContacto();
}

if( explode("=",$cadenaFinal[0])[0]=="Telefono" ) {
    
    $TELEFONO=explode("=",$cadenaFinal[0])[1];
    $IDLLAMADA=explode("=",$cadenaFinal[1])[1];
    $AGENTE=explode("=",$cadenaFinal[2])[1];
    $datos=$per->obtenDatosIN($TELEFONO);
    $cat_calificaciones=$per->obtieneTipoContactoIN();
    $ID=$datos['ID_BaseOrigen'];
}  