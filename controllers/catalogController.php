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

            if(!isset($_POST["button"]) && !isset($_COOKIE['priceMin'])){
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

                if(isset($_COOKIE['priceMin']) && isset($_POST["button"]))setcookie('priceMin','',time()-3600,"/");
                if(isset($_COOKIE['priceMax']) && isset($_POST["button"]))setcookie('priceMax','',time()-3600,"/");
                if(isset($_COOKIE['weightMin']) && isset($_POST["button"]))setcookie('weightMin','',time()-3600,"/");
                if(isset($_COOKIE['arrManufacturer']) && isset($_POST["button"]))setcookie('arrManufacturer','',time()-3600,"/");
                if(isset($_COOKIE['arrMaterial']) && isset($_POST["button"]))setcookie('arrMaterial','',time()-3600,"/");
                if(isset($_COOKIE['arrInkColor']) && isset($_POST["button"]))setcookie('arrInkColor','',time()-3600,"/");
                if(isset($_COOKIE['arrType']) && isset($_POST["button"]))setcookie('arrType','',time()-3600,"/");
                if(isset($_COOKIE['arrTipThickness']) && isset($_POST["button"]))setcookie('arrTipThickness','',time()-3600,"/");
                if(isset($_COOKIE['Status']) && isset($_POST["button"]))setcookie('Status','',time()-3600,"/");


                // #Создание cookie
                
                isset($_POST["filterPriceMin"] ) ? setcookie('priceMin',$_POST["filterPriceMin"]) : NULL;
                isset($_POST["filterPriceMax"]) ? setcookie('priceMax',$_POST["filterPriceMax"]):NULL;
                isset($_POST["filterWeightMin"]) ? setcookie('weightMin',$_POST["filterWeightMin"]):NULL;
                isset($_POST["filterWeightMax"]) ? setcookie('weightMax',$_POST["filterWeightMax"]):NULL;
                isset($_POST["filterManufacturer"])  ? setcookie('arrManufacturer',serialize($_POST["filterManufacturer"])):NULL;
                isset($_POST["filterMaterial"]) ? setcookie('arrMaterial',serialize($_POST["filterMaterial"])):NULL;
                isset($_POST["filterColor"]) ? setcookie('arrInkColor',serialize($_POST["filterColor"])):NULL;
                isset($_POST["filterType"]) ? setcookie('arrType',serialize($_POST["filterType"])):NULL;
                isset($_POST["filterTipThickness"]) ? setcookie('arrTipThickness',serialize($_POST["filterTipThickness"])):NULL;
                isset($_POST["filterNewProduct"]) ? setcookie('Status',$_POST["filterNewProduct"]):NULL;

                // var_dump($_COOKIE);
                #
                if(isset($_POST["button"]))header('Location: ../../catalog');
                
                #Заполнение переменных для фильтрации
                if(isset($_COOKIE['priceMin']) && !isset($_POST["button"]))$PriceMin=$_COOKIE["priceMin"];
                if(isset($_COOKIE['priceMax']) && !isset($_POST["button"]))$PriceMax=$_COOKIE["priceMax"];
                if(isset($_COOKIE['weightMin']) && !isset($_POST["button"]))$weightMin=$_COOKIE["weightMin"];
                if(isset($_COOKIE['weightMax']) && !isset($_POST["button"]))$weightMax=$_COOKIE["weightMax"];
                if(isset($_COOKIE['arrManufacturer']) && !isset($_POST["button"]))$resultId_manufacturer = catalogModel::_getVariableForFiltering("arrManufacturer");
                if(isset($_COOKIE['arrMaterial']) && !isset($_POST["button"]))$resultId_material= catalogModel::_getVariableForFiltering("arrMaterial");
                if(isset($_COOKIE['arrInkColor']) && !isset($_POST["button"]))$resultId_inkColor= catalogModel::_getVariableForFiltering("arrInkColor");
                if(isset($_COOKIE['arrType']) && !isset($_POST["button"]))$resultId_type= catalogModel::_getVariableForFiltering("arrType");
                if(isset($_COOKIE['arrTipThickness']) && !isset($_POST["button"]))$resultTipThickness= catalogModel::_getVariableForFiltering("arrTipThickness");
                if(isset($_COOKIE['Status']) && !isset($_POST["button"]))$resultStatus= "IN(1)";


                #
                $resultId_manufacturer = isset($_COOKIE['arrManufacturer']) ?  catalogModel::_getVariableForFiltering("arrManufacturer") : NULL;
                $resultId_material = isset($_COOKIE['arrMaterial']) ?  catalogModel::_getVariableForFiltering("arrMaterial") : NULL;
                $resultId_inkColor = isset($_COOKIE['arrInkColor']) ?  catalogModel::_getVariableForFiltering("arrInkColor") : NULL;
                $resultId_type = isset($_COOKIE['arrType']) ?  catalogModel::_getVariableForFiltering("arrType") : NULL;
                $resultTipThickness = isset($_COOKIE['arrTipThickness']) ?  catalogModel::_getVariableForFiltering("arrTipThickness") : NULL;
                $resultStatus = isset($_COOKIE['Status']) ?  "IN(1)" : "IN (0,1)";

                #
                if(isset($_POST["button"])){
                    $PriceMin=$_COOKIE["priceMin"];
                    $PriceMax=$_COOKIE["priceMax"];
                    $weightMin=$_COOKIE["weightMin"];
                    $weightMax=$_COOKIE["weightMax"];
                }
                // var_dump($resultId_manufacturer);
                // print ('<br>');
                // var_dump($resultId_material);
                // print ('<br>');
                // var_dump($resultId_inkColor);
                // print ('<br>');
                // var_dump($resultId_inkColor);
                // print ('<br>');
                // var_dump($resultId_type);
                // print ('<br>');
                // var_dump($resultTipThickness);
                // print ('<br>');
                // var_dump($resultStatus);
                // print ('<br>');

                

                // var_dump($PriceMin);
                // print ('<br>');
                // var_dump($weightMax);

                

                // var_dump($_COOKIE['priceMin']);
                // var_dump($resultId_manufacturer);
                // print ('<br>');
                // var_dump($resultId_material);
                // print ('<br>');
                // var_dump($resultId_inkColor);
                // print ('<br>');
                // var_dump($resultId_inkColor);
                // print ('<br>');
                // var_dump($resultId_type);
                // print ('<br>');
                // var_dump($resultTipThickness);
                // print ('<br>');
                // var_dump($resultStatus);
                // print ('<br>');


                // #Возвращает количество товаров, попадающих под критерии поиска, их характеристики
                $QuantityPage = catalogModel::getQuantityProducts($PriceMin,$PriceMax,$weightMin,$weightMax,$resultTipThickness,$resultStatus,$resultId_inkColor,$resultId_material,$resultId_manufacturer,$resultId_type);
                
                // #Возвращает список товаров, попадающих под критерии поиска, их характеристики
                $products = catalogModel::getProducts($page,$PriceMin,$PriceMax,$weightMin,$weightMax,$resultTipThickness,$resultStatus,$resultId_inkColor,$resultId_material,$resultId_manufacturer,$resultId_type);











                
                // #Проверка на пустые поля  isset($_COOKIE['resultStatus']
                
                // $PriceMin = isset($_POST["filterPriceMin"]) && !empty($_POST["filterPriceMin"]) ? $_POST['filterPriceMin'] : $PriceWeightProducts['priceMin'];
                // $PriceMax = isset($_POST["filterPriceMax"]) && !empty($_POST["filterPriceMax"]) ? $_POST['filterPriceMax'] : $PriceWeightProducts['priceMax'];
                // $weightMin = isset($_POST["filterWeightMin"]) && !empty($_POST["filterWeightMin"]) ?$_POST['filterWeightMin']: $PriceWeightProducts['weightMin'];
                // $weightMax = isset($_POST["filterWeightMax"]) && !empty($_POST["filterWeightMax"]) ? $_POST['filterWeightMax'] : $PriceWeightProducts['weightMax'] ;
                
                // #Проверка выбранных фильтров
                // $resultId_manufacturer = isset($_POST["filterManufacturer"]) ?  catalogModel::_getVariableForFiltering("filterManufacturer") : NULL;
                // $resultId_material = isset($_POST["filterMaterial"]) ?  catalogModel::_getVariableForFiltering("filterMaterial") : NULL;
                // $resultId_inkColor = isset($_POST["filterColor"]) ?  catalogModel::_getVariableForFiltering("filterColor") : NULL;
                // $resultId_type = isset($_POST["filterType"]) ?  catalogModel::_getVariableForFiltering("filterType") : NULL;
                // $resultTipThickness = isset($_POST["filterTipThickness"]) ?  catalogModel::_getVariableForFiltering("filterTipThickness") : NULL;
                // $resultStatus = isset($_POST["filterNewProduct"]) ?  "IN(1)" : "IN (0,1)";
                
                // #Создание cookie
                // setcookie('priceMin',$PriceMin);
                // setcookie('priceMax',$PriceMax);
                // setcookie('weightMin',$weightMin);
                // setcookie('weightMax',$weightMax);
                // setcookie('resultId_manufacturer',$resultId_manufacturer);
                // setcookie('resultId_material',$resultId_material);
                // setcookie('resultId_inkColor',$resultId_inkColor);
                // setcookie('resultId_type',$resultId_type);
                // setcookie('resultTipThickness',$resultTipThickness);
                // setcookie('resultStatus',$resultStatus);
                
                // #Заполнение переменных для фильтрации
                // if(isset($_COOKIE['priceMin']) && !isset($_POST["button"]))$PriceMin = $_COOKIE['priceMin'];
                // if(isset($_COOKIE['priceMax']) && !isset($_POST["button"]))$PriceMax = $_COOKIE['priceMax'];
                // if(isset($_COOKIE['weightMin']) && !isset($_POST["button"]))$weightMin = $_COOKIE['weightMin'];
                // if(isset($_COOKIE['weightMax']) && !isset($_POST["button"]))$weightMax = $_COOKIE['weightMax'];
                // if(isset($_COOKIE['resultId_manufacturer']) && !isset($_POST["button"]))$resultId_manufacturer = $_COOKIE['resultId_manufacturer'];
                // if(isset($_COOKIE['resultId_material']) && !isset($_POST["button"]))$resultId_material = $_COOKIE['resultId_material'];
                // if(isset($_COOKIE['resultId_inkColor']) && !isset($_POST["button"]))$resultId_inkColor = $_COOKIE['resultId_inkColor'];
                // if(isset($_COOKIE['resultId_type']) && !isset($_POST["button"]))$resultId_type = $_COOKIE['resultId_type'];
                // if(isset($_COOKIE['resultTipThickness']) && !isset($_POST["button"]))$resultTipThickness = $_COOKIE['resultTipThickness'];
                // if(isset($_COOKIE['resultStatus']) && !isset($_POST["button"]))$resultStatus = $_COOKIE['resultStatus'];
                
                // var_dump($PriceMin);
                // var_dump($_COOKIE['priceMin']);

                // #Возвращает количество товаров, попадающих под критерии поиска, их характеристики
                // $QuantityPage = catalogModel::getQuantityProducts($PriceMin,$PriceMax,$weightMin,$weightMax,$resultTipThickness,$resultStatus,$resultId_inkColor,$resultId_material,$resultId_manufacturer,$resultId_type);
                
                // #Возвращает список товаров, попадающих под критерии поиска, их характеристики
                // $products = catalogModel::getProducts($page,$PriceMin,$PriceMax,$weightMin,$weightMax,$resultTipThickness,$resultStatus,$resultId_inkColor,$resultId_material,$resultId_manufacturer,$resultId_type);
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
