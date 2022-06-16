<?php
class conexion{

    static public function conexionPDOSQL(){
        @define("BDD", "brad_fabrica");
        @define("USER",  "webser");
        @define("PASS", "w3bS3r*FDC");
        @define("IP", "DESKTOP-CBR9L2J\SQLEXPRESS");
        try {
            $conn = new PDO("sqlsrv:server=".IP.";database=".BDD, USER, PASS);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            echo "Ocurrió un error con la base de datos: " . $e->getMessage();
            exit;
        }
        return $conn;
    }
}