
<!doctype html>
<html lang="es">
<head>
<script src="../js/generadatosajax.js"></script>
<script src="../js/jquery-3.6.0.min.js"></script>
    <script src="../js/jquery-ui.min.js"></script>
</head>

<?php
session_start();

require_once "../modelo/saveDataModel.php";

//require_once "../../controller/funcionesGenerales.php";

if(isset($_GET['action']) && $_GET['action'] == 'guardaOUT'){

    $mEstado = new saveDataModelTMK('Brad_DesInteresate');
    $res = $mEstado->guardaOut($_POST);

    if($_POST['calificacion']==40 || $_POST['calificacion']==41){
        echo('<script>
        enviaSMS(2,\''.$_POST['NOMBREORIGEN'].'\',\''.$_POST['TELEFONOORIGEN'].'\',\''.$_POST['PRODORIGEN'].'\');
        </script>');
    }


    echo('<script>
        alert("Datos Guardados");  
		window.close();
        </script>');

}


if(isset($_GET['action']) && $_GET['action'] == 'guardaIN'){

    $mEstado = new saveDataModelTMK('Brad_DesInteresate');
    $res = $mEstado->guardaIn($_POST);
    echo('<script>
        alert("Datos Guardados");
		window.close();
        </script>');

}

