<?php 
    require_once(ROOT. "models". DIRECTORY_SEPARATOR. "catalog". DIRECTORY_SEPARATOR . "catalogModel.php");
    require_once(ROOT. "models". DIRECTORY_SEPARATOR. "catalog". DIRECTORY_SEPARATOR . "productModel.php");
    require_once(ROOT . "models" . DIRECTORY_SEPARATOR . "userModel" . DIRECTORY_SEPARATOR . "userModel.php");

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

            if(!isset($_POST["button"]) && !isset($_COOKIE['resultStatus'])){
                $products = catalogModel::getProducts($page,$PriceWeightProducts['priceMin'],$PriceWeightProducts['priceMax'],$PriceWeightProducts['weightMin'],$PriceWeightProducts['weightMax']);
                # Если не получили информацию о товарах, отправляем пользователя на страницу каталога
                
                if($products == NULL) {
                    header('Location: /catalog/');
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
            if(isset($_POST["button"]) || isset($_COOKIE['resultStatus'])){
                
                #Проверка на пустые поля  isset($_COOKIE['resultStatus']
                $PriceMin = isset($_POST["filterPriceMin"]) && !empty($_POST["filterPriceMin"]) ? $_POST['filterPriceMin'] : $PriceWeightProducts['priceMin'];
                $PriceMax = isset($_POST["filterPriceMax"]) && !empty($_POST["filterPriceMax"]) ? $_POST['filterPriceMax'] : $PriceWeightProducts['priceMax'];
                $weightMin = isset($_POST["filterWeightMin"]) && !empty($_POST["filterWeightMin"]) ?$_POST['filterWeightMin']: $PriceWeightProducts['weightMin'];
                $weightMax = isset($_POST["filterWeightMax"]) && !empty($_POST["filterWeightMax"]) ? $_POST['filterWeightMax'] : $PriceWeightProducts['weightMax'] ;
                
                #Проверка выбранных фильтров
                $resultId_manufacturer = isset($_POST["filterManufacturer"]) ?  catalogModel::_getVariableForFiltering("filterManufacturer") : NULL;
                $resultId_material = isset($_POST["filterMaterial"]) ?  catalogModel::_getVariableForFiltering("filterMaterial") : NULL;
                $resultId_inkColor = isset($_POST["filterColor"]) ?  catalogModel::_getVariableForFiltering("filterColor") : NULL;
                $resultId_type = isset($_POST["filterType"]) ?  catalogModel::_getVariableForFiltering("filterType") : NULL;
                $resultTipThickness = isset($_POST["filterTipThickness"]) ?  catalogModel::_getVariableForFiltering("filterTipThickness") : NULL;
                $resultStatus = isset($_POST["filterNewProduct"]) ?  "IN(1)" : "IN (0,1)";
                
                #Создание cookie
                setcookie('resultId_manufacturer',$resultId_manufacturer);
                setcookie('resultId_material',$resultId_material);
                setcookie('resultId_inkColor',$resultId_inkColor);
                setcookie('resultId_type',$resultId_type);
                setcookie('resultTipThickness',$resultTipThickness);
                setcookie('resultStatus',$resultStatus);
                
                #Заполнение переменных для фильтрации
                if(isset($_COOKIE['PriceMin']) && !isset($_POST["button"]))$PriceMin = $_COOKIE['PriceMin'];
                if(isset($_COOKIE['PriceMax']) && !isset($_POST["button"]))$PriceMax = $_COOKIE['PriceMax'];
                if(isset($_COOKIE['weightMin']) && !isset($_POST["button"]))$weightMin = $_COOKIE['weightMin'];
                if(isset($_COOKIE['weightMax']) && !isset($_POST["button"]))$weightMax = $_COOKIE['weightMax'];
                if(isset($_COOKIE['resultId_manufacturer']) && !isset($_POST["button"]))$resultId_manufacturer = $_COOKIE['resultId_manufacturer'];
                if(isset($_COOKIE['resultId_material']) && !isset($_POST["button"]))$resultId_material = $_COOKIE['resultId_material'];
                if(isset($_COOKIE['resultId_inkColor']) && !isset($_POST["button"]))$resultId_inkColor = $_COOKIE['resultId_inkColor'];
                if(isset($_COOKIE['resultId_type']) && !isset($_POST["button"]))$resultId_type = $_COOKIE['resultId_type'];
                if(isset($_COOKIE['resultTipThickness']) && !isset($_POST["button"]))$resultTipThickness = $_COOKIE['resultTipThickness'];
                if(isset($_COOKIE['resultStatus']) && !isset($_POST["button"]))$resultStatus = $_COOKIE['resultStatus'];
                
                setcookie('PriceMin',$PriceMin);
                setcookie('PriceMax',$PriceMax);
                setcookie('weightMin',$weightMin);
                setcookie('weightMax',$weightMax);

                #Возвращает количество товаров, попадающих под критерии поиска, их характеристики
                $QuantityPage = catalogModel::getQuantityProducts($PriceMin,$PriceMax,$weightMin,$weightMax,$resultTipThickness,$resultStatus,$resultId_inkColor,$resultId_material,$resultId_manufacturer,$resultId_type);
                
                #Возвращает список товаров, попадающих под критерии поиска, их характеристики
                $products = catalogModel::getProducts($page,$PriceMin,$PriceMax,$weightMin,$weightMax,$resultTipThickness,$resultStatus,$resultId_inkColor,$resultId_material,$resultId_manufacturer,$resultId_type);
            }
            require_once VIEWS . "catalogView.php";
            
        }
        public function product($params) # Просмотр одного товара
        {
            //получаем данные пользователя если он есть
            $userName = (!empty($_SESSION['user']['name'])) ? $_SESSION['user']['name'] : '';
            $userSurename = (!empty($_SESSION['user']['surname'])) ? $_SESSION['user']['surname'] : '';
            $userPatronymic = (!empty($_SESSION['user']['patronymic'])) ? $_SESSION['user']['patronymic'] : '';
            $userPhone = (!empty($_SESSION['user']['telephone'])) ? $_SESSION['user']['telephone'] : '';
            # Если id продукта не указан в запросе или не число, то считаем его равным 0 (следовательно продукт с id = 0 не будет найден и выполнится перенаправление на ../../catalog)
            $productId = (isset($params[0]) && !empty($params[0]) && is_numeric($params[0])) ? $params[0] : 0;
            $productInfo = productModel::getProductById($productId);

            //записываем цену одного товара для отправки при совершении заказа addOrder()
            $_SESSION['productId'] = $productId;

            # Если не получили информацию о товаре, отправляем пользователя на страницу каталога
            if($productInfo == NULL) {
                header('Location: ../../catalog');
            }
            
            // print "Просмотр Товара. ID: " . $productId . "<br>";
            // var_dump($productInfo);

            require_once VIEWS . "productView.php";
        }
        public function addOrder()
        {
            // var_dump($_POST['oneProductPrice']);
            if(userModel::userIsLoggedIn())
            {
                $errors = array();
                if($_POST['name'] == '') {
                    $errors[] = "Введите имя";
                }
                elseif(mb_strlen($_POST['name']) > 15){
                    $errors[] = "имя слишком длинное";
                }

                if($_POST["surname"] == '') {
                    $errors[] = "Введите Фамилию";
                }
                elseif(mb_strlen($_POST["surname"]) > 20){
                    $errors[] = "Фамилия слишком длинная";
                }

                if($_POST['patronymic'] == '') {
                    $errors[] = "Введите имя";
                }
                elseif(mb_strlen($_POST['patronymic']) > 20){
                    $errors[] = "Отчество слишком длинное";
                }

                if($_POST['city'] == '') {
                    $errors[] = "Введите город";
                }
                elseif(mb_strlen($_POST['city']) > 30){
                    $errors[] = "Название города слишком длинное";
                }

                if($_POST['street'] == '') {
                    $errors[] = "Введите улицу";
                }
                elseif(mb_strlen($_POST['street']) > 30){
                    $errors[] = "Название улицы слишком длинное";
                }

                if($_POST['house'] == '') {
                    $errors[] = "Введите номер дома";
                }
                elseif(mb_strlen($_POST['house']) > 10){
                    $errors[] = "Номер дома слишком длинный";
                }

                if($_POST['postal-code'] == '') {
                    $errors[] = "Введите почтовый индекс";
                }
                elseif(mb_strlen($_POST['postal-code']) > 6){
                    $errors[] = "Почтовый индекс слишком длинный";
                }
                if(!preg_match("/^\d{6}$/", $_POST['postal-code'])){
                    $errors[] = "Почтовый индекс должен содержать только цифры";
                }
                
                //TODO: сделать нормальную проверку телефона
                if($_POST['phone'] == ''){ 
                    $errors[] = "Введите Телефон";
                }
                elseif(mb_strlen($_POST['phone']) > 11) {
                    $errors[] = "Телефон слишком длинный";
                }
                elseif(mb_strlen($_POST['phone']) < 11) {
                    $errors[] = "Телефон слишком короткий";
                }

                if (empty($errors)) {
                    if(!empty($_SESSION))
                    {
                        //
                        $userId = $_SESSION['user']["id_user"];
                        $productInfo = productModel::getProductById($_SESSION["productId"]);
                        $productId = $_SESSION["productId"];
                        $totalQuantity = $productInfo["quantity"];
                        $quantity = $_POST['order-product-quantity'];
                        $productPrice = $productInfo["price"] * $quantity;

                        //проверяем существует ли такой адрес в бд иначе создаем его
                        $adressId = productModel::adressCheck(
                            $_POST['city'], 
                            $_POST['street'], 
                            $_POST['house'], 
                            $_POST['postal-code']
                        );

                        if(!$adressId)
                        {
                            $adressId = productModel::createDeliveryAddress(
                                $_POST['city'], 
                                $_POST['street'], 
                                $_POST['house'], 
                                $_POST['postal-code']
                            );
                        }
                        productModel::ordering($productId, 
                            $_POST['name'], 
                            $_POST["surname"], 
                            $_POST['patronymic'],  
                            $adressId["id_deliveryAddress"], 
                            $_POST['phone'],
                            $quantity,
                            $userId,
                            $productPrice   
                        );
                        productModel::updateProductQuantity($productId, $totalQuantity, $quantity);
                        header('Location: ' . $_SERVER['HTTP_REFERER']);
                    }
                } else {
                    echo '<div style="color: red;">' . array_shift($errors) . '</div>';
                    var_dump($errors);
                }
            }
            else
            {
                
            }
        }
    } 
