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

            #Cброс фильтров
            if(isset($_POST["reset"])){
                catalogModel::resetCookie();
                #Переадресация для cookie
                header('Location: ../../catalog');
                var_dump("");
            }

            if(!isset($_POST["button"]) && !isset($_COOKIE['priceMin']) ){
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
            if(isset($_POST["button"]) || isset($_COOKIE['priceMin'])){

                #создать и удалить cookie
                catalogModel::manipulationCookie();

                #Переадресация для cookie
                if(isset($_POST["button"]))header('Location: ../../catalog');
                
                #Заполнение переменных для фильтрации(number)
                $PriceMin = catalogModel::fillingVariablesForFiltering("priceMin");
                $PriceMax = catalogModel::fillingVariablesForFiltering("priceMax");
                $weightMin = catalogModel::fillingVariablesForFiltering("weightMin");
                $weightMax = catalogModel::fillingVariablesForFiltering("weightMax");
                #Заполнение переменных для фильтрации(checkbox)
                $resultId_manufacturer = catalogModel::fillingVariablesForFilteringArr("arrManufacturer");
                $resultId_material = catalogModel::fillingVariablesForFilteringArr("arrMaterial");
                $resultId_inkColor = catalogModel::fillingVariablesForFilteringArr("arrInkColor");
                $resultId_type = catalogModel::fillingVariablesForFilteringArr("arrType");
                $resultTipThickness = catalogModel::fillingVariablesForFilteringArr("arrTipThickness");
                #Заполнение переменной ResultStatus для фильтрации(checkbox)
                $resultStatus = catalogModel::fillingInResultStatusVariableForFiltering("Status");

                #Возвращает количество товаров, попадающих под критерии поиска, их характеристики
                $QuantityPage = catalogModel::getQuantityProducts($PriceMin,$PriceMax,$weightMin,$weightMax,$resultTipThickness,$resultStatus,$resultId_inkColor,$resultId_material,$resultId_manufacturer,$resultId_type);
                
                #Возвращает список товаров, попадающих под критерии поиска, их характеристики
                $products = catalogModel::getProducts($page,$PriceMin,$PriceMax,$weightMin,$weightMax,$resultTipThickness,$resultStatus,$resultId_inkColor,$resultId_material,$resultId_manufacturer,$resultId_type);
            }
            require_once VIEWS . "catalogView.php";
            
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
