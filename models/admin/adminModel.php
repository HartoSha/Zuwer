<?php 
    require_once(ROOT. "models". DIRECTORY_SEPARATOR . "userModel". DIRECTORY_SEPARATOR . "userModel.php");

    class adminModel extends userModel
    {
        public static function isAdmin() {
            return boolval(self::userIsLoggedIn() && isset($_SESSION['user']['status']));
        }

        private static function getIdProductInkColor($productColor)
        {
            // получаем id цвета если существует то сразу возвращаем его
            $result = self::query('CALL selectProductInkColor');
            foreach ($result as $key => $value)
            {
                if($productColor == $value['colorName']) 
                {
                    $result = $value['id_inkColor'];
                    return $result;
                }
            }

            // если не повезло и его нет то добавляем новый цвет в бд и проворачиваем все еще раз чтобы получить Id(возможно костыль но я устал и лень думтаь (та и вроде работает))
            if(!is_numeric($result))
            {
                $result = self::createProductInkColor($productColor);
                foreach ($result as $key => $value)
                {
                    if($productColor == $value['colorName']) 
                    {
                        $result = $value['id_inkColor'];
                        return $result;
                    }
                }
            }
        }

        private static function getIdProductMaterial($productMaterial)
        {
            //все то же что и выше
            $result = self::query('CALL selectProductMaterial');
            foreach ($result as $key => $value)
            {
                if($productMaterial == $value['materialName']) 
                {
                    $result = $value['id_material'];
                    return $result;
                }
            }

            if(!is_numeric($result))
            {
                $result = self::createProductMaterial($productMaterial);
                foreach ($result as $key => $value)
                {
                    if($productMaterial == $value['materialName']) 
                    {
                        $result = $value['id_material'];
                        return $result;
                    }
                }
            }
        }

        private static function checkProductManufecturer($productManufacturer)
        {
            //все то же что и выше но не совсем тут ошипки если производителя не существует
            $result = self::query('CALL selectProductManufacturer');
            foreach ($result as $key => $value)
            {
                if($productManufacturer == $value['manufacturerName']) 
                {
                    $result = $value['id_manufacturer'];
                    return $result;
                }
            }
            if(!is_numeric($result)) echo"ОШИБКИ ПОВСЮДУ 〣( ºΔº )〣";
        }
        private static function checkProductType($productMaterial)
        {
            //все то же что и выше
            $result = self::query('CALL selectProductType');
            foreach ($result as $key => $value)
            {
                if($productMaterial == $value['typeName']) 
                {
                    $result = $value['id_type'];
                    return $result;
                }
            }
            if(!is_numeric($result)) echo"ОШИБКИ ПОВСЮДУ2 〣( ºΔº )〣";
        }

        private static function createProductInkColor($productColor)
        {
            self::query("SET @p0='" . $productColor . "'");
            self::query('CALL insertInkColor(@p0)');

            $result = self::query('CALL selectProductInkColor');
            return $result;
        }
        private static function createProductMaterial($productMaterial)
        {
            $result = self::query("SET @p0='" . $productMaterial . "'");
            self::query('CALL insertMaterial(@p0)');

            $result = self::query('CALL selectProductMaterial');
            return $result;
        }

        public static function getProductManufecturer()
        {
            $result = self::query('CALL selectProductManufacturer');

            return $result;
        }
        public static function getProductType()
        {
            $result = self::query('CALL selectProductType');
            
            return $result;
        }

        public static function encodeImg($imgPath)
        {
            if (is_uploaded_file($imgPath))
            {
                $picture = addslashes(file_get_contents($imgPath));
                var_dump($picture);
                if($picture) return $picture;
            }
            return false;
        }

        public static function saveProductChanges($productId, $productTitle, $productDescription, $productPrice, $productWeight, $productQuantity, $productTipThickness, $encodedImg, $status, $productColor, $productMaterial, $productManufacturer, $typeId) 
        {
            $productIdInkColor = self::getIdProductInkColor($productColor);
            $productIdMaterial = self::getIdProductMaterial($productMaterial);
            $productIdManufacturer = self::checkProductManufecturer($productManufacturer);
            $productIdType = self::checkProductType($typeId);
            // if(!$fileDir) $picture = $basePicture;
            // else $picture = addslashes(file_get_contents($fileDir));
            // var_dump($encodedImg);

            self::query("SET @p0='" . $productId . "'");
            self::query("SET @p1='" . $productTitle . "'");
            self::query("SET @p2='" . $productDescription . "'");
            self::query("SET @p3='" . $productPrice . "'");
            self::query("SET @p4='" . $productWeight . "'");
            self::query("SET @p5='" . $productQuantity . "'");
            self::query("SET @p6='" . $productTipThickness . "'");
            self::query("SET @p7='" . $encodedImg . "'");
            self::query("SET @p8='" . $status . "'");
            self::query("SET @p9='" . $productIdInkColor . "'");
            self::query("SET @p10='" . $productIdMaterial . "'");
            self::query("SET @p11='" . $productIdManufacturer . "'");
            self::query("SET @p12='" . $productIdType . "'");

            self::query('CALL updateProduct(@p0, @p1, @p2, @p3, @p4, @p5, @p6, @p7, @p8, @p9, @p10, @p11, @p12)');
        }

        public static function deleteProduct($productId)
        {
            self::query("SET @p0='" . $productId . "'");

            self::query('CALL deleteProduct(@p0)');
            self::query('CALL deleteElectProducts(@p0)');
        }

        public static function addProduct($productTitle, $productDescription, $productPrice, $productWeight, $productQuantity, $productTipThickness, $fileDir, $status, $productColor, $productMaterial, $productManufacturer, $typeId)
        {
            $productIdInkColor = self::getIdProductInkColor($productColor);
            $productIdMaterial = self::getIdProductMaterial($productMaterial);
            $productIdManufacturer = self::checkProductManufecturer($productManufacturer);
            $productIdType = self::checkProductType($typeId);
            $picture = addslashes(file_get_contents($fileDir));
	
            self::query("SET @p0='" . $productTitle . "'");
            self::query("SET @p1='" . $productDescription . "'");
            self::query("SET @p2='" . $productPrice . "'");
            self::query("SET @p3='" . $productWeight . "'");
            self::query("SET @p4='" . $productQuantity . "'");
            self::query("SET @p5='" . $productTipThickness . "'");
            self::query("SET @p6='" . $picture . "'");
            self::query("SET @p7='" . $status . "'");
            self::query("SET @p8='" . $productIdInkColor . "'");
            self::query("SET @p9='" . $productIdMaterial . "'");
            self::query("SET @p10='" . $productIdManufacturer . "'");
            self::query("SET @p11='" . $productIdType . "'");

            self::query('CALL insertProduct(@p0, @p1, @p2, @p3, @p4, @p5, @p6, @p7, @p8, @p9, @p10, @p11)');
        }
}