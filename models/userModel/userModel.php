<?php
require_once(ROOT. "models". DIRECTORY_SEPARATOR . "baseModel.php");

class userModel extends baseModel
{
    public static function loginVerification($login)
    {
        self::query("SET @p0='" . $login . "'");

        $result = self::query('CALL loginVerification(@p0)');

        if(isset($result["id_user"])) return $result["id_user"];
        else return false;
    }

    public static function getUserInfo($login, $password)
    {
        self::query("SET @p0='" . $login . "'");
        self::query("SET @p1='" . $password . "'");

        $result = self::query('CALL authMe(@p0, @p1)');

        return $result;
    }

    public static function getUserPassword($id)
    {
        self::query("SET @p0='" . $id . "'");

        $result = self::query('CALL selectPassword(@p0)');

        if(isset($result["password"])) return $result["password"];
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
    public static function userIsLoggedIn() {
        return boolval($_SESSION && $_SESSION['user']);
    }

    public static function ordersCount($userId)
    {
        self::query("SET @p0='" . $userId . "'");
        $result = self::query('CALL insertUser(@p0)');

        return $result;
    }

    public static function ordersInfo($userId)
    {
        self::query("SET @p0='" . $userId . "'");
        $result = self::query('CALL selectOrders(@p0)');

        return $result;
    }

    public static function getProductById($productId) 
    {
        $query = "CALL selectProduct(".$productId.");";
        $ProductInfo = self::query($query);

        $result = $ProductInfo["title"];
        return $result;
    }
}
