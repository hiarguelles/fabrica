<?php
class conexion2{

    static public function conexionodbcPDO240(){
        $db = "";
        define("CONTRASENA", "");
        define("USUARIO",  "");
        define("DB", "$db");
        define("IP", "10.254.10.11");
        define("PUERTO", "1433");
        try {
            $conn = new PDO("sqlsrv:Server=".IP.",".PUERTO.";Database=".DB, USUARIO,CONTRASENA);
            $conn->setAttribute(PDO::SQLSRV_ATTR_ENCODING, PDO::SQLSRV_ENCODING_UTF8);
        } catch (Exception $e) {
            echo "Ocurrio un error con la base de datos: " . $e->getMessage();
            exit;
        }
        return $conn;
    }

    

}