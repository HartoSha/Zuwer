<?php 
    require_once(ROOT. "models". DIRECTORY_SEPARATOR. "catalog". DIRECTORY_SEPARATOR . "catalogModel.php");
    require_once(ROOT. "models". DIRECTORY_SEPARATOR. "catalog". DIRECTORY_SEPARATOR . "productModel.php");

    class catalogController # Контроллер каталога
    {
        public function index() # базовый action
        {
            self::page([]); # Переходим на первую страницу по-умолчанию
        }
        public function page($params)  # Переход на страницу по номеру
        {
            # Если страница не передана или не число, то страница = 1
            $page = (isset($params[0]) && !empty($params[0]) && is_numeric($params[0])) ? $params[0] : 1;

            #Возвращает данные о минимальной и максимальной цене, весе
            $PriceWeightProducts = catalogModel::getPriceWeightProducts();

            if(!isset($_POST["button"])){
                $products = catalogModel::getProducts($page,$PriceWeightProducts['priceMin'],$PriceWeightProducts['priceMax'],$PriceWeightProducts['weightMin'],$PriceWeightProducts['weightMax']);
                # Если не получили информацию о товарах, отправляем пользователя на страницу каталога
                
                if($products == NULL) {
                    header('Location: ../../catalog');
                }

                #Возвращает количество товаров, попадающих под критерии поиска, их характеристики
                $QuantityPage = catalogModel::getQuantityProducts($PriceWeightProducts['priceMin'],$PriceWeightProducts['priceMax'],$PriceWeightProducts['weightMin'],$PriceWeightProducts['weightMax']);
            }

            

            #Возвращает список данных о производителях товара
            $ProductManufacturers = catalogModel::getProductManufacturers();
            
            #Возвращает список данных о материалах товара
            $ProductMaterials = catalogModel::getProductMaterial();

            #Возвращает список данных о цветах товара
            $ProductInkColors = catalogModel::getProductInkColor();

            #Возвращает список данных о типах товара
            $ProductTypes = catalogModel::getProductType();

            #Возвращает список данных о толщине пишущий части
            $ProductsTipThickness = catalogModel::getProductsTipThickness();

            #Применение фильтров
            if(isset($_POST["button"])){

                // isset($_POST["filterPriceMin"])?$PriceMin = :$resultId_manufacturer="";
                // isset($_POST["filterPriceMax"])?$PriceMax = :$resultId_material="";
                // if(!isset($_POST["filterPriceMax"]))$PriceMax=$PriceWeightProducts['priceMin'];
                
                // var_dump( $PriceWeightProducts['priceMax']);
                $PriceMin = isset($_POST["filterPriceMin"]) && !empty($_POST["filterPriceMin"]) ? $_POST['filterPriceMin'] : $PriceWeightProducts['priceMin'];
                $PriceMax = isset($_POST["filterPriceMax"]) && !empty($_POST["filterPriceMax"]) ? $_POST['filterPriceMax'] : $PriceWeightProducts['priceMax'];

                $weightMin = isset($_POST["filterWeightMin"]) && !empty($_POST["filterWeightMin"])?$_POST['filterWeightMin']:$PriceWeightProducts['weightMin'];
                $weightMax = isset($_POST["filterWeightMax"]) && !empty($_POST["filterWeightMax"]) ? $_POST['filterWeightMax'] : $PriceWeightProducts['weightMax'] ;
                

                // echo $PriceMin;
                // echo '<br>';
                // echo $PriceMax;
                // echo '<br>';
                // echo $weightMin;
                // echo '<br>';
                // echo $weightMax;
                $resultId_manufacturer = isset($_POST["filterManufacturer"]) ?  catalogModel::_getVariableForFiltering("filterManufacturer") : "";
                $resultId_material = isset($_POST["filterMaterial"]) ?  catalogModel::_getVariableForFiltering("filterMaterial") : "";
                $resultId_inkColor = isset($_POST["filterColor"]) ?  catalogModel::_getVariableForFiltering("filterColor") : "";
                $resultId_type = isset($_POST["filterType"]) ?  catalogModel::_getVariableForFiltering("filterType") : "";
                $resultTipThickness = isset($_POST["filterTipThickness"]) ?  catalogModel::_getVariableForFiltering("filterTipThickness") : "";
                $resultStatus = isset($_POST["filterNewProduct"]) ?  catalogModel::_getVariableForFiltering("filterNewProduct") : "IN (0,1)";

                // var_dump($resultId_manufacturer);
                // echo '<br>';
                // var_dump($resultId_material);
                // echo '<br>';
                // var_dump($resultId_inkColor);
                // echo '<br>';
                // var_dump($resultId_type);
                // echo '<br>';
                // var_dump($resultTipThickness);
                // // echo '<br>';

                // var_dump($resultStatus);

            
                $QuantityPage = catalogModel::getQuantityProducts($PriceMin,$PriceMax,$weightMin,$weightMax,$resultTipThickness,$resultStatus,$resultId_inkColor,$resultId_material,$resultId_manufacturer,$resultId_type);
                // var_dump($QuantityPage);
                $products = catalogModel::getProducts($page,$PriceMin,$PriceMax,$weightMin,$weightMax,$resultTipThickness,$resultStatus,$resultId_inkColor,$resultId_material,$resultId_manufacturer,$resultId_type);
                // var_dump($products);
                # Если не получили информацию о товарах, отправляем пользователя на страницу каталога
                if($products == NULL) {
                    // header('Location: ../../catalog');
                }
            }
            require_once VIEWS . "catalogView.php";
            // var_dump($products);
            
        }
        public function product($params) # Просмотр одного товара
        {
            # Если id продукта не указан в запросе или не число, то считаем его равным 0 (следовательно продукт с id = 0 не будет найден и выполнится перенаправление на ../../catalog)
            $productId = (isset($params[0]) && !empty($params[0]) && is_numeric($params[0])) ? $params[0] : 0;
            $productInfo = productModel::getProductById($productId);

            # Если не получили информацию о товаре, отправляем пользователя на страницу каталога
            if($productInfo == NULL) {
                // header('Location: ../../catalog');
            }
            
            // print "Просмотр Товара. ID: " . $productId . "<br>";
            // var_dump($productInfo);

            require_once VIEWS . "productView.php";
        }
    } 
