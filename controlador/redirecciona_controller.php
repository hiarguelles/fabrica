<?php
require_once("modelo/saveDataModel.php");
require_once("decodifica_redirect_.php");
$per = new saveDataModelTMK('Brad_DesInteresate');

$per->guardaInteraccion($_GET);

if(isset($_GET['CAMPANA']) && ($_GET['CAMPANA']=='CMP_Desinteresate'|| $_GET['CAMPANA']=='CMP_Desinteresate2' || $_GET['CAMPANA']=='cmp_brad_desinteresate') ){
    
    if(!empty($_GET['ID_DATOS'])){
        $cadena=encrypt_decrypt('encrypt','ID='.$_GET['ID_DATOS'].'&IDLLAMDA='.$_GET['INTERACTIONID'].'&AGENTE='.$_GET['AGENTE']);
            header('Location: ../outLead.php?&CADENA='.$cadena);
        }else{
            $cadena=encrypt_decrypt('encrypt','Telefono='.$_GET['TELEFONO'].'&IDLLAMDA='.$_GET['INTERACTIONID'].'&AGENTE='.$_GET['AGENTE']);
            header('Location: ../outLead.php?&CADENA='.$cadena);
        }
      
}

if(isset($_GET['CAMPANA']) && ($_GET['CAMPANA']=='CMP_Desinteresate_INB'  )){
    $cadena=encrypt_decrypt('encrypt','Telefono='.$_GET['TELEFONO'].'&IDLLAMDA='.$_GET['INTERACTIONID'].'&AGENTE='.$_GET['AGENTE']);
    header('Location: ../brad_desinteresate/inLead.php?&CADENA='.$cadena);
}
?>