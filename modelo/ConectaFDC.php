<?php
require_once ("conexion.php");

class ConectaFDC
{
    private $BDD;
    public function __construct(){
        $this->BDD = conexion::conexionPDOSQL();
    }
    //agregar metodos

}
