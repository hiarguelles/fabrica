<?php
session_start();
require_once 'conexion.php';
require_once 'classData.php';
class bloqueo{
    private $db;
    public function __construct(){
        $this->db = conexion::conexionPDOSQL();
    }
    public function bloquear($action, $id){
        $data= new classData();
        $user= $_SESSION['id_user'];
        $id= $_GET['id'];
        $fecha= strftime('%H:%M');

        switch(trim(strtoupper($_GET['action']))){
            case 'BLOQUEA':	//Evaluar
                $sql="SELECT count(1) as contador FROM tabla_bloqueo ";
                $sql.=" where caso=:id and status_lock='T' and id_usuario not in(:user)";
                echo $user.' , '.$id.'<br>'.$sql;

                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(":user", $user, PDO::PARAM_STR);
                $stmt->bindParam(":id", $id, PDO::PARAM_STR);
                $stmt->execute();
                $result= $stmt->fetchAll();


                switch($result[0]['contador']){
                    case '0':	//VENTA LIBRE,
                        //VERIFICAR QUE EL VALIDADOR NO TENGA OTRA VENTA TOMADA
                        $sql=" SELECT top(1) caso FROM  tabla_bloqueo WHERE id_usuario=:user ";
                        $sql.=" and status_lock='T' and caso not in(:id) ";
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
                        $sql= "INSERT INTO  tabla_bloqueo";
                        $sql.= " (caso, id_usuario, fec_lock, status_lock, actusuario)VALUES(";
                        $sql.= " :id, :user, CURRENT_TIMESTAMP, 'T', :user2 );";
                        $stmt = $this->db->prepare($sql);
                        $stmt->bindParam(":user", $user, PDO::PARAM_STR);
                        $stmt->bindParam(":user2", $user, PDO::PARAM_STR);
                        $stmt->bindParam(":id", $id, PDO::PARAM_STR);

                        if($stmt->execute()){
                            $url= 'validaVta.php?&id='.$id;
                            echo '<script type="text/javascript">';
                            echo 'window.opener.setVtaBloqueo(\''.$id.'\', \''.$user.'\', \''.$fecha.'\');';
                            echo "window.location='".$url."';";
                            echo '</script>';
                            exit();
                        }
                        else{
                            echo 'Error tomar venta:'.$sql;
                            exit();
                        }
                        break;
                    case '1':	//VENTA TOMADA POR OTRO AGENTE
                        echo 'La venta esta tomada por el agente:';
                        $sql= "select id_usuario FROM venta_bloqueo";
                        $sql.=" where caso=:id and status_lock='T'";
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
                $sql= "UPDATE  tabla_bloqueo ";
                $sql.= " SET status_lock='R', actusuario=?, fec_unlock= CURRENT_TIMESTAMP ";
                $sql.= " WHERE caso=? AND id_usuario=? AND status_lock='T' ";
                $arrayTMP= array("query" => $sql, "params" => array($user, $id, $user));
                array_push(	$arrayQuery, $arrayTMP);
                //BLOQUEO
                $sql= "INSERT INTO  tabla_bloqueo ";
                $sql.= " (caso, id_usuario, fec_lock, status_lock, actusuario)VALUES(";
                $sql.= " ? , ?, CURRENT_TIMESTAMP, 'T',?);";
                $arrayTMP= array("query" => $sql, "params" => array($id, $user, $user));
                array_push(	$arrayQuery, $arrayTMP);
                if($data->insertDataPDO($arrayQuery, false)){
                    $url= 'evaluaVTA.php?&id='.$_GET['id'];
                    echo '<script type="text/javascript">';
                    echo 'window.opener.setVtaBloqueo(\''.$id.'\', \''.$user.'\', \''.$fecha.'\');';
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