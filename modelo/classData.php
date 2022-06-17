<?php
class classData{
    private $db;
    private $arrayResult;
    /* CONSTRUCTOR */
    public function __construct($base){
        $this->db = conexion::conexionodbcPDO45($base);
        $this->arrayResult=array();
    }
    /* RETORNA UN ARRAY ASOCIATIVO */
    public function getData($sql){
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->fetchAll();
        return $resultado;
    }

    /* RETORNA UN VALOR NUMERICO count()*/
    public function getIntScalar($sql){
        try{
            $query = $this->db->prepare($sql);
            $query->execute();
            $row = $query->fetch();
            $value = $row[0];
            return $value;
        }
        catch(Exception $ex){
            echo $ex;
        }
    }
    public function getIntScalarPDO($sql, $param){
        try{
            $smt = $this->db->prepare($sql);
            $smt->bindParam(1, $param, PDO::PARAM_INT);
            $smt->execute();
            $row = $smt->fetch();
            $value = $row[0];
            return $value;
        }
        catch(Exception $ex){
            echo 'Error: '.$sql.'::'.$param.'<br>';
            echo $ex;
        }
    }
    /* RETORNA single row, single column*/
    public function getSingleRowCol($sql){
        $query = $this->db->prepare($sql);
        $query->execute();
        $row = $query->fetch();
        $value = $row[0];
        return $value;
    }
    /* INSERTAR SECUENCIAS DE SQL, CONTENIDAS EN UN ARRAY */
    public function insertData($arrayData){
        try{
            $this->db->beginTransaction();
            foreach( $arrayData as $sql){
                $smt= $this->db->prepare($sql);
                $smt->execute();
            }
            $this->db->commit();
            return true;
        }
        catch(Exception $ex){
            $this->db->rollback();
            throw $ex;
        }
    }
    public function insertDataPDO($arrayQuery, $showSQL){
        $error=0;$row='';
        if($showSQL){
            $this->showSQLParams($arrayQuery);
        }
        try{
            $this->db->beginTransaction();
            $y=1;
            $line='';
            foreach( $arrayQuery as $item){
                $row=$item["query"];
                $smt= $this->db->prepare($item["query"]);
                $smt->execute($item["params"]);
                $result= $smt->rowCount();//
                $line.= 'R::'.$y.'::'.$result.'<br>';
                $error += $result>=1 ? 0 : 1;
                $y++;
            }
            $this->db->commit();
            return true;
        }
        catch(Exception $ex){
            $this->db->rollback();
            echo 'Error:[<strong><u>'.$row.'</u></strong><br>'.$ex.'<br>';
            $this->showSQLParams($arrayQuery);
            return false;
        }
    }
    function showSQLParams($arrayQuery){
        $y=1;
        foreach($arrayQuery as $item){
            $line="";
            $sql= $item["query"];
            $params= $item["params"];
            $arr= explode('?', $sql);
            for($x=0; $x< count($params); $x++){
                $line.= $arr[$x].$params[$x];
            }
            echo $y.'::SQL::'.$line.'<br>';
            $y++;
        }
    }
}

?>
