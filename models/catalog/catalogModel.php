<?php 
    require_once(ROOT. "models". DIRECTORY_SEPARATOR . "baseModel.php");

    class catalogModel extends baseModel
    {
        private const DEFAULT_QUANTITY = 6; # Изначально продукты отображаются по 6 на странице
        public static function getProducts($page) 
        {
            // , `products`.`picture`
            $offset = ($page * self::DEFAULT_QUANTITY - self::DEFAULT_QUANTITY);
            $query = "SELECT `products`.`id_product`, `products`.`title`, `products`.`price`, `products`.`status`, `type`.`typeName` 
            FROM `products` 
            INNER JOIN `type` 
            ON `type`.`id_type` = `products`.`id_type` 
            WHERE `products`.`quantity` <> 0 
            ORDER BY  `products`.`id_product` 
            LIMIT " . self::DEFAULT_QUANTITY . " OFFSET " . $offset;

            $result = self::query($query);
            return $result;
        }
    }