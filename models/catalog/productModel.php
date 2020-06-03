<?php 
    require_once(ROOT. "models". DIRECTORY_SEPARATOR . "baseModel.php");

    class productModel extends baseModel
    {
        public static function getProductById($productId) 
        {
            $query = "CALL selectProduct(".$productId.");";
            return self::query($query);
        }
    }