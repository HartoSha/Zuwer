<?php

class loginModel extends baseModel
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

}
