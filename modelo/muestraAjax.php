<?php
require_once 'conexion.php';

class muestraAjax
{
    private $BDD;
    public function __construct(){
        $this->BDD = conexion:: conexionPDOSQL();
    }

    public function GetTableData($search){
        $sql = "SELECT  row_number() over(order by socio) as fila, fecha, socio, caso, solicitud,";
        $sql.= " status, hit, perfil, motivo, nombre, ";
        $sql.= " COALESCE((select top(1) concat(TB.status_lock, '|', U.nombre,'|', convert(varchar, fec_lock, 113), '|', U.id_usuario) ";
        $sql.= " from tabla_bloqueo TB inner join usuarios U on (TB.id_usuario=U.id_usuario)";
        $sql.= " WHERE TB.caso=B.CASO and status_LOCK in('T', 'R')), '')  as 'proceso' ";
        $sql.= " FROM BASEoRIGEN B ";
        $sql.= " WHERE B.CASO NOT IN(SELECT CASO FROM EVALUACION)";
        //SEARCH
        if($search!=""){
            $sql.= " AND concat(nombre, CASO, SOLICITUD) LIKE '%".$search."%'";
        }
        $stmt = $this->BDD->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll();
        if(count($res)>0){

            return $res;
        }
        else {
            return 'No hay datos para mostrar';
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