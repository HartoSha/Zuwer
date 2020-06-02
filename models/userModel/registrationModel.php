<?php
require_once(ROOT . "models" . DIRECTORY_SEPARATOR . "baseModel.php");

class registrationModel extends baseModel
{
    public static function loginVerification($login)
    {
        self::query("SET @p0='" . $login . "'");

        $result = self::query('CALL loginVerification(@p0)');

        if(isset($result["id_user"])) return $result["id_user"];
        else return false;
    }

    public static function register($login, $password, $name, $surname, $middlename, $telephone)
    {
        self::query("SET @p0='" . $login . "'");
        self::query("SET @p1='" . $password . "'");
        self::query("SET @p2='" . $name . "'");
        self::query("SET @p3='" . $surname . "'");
        self::query("SET @p4='" . $middlename . "'");
        self::query("SET @p5='" . $telephone . "'");

        $query = self::query('CALL insertUser(@p0,@p1,@p2,@p3,@p4,@p5)');
    }
}
