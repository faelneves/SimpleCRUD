<?php

abstract class Connection{

    protected function connectDB()
    {
        try{
            $user = 'root';
            $password = ''; 
            $database = 'user_manager'; 
            $port = 3306;
            $mysqli = new mysqli('127.0.0.1', $user, $password, $database, $port);

            if ($mysqli->connect_error) {
                die('Connect Error (' . $mysqli->connect_errno . ') '. $mysqli->connect_error);
            }
            return $mysqli;
        }catch (Exception $Erro){
            return $Erro->getMessage();
        }
    }

    /**
    * @param string $nome_da_tabela nome da tabela na qual vai inserir os dados
    * @param array informacao é um array com os mesmos nomes dos elementos do form
    */
    protected function insert(string $nomeDaTabela, array $informacao){
        $sql = "INSERT INTO ".$nomeDaTabela." ";
        $sql .= $this->getParamsSQL($informacao);
        
        $connect =$this->connectDB();
        
        if (mysqli_query($connect, $sql)) {
            return mysqli_insert_id($connect);
        } else {
            http_response_code(500);
            return "Error: ".mysqli_error($connect);
        }
    }

    private function getParamsSQL($params){
        $paramsName = "(";
        $paramsValue = "(";
        foreach ($params as $key => $value) {
            $paramsName .= $key.",";
            $paramsValue .= "'".$value."',";
        }
        $paramsName = substr($paramsName, 0, -1);
        $paramsValue = substr($paramsValue, 0, -1);

        return $paramsName.') VALUES '.$paramsValue.')';
    }

    /**
    * @param string $nome_da_tabela nome da tabela a ser consultada
    * @param array informacao é um array com os mesmos nomes dos elementos do form
    */
    public function select(string $nomeDaTabela, array $informacao)
    {
        $sql = "SELECT * FROM ".$nomeDaTabela." ";
        $sql .= $this->getParamsSelect($informacao);

        $connect =$this->connectDB();
        
        $result = mysqli_query($connect, $sql);
        
        if(mysqli_num_rows($result) == 0){
            http_response_code(401);
            return false;
        }
        return $result->fetch_object();
    }

    private function getParamsSelect($params){
        $query = "WHERE ";
        foreach ($params as $key => $value) {
            $query.= $key . " = '".$value."'";
            if($value != end($params)){
                $query.= " AND ";
            }
        }
        return $query;
    }

}

?>