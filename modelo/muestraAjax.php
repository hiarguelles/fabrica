<?php
require_once 'conexion.php';
require_once '../decodifica_redirect_.php';

class muestraAjax
{
    private $db;
    private $personas;

    public function __construct($base){
        $this->db = conexion2::conexionodbcPDO240($base);
        $this->personas=array();
    }



     public function obtenCalificacionOUT($index){
        $numResult = '';

        $sql = "  select ID_Calificacion,Descripcion,Referencia from Cat_CalificacionesOUT where Calificacion=1 and activo=1 and Referencia =:id ;";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $index, PDO::PARAM_INT);
        $stmt->execute();

        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $numResult = count( $resultado );

        if ( !empty($resultado) ) {

            $respuestaHtml = "";
            $respuestaHtml .= " <select class='form-control' id='calificacion' name='calificacion'> ";
            $respuestaHtml .= " <option value=''>Selecciona una Opción</option>";

            if( $numResult > 1 ){
                foreach ($resultado as $estatusVentaCierre2){
                    $respuestaHtml .= " <option value='{$estatusVentaCierre2['ID_Calificacion']}'>" . $estatusVentaCierre2['Descripcion'] . "</option>";
                }

            }else{
                $respuestaHtml .= " <option value='{$resultado[0]['ID_Calificacion']}' checked='checked'>" . $resultado[0]['Descripcion'] . "</option>";
            }

            $respuestaHtml .= "  </select>";

            return $respuestaHtml;
        }

        return '';
    }

         public function obtenCalificacionIN($index){
        $numResult = '';

        $sql = "  select ID_Calificacion,Descripcion,Referencia from Cat_CalificacionesIN where Calificacion=1 and activo=1 and Referencia =:id ;";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $index, PDO::PARAM_INT);
        $stmt->execute();

        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $numResult = count( $resultado );

        if ( !empty($resultado) ) {

            $respuestaHtml = "";
            $respuestaHtml .= " <select class='form-control' id='calificacionIN' name='calificacionIN'> ";
            $respuestaHtml .= " <option value=''>Selecciona una Opción</option>";

            if( $numResult > 1 ){
                foreach ($resultado as $estatusVentaCierre2){
                    $respuestaHtml .= " <option value='{$estatusVentaCierre2['ID_Calificacion']}'>" . $estatusVentaCierre2['Descripcion'] . "</option>";
                }

            }else{
                $respuestaHtml .= " <option value='{$resultado[0]['ID_Calificacion']}' checked='checked'>" . $resultado[0]['Descripcion'] . "</option>";
            }

            $respuestaHtml .= "  </select>";

            return $respuestaHtml;
        }

        return '';
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