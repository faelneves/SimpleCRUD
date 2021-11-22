<?php
    include("UserService.php");

    class UserController{
        private $errorMsg = array();
        private $userService;
        
        public function __construct() {
            $this->userService = new UserService();
        }

        public function createUser($userData){
            $this->validateFields($userData);

            if(!empty($this->errorMsg)){
                http_response_code(422);
                echo (json_encode($this->errorMsg));
                return false;
            }
            $userData['password'] = $this->hashPassword($userData['password']);
            echo(json_encode($this->userService->createUser($userData)));

        }

        public function login($userData){
            $userData['password'] = $this->hashPassword($userData['password']);
            echo(json_encode($this->userService->login($userData)));
        }

        private function validateFields($userData)
        {
            $this->validateName($userData['name']);
            $this->validateUserName($userData['userName']);
            $this->validateCEP($userData['zipCode']);
            $this->validateEmail($userData['email']);
            $this->validatePassword($userData['password']);
        }

        private function validateName($name){
            if(empty($name)){
                $this->errorMsg[] = "O campo Nome completo não pode ser vazio.";
            }
            if(!preg_match("/^[a-zA-Z0-9\s]*$/", $name)){
                $this->errorMsg[] = "O campo Nome completo deve conter apenas cacteres alphanumericos.";
            }
        }

        private function validateUserName($userName){
            if(empty($userName)){
                $this->errorMsg[] = "O campo Nome de login não pode ser vazio.";
                return false;
            }
            if(!ctype_alnum($userName)){
                $this->errorMsg[] = "O campo Nome de login deve conter apenas cacteres alphanumericos.";
            }
        }

        private function validateCEP($cep){
            if(!preg_match("/^[0-9]{5}-[0-9]{3}$/", $cep)){
                $this->errorMsg[] = "O campo CEP deve estar no formato 99999-999.";
            }
        }

        private function validateEmail($email){
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $this->errorMsg[] = "O campo de E-mail não é valido.";
            }
        }

        private function validatePassword($password){
            if(strlen($password)<8){
                $this->errorMsg[] = "A senha deve conter pelo menos 8 caracteres.";
                return false;
            }
            if(!preg_match("/\d/", $password)){
                $this->errorMsg[] = "A senha deve conter pelo menos 1 número.";
            }
            if(!preg_match("/[a-zA-Z]/", $password)){
                $this->errorMsg[] = "A senha deve conter pelo menos 1 letra.";
            }
        }

        private function hashPassword($password){
            return hash('ripemd160', $password);
        }

    }
?>