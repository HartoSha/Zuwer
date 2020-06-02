<?php
require_once(ROOT . "models" . DIRECTORY_SEPARATOR . "baseModel.php");
require_once(ROOT . "models" . DIRECTORY_SEPARATOR . "userModel" . DIRECTORY_SEPARATOR . "loginModel.php");
require_once(ROOT . "models" . DIRECTORY_SEPARATOR . "userModel" . DIRECTORY_SEPARATOR . "registrationModel.php");

session_start();

$errors = array();

class userController
{
    public function login()
    {
        //проверка логина пользователя
        $login = $_POST['user-name'];
        $userId = loginModel::loginVerification($login);

        if (!$userId) $errors[] = "Логин неверный";
        else{
            $userPassword = loginModel::getUserPassword($userId);

            //проверка пароля пользователя
            if (!password_verify($_POST['user-psw'], $userPassword)) $errors[] = "Пароль неверный";
            else {
                //если ошибок нет заносим уникальный id пользователя в сессию
                $_SESSION['user'] = loginModel::getUserInfo($login, $userPassword);
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
        }
        echo '<div style="color: red;">' . array_shift($errors) . '</div>';
    }
    public function register() //метод который будет вызываться при регистрации
    {
        $regInfo = $_POST;

        if ($regInfo['reg-name'] == '') {
            $errors[] = "Введите имя";
        } elseif (mb_strlen($regInfo['reg-name']) > 15) {
            $errors[] = "имя слишком длинное";
        }

        if ($regInfo["reg-surname"] == '') {
            $errors[] = "Введите Фамилию";
        } elseif (mb_strlen($regInfo["reg-surname"]) > 20) {
            $errors[] = "Фамилия слишком длинная";
        }

        if ($regInfo['reg-middlename'] == '') {
            $errors[] = "Введите имя";
        } elseif (mb_strlen($regInfo['reg-middlename']) > 20) {
            $errors[] = "Отчество слишком длинное";
        }

        if ($regInfo['reg-account-name'] == '') {
            $errors[] = "Введите логин";
        } elseif (mb_strlen($regInfo['reg-account-name']) > 30) {
            $errors[] = "Логин слишком длинный";
        } else {
            $login = registrationModel::loginVerification($regInfo['reg-account-name']);
            if ($login > 0) $errors[] = "ПОЛЬЗОВАТЕЛЬ С ТАКИМ ЛОГЕНОМ УЖЕ ЗАРЕГИСТРИРОВАН";
        }

        if ($regInfo['reg-pass'] == '') {
            $errors[] = "Введите пароль";
        } elseif (mb_strlen($regInfo['reg-pass']) > 100) {
            $errors[] = "Пароль слишком длинный";
        }
        if ($regInfo['reg-pass-again'] != $regInfo['reg-pass']) {
            $errors[] = "Введены разные пароли";
        }

        if ($regInfo['reg-telephone'] == '') {
            $errors[] = "Введите Телефон";
        } elseif (mb_strlen($regInfo['reg-telephone']) > 11) {
            $errors[] = "Телефон слишком длинный";
        } elseif (mb_strlen($regInfo['reg-telephone']) < 11) {
            $errors[] = "Телефон слишком короткий";
        }

        if (empty($errors)) {
            registrationModel::register(
                $regInfo['reg-account-name'],
                password_hash($regInfo['reg-pass'], PASSWORD_DEFAULT),
                $regInfo['reg-name'],
                $regInfo['reg-surname'],
                $regInfo['reg-middlename'],
                $regInfo['reg-telephone']
            );
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            
            $login = $_POST['reg-account-name'];
            $userId = loginModel::loginVerification($login);
            $userPassword = loginModel::getUserPassword($userId);
            $_SESSION['user'] = loginModel::getUserInfo($login, $userPassword);
        } else {
            echo '<div style="color: red;">' . array_shift($errors) . '</div>';
        }
    }
    public function logout(){
        if(isset($_SESSION)){
            $_SESSION = array();
            session_destroy();
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }
}
