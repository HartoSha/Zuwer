<?php 
    require_once(ROOT. "models". DIRECTORY_SEPARATOR . "baseModel.php");

    class loginModel extends baseModel
    {
        public static function getUserInfo($login, $password) 
        {
            self::query("SET @p0='".$login."'");
            self::query("SET @p1='".$password."'");

            $query = self::query('CALL authMe(@p0, @p1)');

            return $query;
        }
        public static function getUserPassword($id) 
        {
            self::query("SET @p0='".$id."'");

            $query = self::query('CALL selectPassword(@p0)');

            return $query;
        }
    }