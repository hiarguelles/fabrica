<?php
require_once("../modelo/bloqueo.php");
$b= new bloqueo();
$b->bloquear($_GET['action'], $_GET['id']);
