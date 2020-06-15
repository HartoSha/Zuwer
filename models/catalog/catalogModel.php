<?php 
    require_once(ROOT. "models". DIRECTORY_SEPARATOR . "baseModel.php");

    class catalogModel extends baseModel
    {
        private const DEFAULT_QUANTITY = 6; # Изначально продукты отображаются по 6 на странице
        Private static function getSortOrder() 
        {
            if(isset($_COOKIE["sortOrder"])){
                if($_COOKIE["sortOrder"]=="descendingPrice")$reset = "`products`.`Price` DESC";
                elseif($_COOKIE["sortOrder"]=="ascendingPrice")$reset = "`products`.`Price`";
                elseif($_COOKIE["sortOrder"]=="descendingWeight")$reset = "`products`.`weight` DESC";
                elseif($_COOKIE["sortOrder"]=="ascendingWeight")$reset = "`products`.`weight`";
            }
            else $reset = "`products`.`id_product`";

            return $reset;
             
        }
        public static function getProducts($page,$PriceMin,$PriceMax,$weightMin ,$weightMax, $resultTipThickness="",$resultStatus="IN (0,1)",$resultId_inkColor="", $resultId_material="",$resultId_manufacturer="",$resultId_type="") 
        {
            $PriceMin--;
            $PriceMax++;

            $offset = ($page * self::DEFAULT_QUANTITY - self::DEFAULT_QUANTITY);
            $query = 'SELECT `products`.`id_product`, `products`.`picture`, `products`.`title`, `products`.`price`, `products`.`status`, `type`.`typeName` 
            FROM `products` 
            INNER JOIN `type` ON `type`.`id_type` = `products`.`id_type` 
            WHERE `products`.`price` BETWEEN '.$PriceMin.' AND '.$PriceMax.' AND `products`.`weight`  BETWEEN '.$weightMin.' AND '.$weightMax.' AND
            `products`.`tipThickness` '.$resultTipThickness.' AND `products`.`status` '.$resultStatus.' AND `products`.`id_inkColor` '.$resultId_inkColor.' AND
            `products`.`id_material` '.$resultId_material.' AND `products`.`id_manufacturer` '.$resultId_manufacturer.' AND `products`.`id_type`'.$resultId_type.' AND 
            `products`.`quantity` <> 0  ORDER BY  '.self::getSortOrder().'
            LIMIT ' . self::DEFAULT_QUANTITY . " OFFSET " . $offset;

            $result = self::query($query);
            
            #если возвращается 1 товар (а 1 товар возвращается в виде ассоциативного массива (т.е. в нем нет элемента с индексом 0)), то оборачиваем его в доп. массив (необходимо для работы цикла foreach во catalogView.php)
            if(!isset($result[0]))$result = array($result);
            
            return $result;
        }
        public static function getQuantityProducts($PriceMin,$PriceMax,$weightMin ,$weightMax, $resultTipThickness="",$resultStatus="IN (0,1)",$resultId_inkColor="", $resultId_material="",$resultId_manufacturer="",$resultId_type="") 
        {
            $PriceMin--;
            $PriceMax++;

            $query = 'SELECT COUNT(`products`.`id_product` ) AS `quantityProducts` FROM `products`
            WHERE `products`.`price` BETWEEN '.$PriceMin.' AND '.$PriceMax.' AND `products`.`weight`  BETWEEN '.$weightMin.' AND '.$weightMax.' AND
            `products`.`tipThickness` '.$resultTipThickness.' AND `products`.`status` '.$resultStatus.' AND `products`.`id_inkColor` '.$resultId_inkColor.' AND
            `products`.`id_material` '.$resultId_material.' AND `products`.`id_manufacturer` '.$resultId_manufacturer.' AND `products`.`id_type`'.$resultId_type.' AND
            `products`.`quantity` <> 0  ';

            $result = self::query($query);

            #Количество страниц
            $resultPage = ceil(($result['quantityProducts']) / self::DEFAULT_QUANTITY); 
            
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
        Private static function createAndDeleteCookie($filterName,$cookieName) 
        {   
            #Удаление cookie
            if(isset($_COOKIE[$cookieName]) && isset($_POST["button"]))setcookie($cookieName,'',time()-3600,"/");

            #Создание cookie, проверка на массив
            if(isset($_POST[$filterName]) && is_array($_POST[$filterName])){
                if( isset($_POST[$filterName]) )setcookie($cookieName ,serialize( $_POST[$filterName]) );
            }
            else {
                if( isset($_POST[$filterName]) )setcookie($cookieName , $_POST[$filterName] );
            }
        }
        // Private
        Private static function getVariableForFiltering($filterName) 
        {
            $IN="IN (";
            $comma=",";
            $bracket = ")";
            #Создание переменной путем склейки нескольких элементов
            if(isset($_COOKIE[$filterName])){
                $result=$IN;
                for($i=0;$i<count( unserialize( $_COOKIE[$filterName]) );$i++){
                    $result.=( unserialize( $_COOKIE[$filterName]) )[$i];
                    if($i<count( unserialize( $_COOKIE[$filterName] ))-1)$result.=$comma;
                }
                $result.=$bracket;
                
            }
            return $result;
        }
        public static function fillingVariablesForFilteringArr($cookieName) 
        {   
            if(isset($_COOKIE[$cookieName]) && !isset($_POST["button"]))$result = self::getVariableForFiltering($cookieName);

            if(isset($_COOKIE[$cookieName])) $result = self::getVariableForFiltering($cookieName);

            if(isset($result))return $result;
        }
        public static function fillingVariablesForFiltering($cookieName) 
        {   
            if(isset($_COOKIE[$cookieName]) && !isset($_POST["button"]))$result=$_COOKIE[$cookieName];

            if(isset($result))return $result;
        }
        public static function fillingInResultStatusVariableForFiltering($cookieName) 
        {   
            if(isset($_COOKIE[$cookieName]) && !isset($_POST["button"]))$result= "IN(1)";

            $result = isset($_COOKIE[$cookieName]) ?  "IN(1)" : "IN (0,1)";
            
            return $result;
        }
        public static function manipulationCookie() 
        {   
            self::createAndDeleteCookie("filterPriceMin","priceMin");
            self::createAndDeleteCookie("filterPriceMax","priceMax");
            self::createAndDeleteCookie("filterWeightMin","weightMin");
            self::createAndDeleteCookie("filterWeightMax","weightMax");
            self::createAndDeleteCookie("filterManufacturer","arrManufacturer");
            self::createAndDeleteCookie("filterMaterial","arrMaterial");
            self::createAndDeleteCookie("filterColor","arrInkColor");
            self::createAndDeleteCookie("filterType","arrType");
            self::createAndDeleteCookie("filterTipThickness","arrTipThickness");
            self::createAndDeleteCookie("filterNewProduct","Status");
            self::createAndDeleteCookie("sortOrder","sortOrder");
        }
        public static function resetCookie() 
        {   
            setcookie('priceMin','',time()-3600,'/');
            setcookie('priceMax','',time()-3600,'/');
            setcookie('weightMin','',time()-3600,'/');
            setcookie('weightMax','',time()-3600,'/');
            setcookie('arrManufacturer','',time()-3600,'/');
            setcookie('arrMaterial','',time()-3600,'/');
            setcookie('arrInkColor','',time()-3600,'/');
            setcookie('arrType','',time()-3600,'/');
            setcookie('arrTipThickness','',time()-3600,'/');
            setcookie('Status','',time()-3600,'/');
            setcookie('sortOrder','',time()-3600,'/');
        }

    }