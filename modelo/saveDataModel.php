<?php
require_once 'conexion.php';

class saveDataModelTMK
{
    private $db;
    private $personas;

    public function __construct($base){
        $this->db = conexion2::conexionodbcPDO240($base);
        $this->personas=array();
    }


    public function generaCodigo(){
        $fecha=str_replace("/","",strftime('%d/%m/%Y'));
        $sqlFolio = "Select top 1 FolioVenta from Gestion where folioVenta is not null order by FechaGestion desc  ";
        $stmt = $this->db->prepare($sqlFolio);
        $stmt->execute();
        $resultadoExist = $stmt->fetchColumn();
        if($resultadoExist!=""){
            return $resultadoExist+1;
        }else{
            return $fecha.'0001';
        }
    }


    /**
     * Metodo que almacena los datos capturados en la etapa 1 que es la inicial en index
     * @param $data
     * @return array
     */
    public function guardaInteraccion($data)
    {
            //$telPreFinal=str_replace("[","",$data['TELEFONO']);
            $telFinal=str_replace('[', '', str_replace(']','', $data['TELEFONO']));
			$telFinal=str_replace('-', '', $telFinal);
			$telFinal= substr($telFinal,-10,10);

            $SQLInsertNicio="insert into Interacciones (TELEFONO,AGENTE,ID_DATOS,IDLLAMADA,LOTE,CAMPANA,FECHAINSERCION) values(:TELEFONO,:AGENTE,:ID_DATOS,:IDLLAMADA,:LOTE,:CAMPANA,getDate())";
            $stmt = $this->db->prepare($SQLInsertNicio);
            $stmt->bindParam(":TELEFONO", $telFinal, PDO::PARAM_STR);
            $stmt->bindParam(":AGENTE", $data['AGENTE'], PDO::PARAM_STR);
            $stmt->bindParam(":ID_DATOS", $data['ID_DATOS'], PDO::PARAM_STR);
            $stmt->bindParam(":IDLLAMADA", $data['INTERACTIONID'], PDO::PARAM_STR);
            $stmt->bindParam(":LOTE", $data['ID_LOTE'], PDO::PARAM_STR);
            $stmt->bindParam(":CAMPANA", $data['CAMPANA'], PDO::PARAM_STR);
            try{
            $stmt->execute();
        } catch (Exception $e) {
            echo 'Excepción capturada en insert interacion: ',  $e->getMessage(), "\n";
            die();
        }



    }

