<?php
require_once(ROOT . "models" . DIRECTORY_SEPARATOR . "baseModel.php");
require_once(ROOT . "models" . DIRECTORY_SEPARATOR . "userModel" . DIRECTORY_SEPARATOR . "loginModel.php");
require_once(ROOT . "models" . DIRECTORY_SEPARATOR . "userModel" . DIRECTORY_SEPARATOR . "registrationModel.php");

session_start();

// $errors = array(); СУПЕРГЛОБАЛЬНЫЙСУПЕРМАССИВ с нами навечно

class userController
{
    public function login() 
    {
        # если пользователь отправил форму логина => инициализированы переменные. (эта проверка предотвращает пользователя от попадания в action авторизации не из формы авторизации)
        if(isset($_POST['user-name']) && isset($_POST['user-psw'])) 
        {
            $errors[] = array();
            $login = $_POST['user-name'];
            $userId = loginModel::loginVerification($login);

            if (!$userId) $errors[] = "Логин неверный";
            else{
                $userPassword = loginModel::getUserPassword($userId);

                //проверка пароля пользователя
                if (!password_verify($_POST['user-psw'], $userPassword)) header('Location: /');
                else {
                    //если ошибок нет заносим уникальный id пользователя в сессию
                    $_SESSION['user'] = loginModel::getUserInfo($login, $userPassword);
                    header('Location: ' . $_SERVER['HTTP_REFERER']);
                }

                if(!empty($errors)){
                    echo '<div style="color: red;">' . array_shift($errors) . '</div>';
                }
            }
        }
        else {
            # Иначе отправляем пользователя на страницу главной
            header('Location: /' );
        }
    }
    public function register() //метод который будет вызываться при регистрации
    {
        # аналогично проверке оправки логина
        if(isset($_POST['reg-name']) && isset($_POST['reg-surname'])
        && isset($_POST['reg-surname']) && isset($_POST['reg-middlename'])
        && isset($_POST['reg-account-name']) && isset($_POST['reg-pass'])
        && isset($_POST['reg-pass-again']) && isset($_POST['reg-telephone'])) 
        {
            $errors = array();
            if($_POST['reg-name'] == '') {
                $errors[] = "Введите имя";
            }
            elseif(mb_strlen($_POST['reg-name']) > 15){
                $errors[] = "имя слишком длинное";
            }

            if($_POST["reg-surname"] == '') {
                $errors[] = "Введите Фамилию";
            }
            elseif(mb_strlen($_POST["reg-surname"]) > 20){
                $errors[] = "Фамилия слишком длинная";
            }

            if($_POST['reg-middlename'] == '') {
                $errors[] = "Введите имя";
            }
            elseif(mb_strlen($_POST['reg-middlename']) > 20){
                $errors[] = "Отчество слишком длинное";
            }

            if($_POST['reg-account-name'] == '') {
                $errors[] = "Введите логин";
            }
            elseif(mb_strlen($_POST['reg-account-name']) > 30){
                $errors[] = "Логин слишком длинный";
            }
            else {
                $login = registrationModel::loginVerification($_POST['reg-account-name']);
                if($login > 0) $errors[] = "ПОЛЬЗОВАТЕЛЬ С ТАКИМ ЛОГЕНОМ УЖЕ ЗАРЕГИСТРИРОВАН";
            }

            if($_POST['reg-pass'] == '') {
                $errors[] = "Введите пароль";
            }
            elseif(mb_strlen($_POST['reg-pass']) > 100){
                $errors[] = "Пароль слишком длинный";
            }
            if($_POST['reg-pass-again'] != $_POST['reg-pass']) {
                $errors[] = "Введены разные пароли";
            }
            
            if($_POST['reg-telephone'] == ''){
                $errors[] = "Введите Телефон";
            }
            elseif(mb_strlen($_POST['reg-telephone']) > 11) {
                $errors[] = "Телефон слишком длинный";
            }
            elseif(mb_strlen($_POST['reg-telephone']) < 11) {
                $errors[] = "Телефон слишком короткий";
            }

            if (empty($errors)) {
                registrationModel::register(
                    $_POST['reg-account-name'],
                    password_hash($_POST['reg-pass'], PASSWORD_DEFAULT),
                    $_POST['reg-name'],
                    $_POST['reg-surname'],
                    $_POST['reg-middlename'],
                    $_POST['reg-telephone']
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
        else {
            header('Location: /' );
        }
    }

    public function logout(){
        if(isset($_SESSION)){
            $_SESSION = array();
            session_destroy();
            header('Location: /');
        }
    }
    
    public function myorders() 
    {
        require_once(VIEWS . "myordersView.php");
    }
}
