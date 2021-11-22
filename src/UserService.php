<?php
include("Connection.php");

class UserService extends Connection{
    private $userTable = "user";

    public function createUser($userData)
    {
        return $this->insert($this->userTable,$userData);
    }

    public function login($userData)
    {
        $result = $this->select($this->userTable,$userData);
        if($result){
            return $result;
        }else{
            return "Usuário ou senha inválidos.";
        }
    }
}

?>