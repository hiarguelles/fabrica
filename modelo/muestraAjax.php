<?php
require_once 'conexion.php';

class muestraAjax
{
    private $BDD;
    public function __construct(){
        $this->BDD = conexion:: conexionPDOSQL();
    }
    public function GetTableData(){
        //$encrypt= encrypt($pass, "FDC");
        $sql = "SELECT fecha, socio, caso, solicitud, status, hit, perfil, motivo FROM BASEoRIGEN";
        $stmt = $this->BDD->prepare($sql);
        //$stmt->bindParam(":u", $user, PDO::PARAM_STR);
        //$stmt->bindParam(":p", $encrypt, PDO::PARAM_STR);
        $stmt->execute();
        $res = $stmt->fetchAll();
        if(count($res)>0){
            $html= "<table class=\"table table-bordered table-hover table-striped\"";
            $html.="<tr style=\"font-size: 10px\">";
            $html.="<td>fecha</td>";
            $html.="<td>socio</td>";
            $html.="<td>caso</td>";
            $html.="<td>solicitud</td>";
            $html.="<td>status</td>";
            $html.="<td>hit</td>";
            $html.="<td>perfil</td>";
            $html.="<td>motivo</td>";
            $html.="</tr>";

            foreach($res as $item){
                $html.="<tr style=\"font-size: 9px\">";
                    $html.="<td>".$item["fecha"]."</td>";
                    $html.="<td>".$item["socio"]."</td>";
                    $html.="<td>".$item["caso"]."</td>";
                    $html.="<td>".$item["solicitud"]."</td>";
                    $html.="<td>".$item["status"]."</td>";
                    $html.="<td>".$item["hit"]."</td>";
                    $html.="<td>".$item["perfil"]."</td>";
                    $html.="<td>".$item["motivo"]."</td>";
                $html.="</tr>";
            }
            $html.= "</table>";
            return $html;
        }
        else {
            return "No hay datos para mostrar";
        }
    }

    public function obtenSubCalificacion($index){
        $numResult = '';

        $sql = "  select ID_Calificacion,Descripcion,Referencia from Cat_CalificacionesOUT where Subcalificacion=1 and activo=1 and Referencia =:id ;";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $index, PDO::PARAM_INT);
        $stmt->execute();

        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $numResult = count( $resultado );

        if ( !empty($resultado) ) {

            $respuestaHtml = "";
            $respuestaHtml .= " <select class='form-control' id='subcalificacion' name='subcalificacion'> ";
            $respuestaHtml .= " <option value=''>Selecciona una Opción</option>";

            if( $numResult > 1 ){
                foreach ($resultado as $estatusVentaCierre2){
                    $respuestaHtml .= " <option value='{$estatusVentaCierre2['ID_Calificacion']}'>" . utf8_encode($estatusVentaCierre2['Descripcion']) . "</option>";
                }

            }else{
                $respuestaHtml .= " <option value='{$resultado[0]['ID_Calificacion']}' checked='checked'>" . $resultado[0]['Descripcion'] . "</option>";
            }

            $respuestaHtml .= "  </select>";

            return $respuestaHtml;
        }

        return '';
    }

    public function obtenSubCalificacionIN($index){
        $numResult = '';

        $sql = "  select ID_Calificacion,Descripcion,Referencia From Cat_CalificacionesIN where Subcalificacion=1 and activo=1 and Referencia =:id ;";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $index, PDO::PARAM_INT);
        $stmt->execute();

        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $numResult = count( $resultado );

        if ( !empty($resultado) ) {

            $respuestaHtml = "";
            $respuestaHtml .= " <select class='form-control' id='subcalificacionIN' name='subcalificacionIN'> ";
            $respuestaHtml .= " <option value=''>Selecciona una Opción</option>";

            if( $numResult > 1 ){
                foreach ($resultado as $estatusVentaCierre2){
                    $respuestaHtml .= " <option value='{$estatusVentaCierre2['ID_Calificacion']}'>" . utf8_encode($estatusVentaCierre2['Descripcion']) . "</option>";
                }

            }else{
                $respuestaHtml .= " <option value='{$resultado[0]['ID_Calificacion']}' checked='checked'>" . $resultado[0]['Descripcion'] . "</option>";
            }

            $respuestaHtml .= "  </select>";

            return $respuestaHtml;
        }

        return $index;
    }

}