<?php
require_once 'conexion.php';

class listDataUsers
{
    private $db;
    private $personas;

    public function __construct($base){
        $this->db = conexion2::conexionodbcPDO240($base);
        $this->personas=array();
    }

    public function getReporteGeneral($inicio, $fin){

            $dateini = date_create(str_replace("/","-",$inicio));
            $dateend = date_create(str_replace("/","-",$fin));
            $fechainiFInal=date_format($dateini,'Y-m-d H:i:s');
            $fechafinFInal=date_format($dateend,'Y-m-d H:i:s');
        $arrayQuery= array();
        $sql="exec SP_GENERA_GESTION_LLAMADAS :FechaInicio,:FechaFin ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":FechaInicio", $fechainiFInal,PDO::PARAM_STR);
        $stmt->bindParam(":FechaFin", $fechafinFInal,PDO::PARAM_STR);

        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $row;
    }

        public function validateAccessModuleRep($user){

        $arrayQuery= array();
        $sql=" select cat.Nombre,cat.ID_Reporte from Reporte_user usr left join Cat_Reportes cat on cat.ID_Reporte=usr.Reporte where usr.ID_Usario=:user and cat.activo=1" ;
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":user", $user,PDO::PARAM_STR);
        $stmt->execute();
        $resultado = $stmt->fetchAll();
        return $resultado;
    }

}