<?php
    require_once(ROOT. "models". DIRECTORY_SEPARATOR . "baseModel.php");
    class mainpageModel extends baseModel 
    {
        public static function getManufacturers() 
        {
            $query = "CALL selectManufacturer();";
            return self::query($query);
        }
        public static function getNewProducts()
        {
            $query = "CALL selectProductsNew();";
            return self::query($query);
        }
    }