    public function guardaOut($data)
    {

        if(isset($data['calificacion']) && $data['calificacion']==10){
            $folioVenta=$this->generaCodigo();
        }else{
			$folioVenta=NULL;
		}

        $sqlreferencia = "Select Estatus from Cat_CalificacionesOUT where ID_Calificacion=CAST(CAST(:calificacion AS varchar) AS INTEGER);";

        $stmt = $this->db->prepare($sqlreferencia);
        $stmt->bindParam(":calificacion", $data['calificacion'], PDO::PARAM_INT);
        try{
            $stmt->execute();
            $flag=$stmt->fetchColumn();
        } catch (Exception $e) {
            echo 'Excepción capturada en select estatus: ',  $e->getMessage(), "\n";
        }

        $sqlVeriofExist = " Select count(*) as 'rest' from Gestion where ID_BaseOrigen=CAST(CAST(:ID AS varchar) AS INTEGER);";

        $stmt = $this->db->prepare($sqlVeriofExist);
        $stmt->bindParam(":ID", $data['ID'], PDO::PARAM_INT);

        try{
            $stmt->execute();
            $resultadoExist = $stmt->fetch();
        } catch (Exception $e) {
        echo 'Excepción capturada en exist: ',  $e->getMessage(), "\n";
        }
		//echo($resultadoExist[0]);

        if ( $resultadoExist[0]=='0') {
			
            if($data['calificacion']==""){
                 $data['calificacion']=NULL;
            }
			if($data['subcalificacion']==""){
                 $data['subcalificacion']=NULL;
			}

           /*echo("tiPoContactoOUT: ".$data['tiPoContactoOUT']."<br>");
            echo("calificacion: ".$data['calificacion']."<br>");
            echo("subcalificacion: ".$data['subcalificacion']."<br>");
            echo("comment: ".$data['comment']."<br>");
            echo("telefonoNuevoInput: ".$data['telefonoNuevoInput']."<br>");
            //echo("InputEmail: ".$data['InputEmailNuevo']."<br>");
            echo("Estatus: ".$flag."<br>");
            echo("ID: ".$data['ID']."<br>");
            echo("Folio venta: ".$folioVenta."<br>");
			echo("InputEmail: ".$data['InputEmail']."<br>");
            echo("FLAG: ".$flag."<br>");
            echo("ID: ".$data['ID']."<br>");
            echo("SMS: ".$data['CodSMSInput']."<br>");
			echo("Agente: ".$data['AGENTE']."<br>");
			echo("IDLamada: ".$data['IDLLAMADA']."<br>");*/
            $SQLinsertOUT="INSERT INTO [dbo].[Gestion]
               (TipoContacto
               ,Calificacion
               ,SubCalificacion
               ,Comentarios
               ,TelNuevo
               ,Correo
               ,FechaGestion
               ,Calificado
               ,Flag
               ,ID_BaseOrigen
               ,FolioVenta
               ,CodSMS
               ,Agente
               ,IDLamada
               )
                VALUES(
                :TipoContacto
                ,:Calificacion
                ,:SubCalificacion
                ,:Comentarios
                ,:TelNuevo
                
                ,:Correo
                ,getDate()
                ,'OUT'
                ,:Flag
                ,:ID_BaseOrigen
                ,:folioVenta
                ,:CodSMS
                ,:Agente
                ,:IDLamada)";
            $stmt = $this->db->prepare($SQLinsertOUT);
            $stmt->bindParam(":TipoContacto", $data['tiPoContactoOUT'], PDO::PARAM_STR);
            $stmt->bindParam(":Calificacion", $data['calificacion'], PDO::PARAM_STR);
            $stmt->bindParam(":SubCalificacion", $data['subcalificacion'], PDO::PARAM_STR);
            $stmt->bindParam(":Comentarios", $data['comment'], PDO::PARAM_STR);
            $stmt->bindParam(":TelNuevo", $data['telefonoNuevoInput'], PDO::PARAM_STR);
           // $stmt->bindParam(":MailNuevo", $data['InputEmailNuevo'], PDO::PARAM_STR);
            $stmt->bindParam(":Correo", $data['InputEmail'], PDO::PARAM_STR);
            $stmt->bindParam(":Flag", $flag, PDO::PARAM_STR);
            $stmt->bindParam(":ID_BaseOrigen", $data['ID'], PDO::PARAM_STR);
            $stmt->bindParam(":folioVenta", $folioVenta, PDO::PARAM_STR);
            $stmt->bindParam(":CodSMS", $data['CodSMSInput'], PDO::PARAM_STR);
            $stmt->bindParam(":Agente", $data['AGENTE'], PDO::PARAM_STR);
            $stmt->bindParam(":IDLamada", $data['IDLLAMADA'], PDO::PARAM_STR);
            try{
                $stmt->execute();
            } catch (Exception $e) {
                echo 'Excepción capturada inserta OUT: ',  $e->getMessage(), "\n";
            }

        }else{
            if($data['calificacion']==""){
                 $data['calificacion']=NULL;
            }
			if($data['subcalificacion']==""){
                 $data['subcalificacion']=NULL;
            }
           /* echo("tiPoContactoOUT: ".$data['tiPoContactoOUT']."<br>");
            echo("calificacion: ".$data['calificacion']."<br>");
            echo("subcalificacion: ".$data['subcalificacion']."<br>");
            echo("comment: ".$data['comment']."<br>");
            echo("telefonoNuevoInput: ".$data['telefonoNuevoInput']."<br>");
            //echo("InputEmailNuevo: ".$data['InputEmailNuevo']."<br>");
            echo("InputEmail: ".$data['InputEmail']."<br>");
            echo("Estatus: ".$flag."<br>");
            echo("ID: ".$data['ID']."<br>");
            echo("Folio venta: ".$folioVenta."<br>");*/
            $SQLUpdateOUT="Update Gestion SET
                TipoContacto=:TipoContacto
                ,Calificacion=:Calificacion
                ,SubCalificacion=:SubCalificacion
                ,TipoContactoIN=NULL
                ,CalificacionIN=NULL
                ,SubCalificacionIN=NULL
                ,Comentarios=:Comentarios
                ,TelNuevo=:TelNuevo
                ,Correo=:Correo
                ,FechaGestion=getDate()
                ,Calificado='OUT'
                ,Flag=:Flag
                ,FolioVenta=:FolioVenta
                ,CodSMS=:CodSMS
                ,Agente=:Agente
                ,IDLamada=:IDLamada
                where ID_BaseOrigen=:ID_BaseOrigen";
                $stmt = $this->db->prepare($SQLUpdateOUT);
                $stmt->bindParam(":TipoContacto", $data['tiPoContactoOUT'], PDO::PARAM_STR);
                $stmt->bindParam(":Calificacion", $data['calificacion'], PDO::PARAM_STR);
                $stmt->bindParam(":SubCalificacion", $data['subcalificacion'], PDO::PARAM_STR);
                $stmt->bindParam(":Comentarios", $data['comment'], PDO::PARAM_STR);
                $stmt->bindParam(":TelNuevo", $data['telefonoNuevoInput'], PDO::PARAM_STR);
              
                $stmt->bindParam(":Correo", $data['InputEmail'], PDO::PARAM_STR);
                $stmt->bindParam(":Flag", $flag, PDO::PARAM_STR);
                $stmt->bindParam(":ID_BaseOrigen", $data['ID'], PDO::PARAM_STR);
                $stmt->bindParam(":FolioVenta", $folioVenta, PDO::PARAM_STR);
                $stmt->bindParam(":CodSMS", $data['CodSMSInput'], PDO::PARAM_STR);
                $stmt->bindParam(":Agente", $data['AGENTE'], PDO::PARAM_STR);
                $stmt->bindParam(":IDLamada", $data['IDLLAMADA'], PDO::PARAM_STR);
            try{
                $stmt->execute();
            } catch (Exception $e) {
                echo 'Excepción capturada update OUT: ',  $e->getMessage(), "\n";
            }
        }

        $stmt = $this->db->prepare("SP_INSERTA_BITACORA_GESTION :id");
        $stmt->bindParam(":id", $data['ID'], PDO::PARAM_INT);
        try{
            $resultado = $stmt->execute();
            $stmt->closeCursor();
            } catch (Exception $e) {
                echo 'Excepción capturada SP_INSERTA_BITACORA_GESTION: ',  $e->getMessage(), "\n";
        }
        return true;

    }

