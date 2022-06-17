<?php
require_once("modelo/modelTaken.php");
$taken= new classTaken();
$taken->getTaken($_GET['action'], $_GET['id']);
