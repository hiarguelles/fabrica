<?php
require_once "../modelo/muestraAjax.php";
//require_once "../modelo/listDataUsers.php";

/*if(isset($_POST['accion'])){

}*/

if(isset($_POST['accion']) && $_POST['accion'] == 'tiPoContactoOUT'){

    if(!empty($_POST['estatus1'])){
        $mEstado = new muestraAjax('Brad_DesInteresate');
        $res = $mEstado->obtenCalificacionOUT($_POST['estatus1']);
        echo $res;
    }

    echo false;
}

if(isset($_POST['accion']) && $_POST['accion'] == 'tiPoContactoIN'){

    if(!empty($_POST['estatus1'])){
        $mEstado = new muestraAjax('Brad_DesInteresate');
        $res = $mEstado->obtenCalificacionIN($_POST['estatus1']);
        echo $res;
    }

    echo false;
}

if(isset($_POST['accion']) && $_POST['accion'] == 'subCalificacion'){

    if(!empty($_POST['estatus1'])){
        $mEstado = new muestraAjax('Brad_DesInteresate');
        $res = $mEstado->obtenSubCalificacion($_POST['estatus1']);
        echo $res;
    }

    echo false;
}

if(isset($_POST['accion']) && $_POST['accion'] == 'subCalificacionIn'){

    if(!empty($_POST['calificacionIN'])){
        $mEstado = new muestraAjax('Brad_DesInteresate');
        $res = $mEstado->obtenSubCalificacionIN($_POST['calificacionIN']);
        echo $res;
    }

    echo false;
}