    public function guardaIn($data)
    {
        if($data['calificacionIN']==5){
            $folioVenta=$this->generaCodigo();
            //echo($folioVenta);
        }else{
			$folioVenta=NULL;
		}

        $sqlreferencia = "Select Estatus from Cat_CalificacionesOUT where ID_Calificacion=CAST(CAST(:calificacion AS varchar) AS INTEGER);";

        $stmt = $this->db->prepare($sqlreferencia);
        $stmt->bindParam(":calificacion", $data['calificacionIN'], PDO::PARAM_INT);
        try{
            $stmt->execute();
            $flag=$stmt->fetchColumn();
        } catch (Exception $e) {
            echo 'Excepción capturada en select estatus: ',  $e->getMessage(), "\n";
        }

        $sqlVeriofExist = " Select count(*) as 'rest' from Gestion where ID_Gestion=CAST(CAST(:ID AS varchar) AS INTEGER);";

        $stmt = $this->db->prepare($sqlVeriofExist);
        $stmt->bindParam(":ID", $data['IDIN'], PDO::PARAM_INT);

        try{
            $stmt->execute();
            $resultadoExist = $stmt->fetch();
        } catch (Exception $e) {
        echo 'Excepción capturada en exist: ',  $e->getMessage(), "\n";
        }


        if ( $resultadoExist[0]=='0') {
            if($data['subcalificacionIN']==""){
                 $data['subcalificacionIN']=NULL;
            }

           /* echo("tiPoContactoOUT: ".$data['tiPoContactoOUT']."<br>");
            echo("calificacion: ".$data['calificacion']."<br>");
            echo("subcalificacion: ".$data['subcalificacion']."<br>");
            echo("comment: ".$data['comment']."<br>");
            echo("telefonoNuevoInput: ".$data['telefonoNuevoInput']."<br>");
            echo("InputEmailNuevo: ".$data['InputEmailNuevo']."<br>");
            echo("InputEmail: ".$data['InputEmail']."<br>");
            echo("Estatus: ".$flag."<br>");
            echo("ID: ".$data['ID']."<br>");
            echo("Folio venta: ".$folioVenta."<br>");*/
            $SQLinsertOUT="INSERT INTO [dbo].[Gestion]
               (TipoContacto
               ,Calificacion
               ,SubCalificacion
               ,TipoContactoIN
               ,CalificacionIN
               ,SubCalificacionIN
               ,Comentarios
               ,TelNuevo
               ,Correo
               ,FechaGestion
               ,Calificado
               ,Flag
               ,ID_BaseOrigen
               ,FolioVenta
               ,CodSMS
               ,Agente
               )
                VALUES(
                NULL
                ,NULL
                ,NULL
                ,:TipoContactoIN
                ,:CalificacionIN
                ,:SubCalificacionIN
                ,:Comentarios
                ,:TelNuevo
                ,:Correo
                ,getDate()
                ,'IN'
                ,:Flag
                ,:ID_BaseOrigen
                ,:folioVenta
                ,:CodSMS
                ,:Agente
                ,:IDLamada)";
            $stmt = $this->db->prepare($SQLinsertOUT);
            $stmt->bindParam(":TipoContactoIN", $data['tiPoContactoIN'], PDO::PARAM_STR);
            $stmt->bindParam(":CalificacionIN", $data['calificacionIN'], PDO::PARAM_STR);
            $stmt->bindParam(":CalificacionIN", $data['subcalificacionIN'], PDO::PARAM_STR);
            $stmt->bindParam(":Comentarios", $data['commentIN'], PDO::PARAM_STR);
            $stmt->bindParam(":TelNuevo", $data['telefonoNuevoInputIN'], PDO::PARAM_STR);
            $stmt->bindParam(":Correo", $data['InputEmailIN'], PDO::PARAM_STR);
            $stmt->bindParam(":Flag", $flag, PDO::PARAM_STR);
            $stmt->bindParam(":ID_BaseOrigen", $data['IDIN'], PDO::PARAM_STR);
            $stmt->bindParam(":folioVenta", $folioVenta, PDO::PARAM_STR);
            $stmt->bindParam(":CodSMSIN", $data['codigoIN'], PDO::PARAM_STR);
            $stmt->bindParam(":Agente", $data['AGETEIN'], PDO::PARAM_STR);
            $stmt->bindParam(":IDLamada", $data['IDLLAMADAIN'], PDO::PARAM_STR);
            try{
                $stmt->execute();
            } catch (Exception $e) {
                echo 'Excepción capturada inserta IN: ',  $e->getMessage(), "\n";
            }

        }else{
            if($data['subcalificacionIN']==""){
                 $data['subcalificacionIN']=NULL;
            }
            /*echo("tiPoContactoOUT: ".$data['tiPoContactoIN']."<br>");
            echo("calificacion: ".$data['calificacionIN']."<br>");
            echo("subcalificacion: ".$data['subcalificacionIN']."<br>");
            echo("comment: ".$data['commentIN']."<br>");
            echo("telefonoNuevoInput: ".$data['telefonoNuevoInputIN']."<br>");
            echo("InputEmailNuevo: ".$data['InputEmailNuevo']."<br>");
            echo("InputEmail: ".$data['InputEmailIN']."<br>");
            echo("flag: ".$flag."<br>");
            echo("ID: ".$data['IDIN']."<br>");
            echo("Folio venta: ".$folioVenta."<br>");
            echo("codigoIN: ".$data['codigoIN']."<br>");
            echo("AGENTEIN: ".$data['AGENTEIN']."<br>");
            echo("IDLLAMADAIN: ".$data['IDLLAMADAIN']."<br>");*/
            $SQLUpdateOUT="Update Gestion SET
                TipoContacto=NULL
                ,Calificacion=NULL
                ,SubCalificacion=NULL
                ,TipoContactoIN=:TipoContactoIN
                ,CalificacionIN=:CalificacionIN
                ,SubCalificacionIN=:SubCalificacionIN
                ,Comentarios=:Comentarios
                ,TelNuevo=:TelNuevo
                ,Correo=:Correo
                ,FechaGestion=getDate()
                ,Calificado='IN'
                ,Flag=:Flag
                ,FolioVenta=:FolioVenta
                ,CodSMS=:CodSMSIN
                ,Agente=:Agente
                ,IDLamada=:IDLamada
                where ID_BaseOrigen=:ID_BaseOrigen";
                $stmt = $this->db->prepare($SQLUpdateOUT);
            $stmt->bindParam(":TipoContactoIN", $data['tiPoContactoIN'], PDO::PARAM_STR);
            $stmt->bindParam(":CalificacionIN", $data['calificacionIN'], PDO::PARAM_STR);
            $stmt->bindParam(":SubCalificacionIN", $data['subcalificacionIN'], PDO::PARAM_STR);
            $stmt->bindParam(":Comentarios", $data['commentIN'], PDO::PARAM_STR);
            $stmt->bindParam(":TelNuevo", $data['telefonoNuevoInputIN'], PDO::PARAM_STR);
            $stmt->bindParam(":Correo", $data['InputEmailIN'], PDO::PARAM_STR);
            $stmt->bindParam(":Flag", $flag, PDO::PARAM_STR);
            $stmt->bindParam(":ID_BaseOrigen", $data['IDIN'], PDO::PARAM_STR);
            $stmt->bindParam(":FolioVenta", $folioVenta, PDO::PARAM_STR);
            $stmt->bindParam(":CodSMSIN", $data['codigoIN'], PDO::PARAM_STR);
            $stmt->bindParam(":Agente", $data['AGENTEIN'], PDO::PARAM_STR);
            $stmt->bindParam(":IDLamada", $data['IDLLAMADAIN'], PDO::PARAM_STR);
            try{
                $stmt->execute();
            } catch (Exception $e) {
                echo 'Excepción capturada update IN: ',  $e->getMessage(), "\n";
            }
        }
        $stmt = $this->db->prepare("SP_INSERTA_BITACORA_GESTION CAST(CAST(:id AS varchar) AS INTEGER)");
        $stmt->bindParam(":id", $data['ID'], PDO::PARAM_INT);
        try{
            $resultado = $stmt->execute();
            $stmt->closeCursor();
            } catch (Exception $e) {
                echo 'Excepción capturada SP_INSERTA_BITACORA_GESTION: ',  $e->getMessage(), "\n";
        }
        return true;
    }
}