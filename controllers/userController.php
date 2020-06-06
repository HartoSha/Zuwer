<?php
require_once(ROOT . "models" . DIRECTORY_SEPARATOR . "userModel" . DIRECTORY_SEPARATOR . "userModel.php");

// $errors = array(); СУПЕРГЛОБАЛЬНЫЙСУПЕРМАССИВ с нами навечно

class userController
{
    public  function index() 
    {
        # может быть вызван лишь при переходе по адресу zuwer/user либо zuwer/user/несуществующий_action_name
        # в следствии этого перенаправляет пользователя на главную
        # при дальнейшем расширении сайта здесь может быть личный кабинет пользователя
        header("location: /");
    }
    public function login() 
    {
        # если пользователь не авторизован и отправил форму логина => инициализированы переменные. (эта проверка предотвращает пользователя от попадания в action авторизации не из формы авторизации)
        if(!userModel::userIsLoggedIn() && isset($_POST['user-name']) && isset($_POST['user-psw'])) 
        {
            $errors = array();
            $login = $_POST['user-name'];
            $userId = userModel::loginVerification($login);

            if (!$userId) $errors[] = "Введен неверный логин или пароль";
            else{
                $userPassword = userModel::getUserPassword($userId);
                
                //проверка пароля пользователя
                if (!password_verify($_POST['user-psw'], $userPassword)) $errors[] = "Введен неверный логин или пароль";
                else {
                    //если ошибок нет заносим пользователя в сессию
                    $_SESSION['user'] = userModel::getUserInfo($login, $userPassword);
                }
            }
            if(!empty($errors)){
                $_SESSION['login-errors'] = $errors;
            }
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
        else {
            # Иначе отправляем пользователя на страницу главной
            header('Location: /' );
        }
    }
    public function register() //метод который будет вызываться при регистрации
    {
        # аналогично проверке оправки логина
        if(!userModel::userIsLoggedIn() && isset($_POST['reg-name']) && isset($_POST['reg-surname'])
        && isset($_POST['reg-surname']) && isset($_POST['reg-middlename'])
        && isset($_POST['reg-account-name']) && isset($_POST['reg-pass'])
        && isset($_POST['reg-pass-again']) && isset($_POST['reg-telephone'])) 
        {
            $errors = array();
            if(mb_strlen($_POST['reg-name']) > 15){
                $errors[] = "Имя слишком длинное";
            }

            if(mb_strlen($_POST["reg-surname"]) > 20){
                $errors[] = "Фамилия слишком длинная";
            }

            if(mb_strlen($_POST['reg-middlename']) > 20){
                $errors[] = "Отчество слишком длинное";
            }

            if($_POST['reg-account-name'] == '') {
                $errors[] = "Введите логин";
            }
            elseif(mb_strlen($_POST['reg-account-name']) < 3){
                $errors[] = "Логин слишком короткий";
            }
            elseif(mb_strlen($_POST['reg-account-name']) > 30){
                $errors[] = "Логин слишком длинный";
            }
            elseif(userModel::loginVerification($_POST['reg-account-name'])) {
                $errors[] = "Пользователь с таким логином уже зарегистрирован";
            }

            if($_POST['reg-pass'] == '') {
                $errors[] = "Введите пароль";
            }
            elseif(mb_strlen($_POST['reg-pass']) < 5){
                $errors[] = "Пароль слишком короткий";
            }
            elseif(mb_strlen($_POST['reg-pass']) > 100){
                $errors[] = "Пароль слишком длинный";
            }
            if($_POST['reg-pass-again'] != $_POST['reg-pass']) {
                $errors[] = "Введены разные пароли";
            }
            
            //TODO: сделать нормальную проверку телефона
            if(mb_strlen($_POST['reg-telephone']) > 11) {
                $errors[] = "Телефон слишком длинный";
            }
            if($_POST['reg-telephone'] && mb_strlen($_POST['reg-telephone']) < 11) {
                $errors[] = "Телефон слишком короткий";
            }

            if (empty($errors)) {
                userModel::register(
                    $_POST['reg-account-name'],
                    password_hash($_POST['reg-pass'], PASSWORD_DEFAULT),
                    $_POST['reg-name'],
                    $_POST['reg-surname'],
                    $_POST['reg-middlename'],
                    $_POST['reg-telephone']
                );
                $login = $_POST['reg-account-name'];
                $userId = userModel::loginVerification($login);
                $userPassword = userModel::getUserPassword($userId);
                $_SESSION['user'] = userModel::getUserInfo($login, $userPassword);
            }
            else {
                # Записываем ошибки регистрации в сессии, для отображения их в форме регистрации
                $_SESSION["registration-errors"] = $errors;
            }
            // var_dump($errors);
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
        else {
            header('Location: /' );
        }
    }

    public function logout(){
        if(userModel::userIsLoggedIn()){
            $_SESSION['user'] = NULL;
            $_SESSION = array();
            session_destroy();
        }
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
    public function myorders() 
    {
        if(userModel::userIsLoggedIn())
        {
            $userId = $_SESSION['user']["id_user"];
            $orders = userModel::getMyOrders($userId);

            require_once(VIEWS . "myordersView.php");
        }
        else header('Location: /');
    }
}
