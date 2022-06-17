<?php
require_once("conexion.php");
require_once("controlador/functions.php");
class LogUser
{
    public $conexion;
    private $BDD;

    public function __construct()
    {
        $this->BDD = conexion::conexionPDOSQL();
    }

    /*VALIDAR USUARIO EN BDD  */
    public function validaUsuario($user, $pass)
    {
        $encrypt= encrypt($pass, "FDC");
        $sql = "select id_usuario, lower(usuario)as usuario, puesto, menu, nombre ";
        $sql .= " from usuarios where lower(usuario)=:u and pass=:p";
        $stmt = $this->BDD->prepare($sql);
        $stmt->bindParam(":u", $user, PDO::PARAM_STR);
        $stmt->bindParam(":p", $encrypt, PDO::PARAM_STR);
        $stmt->execute();

        $res = $stmt->fetchAll();
        //print_r($res);
        return $res;
    }


}