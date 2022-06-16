<?php
require_once 'conexion.php';

    class muestraCatalogos
    {
        private $db;
        private $personas;

        public function __construct($base){
            $this->db = conexion2::conexionodbcPDO240($base);
            $this->personas=array();
        }

        public function obtenDatosOUT($id){

            $sql = "select * from BaseOrigen where ID_BaseOrigen=CAST(CAST(:ID_BaseOrigen AS varchar) AS INTEGER)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":ID_BaseOrigen", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $resultado = $stmt->fetch(PDO::FETCH_ASSOC);


        }

        public function obtenDatosIN($tel){
            $string="%$tel%";
            $sql = "select TOP 1 BO.*, gest.TelNuevo from BaseOrigen BO
            left join Gestion gest on gest.ID_BaseOrigen= BO.ID_BaseOrigen
             where TelCasa like :TelCasa or Cel like :Cel or gest.TelNuevo like :TelNuevo";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":TelCasa", $string, PDO::PARAM_INT);
            $stmt->bindParam(":Cel", $string, PDO::PARAM_INT);
            $stmt->bindParam(":TelNuevo", $string, PDO::PARAM_INT);
            $stmt->execute();
            return $resultado = $stmt->fetch(PDO::FETCH_ASSOC);


        }


        public function obtieneTipoContacto(){

            $sql = "select * from Cat_CalificacionesOUT where activo=1 and TipoContacto=1;";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();

            return $resultado = $stmt->fetchAll();

        }

        public function obtieneTipoContactoIN(){

            $sql = "select * from Cat_CalificacionesIN where activo=1 and TipoContacto=1;";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();

            return $resultado = $stmt->fetchAll();

        }
    }