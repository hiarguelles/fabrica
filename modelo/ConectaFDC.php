<?php
require_once ("conexion.php");

class ConectaFDC
{
    public $BDD;
    public function __construct(){
        $this->BDD = conexion::conexionPDOSQL();
    }
    //agregar metodos

}
