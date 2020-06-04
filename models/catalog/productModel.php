<?php 
    require_once(ROOT. "models". DIRECTORY_SEPARATOR . "baseModel.php");

    class productModel extends baseModel
    {
        public static function getProductById($productId) 
        {
            $query = "CALL selectProduct(".$productId.");";
            return self::query($query);
        }

        public static function adressCheck($city, $street, $house, $postalCode)
        {
            self::query("SET @p0='" . $city . "'");
            self::query("SET @p1='" . $street . "'");
            self::query("SET @p2='" . $house . "'");
            self::query("SET @p3='" . $postalCode . "'");

            $result = self::query('CALL selectDeliveryAddress_id(@p0,@p1,@p2,@p3)');
            return $result;
        }

        public static function createDeliveryAddress($city, $street, $house, $postalCode)
        {
            self::query("SET @p0='" . $city . "'");
            self::query("SET @p1='" . $street . "'");
            self::query("SET @p2='" . $house . "'");
            self::query("SET @p3='" . $postalCode . "'");

            $result = self::query('CALL insertDeliveryAddress(@p0,@p1,@p2,@p3)');
        }

        public static function ordering($productId, $name, $surname, $patronymic, $adressId, $phone, $quantity, $userId, $totalPrice)
        {   
            var_dump($totalPrice);
            self::query("SET @p0='" . $productId . "'");
            self::query("SET @p1='" . $userId . "'");
            self::query("SET @p2='" . $quantity . "'");
            self::query("SET @p3='" . $totalPrice . "'");
            self::query("SET @p4='" . $name . "'");
            self::query("SET @p5='" . $surname . "'");
            self::query("SET @p6='" . $patronymic . "'");
            self::query("SET @p7='" . $phone . "'");
            self::query("SET @p8='" . $adressId . "'");

            $result = self::query('CALL insertOrder(@p0,@p1,@p2,@p3,@p4,@p5,@p6,@p7,@p8)');
        }

        public static function updateProductQuantity($productId, $quantity, $sales)
        {
            self::query("SET @p0='" . $productId . "'");
            self::query("SET @p1='" . $quantity . "'");
            self::query("SET @p2='" . $sales . "'");

            $result = self::query('CALL updateProductQuantity(@p0,@p1,@p2)');
        }
    }