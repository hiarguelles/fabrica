<?php
require_once 'conexion.php';
require_once 'classData.php';
class classTaken{
    private $db;
    public function __construct(){
        $this->db = conexion::conexionPDOSQL();
    }
    public function getTaken($action, $id){
        $data= new classData();
        $id= encrypt_decrypt('decrypt',$id);
        $user= $_SESSION['idusuario'];
        $fecha= strftime('%H:%M');
        echo 'Venta: '.$id.'<br>';
        switch(trim(strtoupper($_GET['action']))){
            case 'TAKEN':	//Intentar tomar venta
                $sql="SELECT count(1) as contador FROM MegaAmexLongApp.dbo.tc_amex_lock ";
                $sql.=" where fk_id_amex=:id and status_lock='T' and idusuario not in(:user)";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(":user", $user, PDO::PARAM_STR);
                $stmt->bindParam(":id", $id, PDO::PARAM_STR);
                $stmt->execute();
                $result= $stmt->fetchAll();

                switch($result[0]['contador']){
                    case '0':	//VENTA LIBRE,
                        //VERIFICAR QUE EL VALIDADOR NO TENGA OTRA VENTA TOMADA
                        $sql=" SELECT top(1) fk_id_amex FROM  MegaAmexLongApp.dbo.tc_amex_lock WHERE idusuario=:user ";
                        $sql.=" and status_lock='T' and fk_id_amex not in(:id) ";
                        $stmt = $this->db->prepare($sql);
                        $stmt->bindParam(":user", $user, PDO::PARAM_STR);
                        $stmt->bindParam(":id", $id, PDO::PARAM_STR);
                        $stmt->execute();
                        $result= $stmt->fetch();
                        if($result!=""){
                            echo 'Usted ya tiene otra venta abierta ID='.$result[0];
                            die();
                        }
                        //TOMAR VENTA;
                        $sql= "INSERT INTO  MegaAmexLongApp.dbo.tc_amex_lock ";
                        $sql.= " (fk_id_amex, idusuario, fec_lock, status_lock, actusuario)VALUES(";
                        $sql.= " :id, :user, CURRENT_TIMESTAMP, 'T', :user2 );";
                        $stmt = $this->db->prepare($sql);
                        $stmt->bindParam(":user", $user, PDO::PARAM_STR);
                        $stmt->bindParam(":user2", $user, PDO::PARAM_STR);
                        $stmt->bindParam(":id", $id, PDO::PARAM_STR);

                        if($stmt->execute()){
                            $url= 'frmCapturaLong.php?&id='.$_GET['id'];
                            echo '<script type="text/javascript">';
                            echo 'window.opener.setVtaTaken(\''.$id.'\', \''.$user.'\', \''.$fecha.'\');';
                            echo "window.location='".$url."';";
                            echo '</script>';
                            exit();
                        }
                        else{
                            echo 'error tomar venta:'.$sql;
                            exit();
                        }
                        break;
                    case '1':	//VENTA TOMADA POR OTRO VALIDADOR
                        echo 'La venta esta tomada por el Validador:';
                        $sql= "select idusuario FROM MegaAmexLongApp.dbo.tc_amex_lock ";
                        $sql.=" where fk_id_amex=:id and status_lock='T'";
                        $query = $this->db->prepare($sql);
                        $stmt->bindParam(":id", $id, PDO::PARAM_STR);
                        $query->execute();
                        $row = $query->fetch();
                        echo $row[0];
                        exit();
                        break;
                }
                break;
            case 'RETURN':	//RETOMAR VENTA
                $arrayQuery= array();
                //RETOMAR
                $sql= "UPDATE  MegaAmexLongApp.dbo.tc_amex_lock ";
                $sql.= " SET status_lock='R', actusuario=?, fec_unlock= CURRENT_TIMESTAMP ";
                $sql.= " WHERE fk_id_amex=? AND idusuario=? AND status_lock='T' ";
                $arrayTMP= array("query" => $sql, "params" => array($user, $id, $user));
                array_push(	$arrayQuery, $arrayTMP);
                //BLOQUEO
                $sql= "INSERT INTO  MegaAmexLongApp.dbo.tc_amex_lock ";
                $sql.= " (fk_id_amex, idusuario, fec_lock, status_lock, actusuario)VALUES(";
                $sql.= " ? , ?, CURRENT_TIMESTAMP, 'T',?);";
                $arrayTMP= array("query" => $sql, "params" => array($id, $user, $user));
                array_push(	$arrayQuery, $arrayTMP);
                if($data->insertDataPDO($arrayQuery, false)){
                    $url= 'frmCapturaLong.php?&id='.$_GET['id'];
                    echo '<script type="text/javascript">';
                    echo 'window.opener.setVtaTaken(\''.$id.'\', \''.$user.'\', \''.$fecha.'\');';
                    //echo "window.location='".$url."';";
                    echo '</script>';
                    exit();
                }
                else{
                    exit();
                }
                break;
            default:
                echo 'Action not defined';
                break;
        }
    }
}