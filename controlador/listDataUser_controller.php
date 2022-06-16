<?php
require_once("modelo/listDataUsers.php");
require_once "decodifica_redirect_.php";


    //id,nusr,

    $datauser = new listDataUsers('Brad_DesInteresate');
    $lisusersvalidation = $datauser->listUsuerDataValidation(0,"");

