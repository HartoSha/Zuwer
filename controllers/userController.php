<?php
    require_once(ROOT. "models". DIRECTORY_SEPARATOR . "userModel" . DIRECTORY_SEPARATOR . "loginModel.php");
    require_once(ROOT. "models". DIRECTORY_SEPARATOR . "userModel" . DIRECTORY_SEPARATOR . "registrationModel.php");

    $errors = array();

    class userController
    {
        public function login() 
        {
            $loginInfo = $_POST;
            $userInfo = array();
            $userPassword;
            
            $login = registrationModel::loginVerification($loginInfo['user-name']);
            // var_dump($login);
            // (string)$userId = $login["id_user"];
            if($login == NULL) $errors[] = "Логин неверный";

            if(empty($errors)){
                $userPassword = loginModel::getUserPassword($login["id_user"]);
                (string)$currentUserPassword = $userPassword["password"];
                if(!password_verify($loginInfo['user-psw'], $userPassword["password"])) $errors[] = "Пароль неверный";
            }

            if(empty($errors)){
                echo '<div style="color: green;"> Успех </div>';
            }
            else{
                echo '<div style="color: red;">'.array_shift($errors).'</div>';
            }
        }
        public function register() //метод который будет вызываться при регистрации
        {
            $regInfo = $_POST;

            if($regInfo['reg-name'] == '') {
                $errors[] = "Введите имя";
            }
            elseif(strlen($regInfo['reg-name']) > 15){
                $errors[] = "имя слишком длинное";
            }

            if($regInfo["reg-surname"] == '') {
                $errors[] = "Введите Фамилию";
            }
            elseif(strlen($regInfo["reg-surname"]) > 20){
                $errors[] = "Фамилия слишком длинная";
            }

            if($regInfo['reg-middlename'] == '') {
                $errors[] = "Введите имя";
            }
            elseif(strlen($regInfo['reg-middlename']) > 20){
                $errors[] = "Отчество слишком длинное";
            }

            if($regInfo['reg-account-name'] == '') {
                $errors[] = "Введите логин";
            }
            elseif(strlen($regInfo['reg-account-name']) > 30){
                $errors[] = "Логин слишком длинный";
            }
            else {
                $login = registrationModel::loginVerification($regInfo['reg-account-name']);
                if($login > 0) $errors[] = "ПОЛЬЗОВАТЕЛЬ С ТАКИМ ЛОГЕНОМ УЖЕ ЗАРЕГИСТРИРОВАН";
            }

            if($regInfo['reg-pass'] == '') {
                $errors[] = "Введите пароль";
            }
            elseif(strlen($regInfo['reg-pass']) > 100){
                $errors[] = "Пароль слишком длинный";
            }
            if($regInfo['reg-pass-again'] != $regInfo['reg-pass']) {
                $errors[] = "Введены разные пароли";
            }
            
            if($regInfo['reg-telephone'] == ''){
                $errors[] = "Введите Телефон";
            }
            elseif(strlen($regInfo['reg-telephone']) > 11) {
                $errors[] = "Телефон слишком длинный";
            }
            elseif(strlen($regInfo['reg-telephone']) < 11) {
                $errors[] = "Телефон слишком короткий";
            }

            if(empty($errors)){
                registrationModel::register($regInfo['reg-account-name'], 
                password_hash($regInfo['reg-pass'], PASSWORD_DEFAULT), 
                $regInfo['reg-name'], 
                $regInfo['reg-surname'], 
                $regInfo['reg-middlename'], 
                $regInfo['reg-telephone']);

            }
            else{
                echo '<div style="color: red;">'.array_shift($errors).'</div>';
            }
        }
    } 