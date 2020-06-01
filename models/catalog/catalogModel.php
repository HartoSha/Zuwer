<?php 
    require_once(ROOT. "models". DIRECTORY_SEPARATOR . "baseModel.php");

    class catalogModel extends baseModel
    {
        private const DEFAULT_QUANTITY = 6; # Изначально продукты отображаются по 6 на странице
        public static function getProducts($page,$PriceMin,$PriceMax,$weightMin ,$weightMax, $resultTipThickness="",$resultStatus="IN (0,1)",$resultId_inkColor="", $resultId_material="",$resultId_manufacturer="",$resultId_type="") 
        {
            // var_dump($PriceMin);
            // var_dump($PriceMax);

            // var_dump($weightMin);
            // var_dump($weightMax);

            // var_dump($resultTipThickness);
            // var_dump($resultStatus);
            // var_dump($resultId_inkColor);
            // var_dump($resultId_material);
            // var_dump($resultId_manufacturer);
            // var_dump($resultId_type);
            $PriceMin--;
            $PriceMax++;
            
            // $weightMin=1;
            // $weightMax=100;
           

            $offset = ($page * self::DEFAULT_QUANTITY - self::DEFAULT_QUANTITY);
            $query = 'SELECT `products`.`id_product`, `products`.`picture`, `products`.`title`, `products`.`price`, `products`.`status`, `type`.`typeName` 
            FROM `products` 
            INNER JOIN `type` ON `type`.`id_type` = `products`.`id_type` 
            WHERE `products`.`price` BETWEEN '.$PriceMin.' AND '.$PriceMax.' AND `products`.`weight`  BETWEEN '.$weightMin.' AND '.$weightMax.' AND
            `products`.`tipThickness` '.$resultTipThickness.' AND `products`.`status` '.$resultStatus.' AND `products`.`id_inkColor` '.$resultId_inkColor.' AND
            `products`.`id_material` '.$resultId_material.' AND `products`.`id_manufacturer` '.$resultId_manufacturer.' AND `products`.`id_type`'.$resultId_type.' AND 
            `products`.`quantity` <> 0  ORDER BY  `products`.`id_product` 
            LIMIT ' . self::DEFAULT_QUANTITY . " OFFSET " . $offset;

            $result = self::query($query);
            
            // if(!is_iterable($result))$result = array($result);
            
            return $result;
        }
        public static function getQuantityProducts($PriceMin,$PriceMax,$weightMin ,$weightMax, $resultTipThickness="",$resultStatus="IN (0,1)",$resultId_inkColor="", $resultId_material="",$resultId_manufacturer="",$resultId_type="") 
        {
            
            

            $query = 'SELECT COUNT(`products`.`id_product` ) AS `quantityProducts` FROM `products`
            WHERE `products`.`price` BETWEEN '.$PriceMin.' AND '.$PriceMax.' AND `products`.`weight`  BETWEEN '.$weightMin.' AND '.$weightMax.' AND
            `products`.`tipThickness` '.$resultTipThickness.' AND `products`.`status` '.$resultStatus.' AND `products`.`id_inkColor` '.$resultId_inkColor.' AND
            `products`.`id_material` '.$resultId_material.' AND `products`.`id_manufacturer` '.$resultId_manufacturer.' AND `products`.`id_type`'.$resultId_type.' AND
            `products`.`quantity` <> 0  ';

            $result = self::query($query);

            #Количество страниц
            $resultPage = ceil(($result['quantityProducts']) /6); 
            
            return $resultPage;
        }
        public static function getPriceWeightProducts() 
        {
            $query = "CALL selectProductsPriceWeight ();";
            return self::query($query);
        }
        public static function getProductManufacturers() 
        {
            $query = "CALL selectProductManufacturer();";
            return self::query($query);
             
        }
        public static function getProductMaterial() 
        {
            $query = "CALL selectProductMaterial();";
            return self::query($query);
             
        }
        public static function getProductInkColor() 
        {
            $query = "CALL selectProductInkColor();";
            return self::query($query);
             
        }
        public static function getProductType() 
        {
            $query = "CALL selectProductType();";
            return self::query($query);
             
        }
        public static function getProductsTipThickness () 
        {
            $query = "CALL selectProductsTipThickness();";
            return self::query($query);
             
        }
        // Private
        public static function _getVariableForFiltering($filterName) 
        {
            $IN="IN (";
            $comma=",";
            $bracket = ")";
            #Создание переменной путем склейки нескольких элементов
            if(isset($_POST[$filterName])){
                $result=$IN;
                for($i=0;$i<count($_POST[$filterName]);$i++){
                    $result.=($_POST[$filterName])[$i];
                    if($i<count($_POST[$filterName])-1)$result.=$comma;
                }
                $result.=$bracket;
            }
            return $result;
        }

    }