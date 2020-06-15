<?php
require_once(ROOT. "models". DIRECTORY_SEPARATOR . "baseModel.php");
require_once(ROOT. "models". DIRECTORY_SEPARATOR . "catalog" . DIRECTORY_SEPARATOR . "productModel.php");

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
        return boolval($_SESSION && isset($_SESSION['user']));
    }

    public static function getMyOrders($userId)
    {
        self::query("SET @p0='" . $userId . "'");
        $orders = self::query('CALL selectOrders(@p0)');

        # Если полученный результат - массив с массивами
        if(isset($orders[0]))
        {
            foreach ($orders as $i => $order)
            {
                $orders[$i]["product-name"] = productModel::getProductById($order["id_product"])["title"];
            }
            return $orders;
        }
        # Если полученный результат - один заказ (просто ассициоативный массив)
        elseif($orders)
        {
            $orders["product-name"] = productModel::getProductById($orders["id_product"])["title"];
            # Оборачиваем результат(1 заказ) в дополнительный массив для корректной работы цикла for в myordersView.php
            return array($orders);
        }
        return false;
    }
    public static function getMyFavorites($userId) 
    {
        $favorites = self::query("CALL selectElectProducts($userId)");
        if(!$favorites) return false;
        # Оборачиваем результат в доп массив, если он один (т.е. если он вернулся в виде ассициотаивного массива и у него нет элемента с индексом 0)
        if(!isset($favorites[0])) $favorites = array($favorites);
        return $favorites;
    }
}
