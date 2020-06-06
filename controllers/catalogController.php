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

            if(!isset($_POST["button"]) && !isset($_COOKIE['priceMin'])){
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
            if(isset($_POST["button"]) || isset($_COOKIE['priceMin'])){

                #создать и удалить cookie
                catalogModel::createAndDeleteCookie("filterPriceMin","priceMin");
                catalogModel::createAndDeleteCookie("filterPriceMax","priceMax");
                catalogModel::createAndDeleteCookie("filterWeightMin","weightMin");
                catalogModel::createAndDeleteCookie("filterWeightMax","weightMax");
                catalogModel::createAndDeleteCookie("filterManufacturer","arrManufacturer");
                catalogModel::createAndDeleteCookie("filterMaterial","arrMaterial");
                catalogModel::createAndDeleteCookie("filterColor","arrInkColor");
                catalogModel::createAndDeleteCookie("filterType","arrType");
                catalogModel::createAndDeleteCookie("filterTipThickness","arrTipThickness");
                catalogModel::createAndDeleteCookie("filterNewProduct","Status");

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
            # Получаем данные пользователя если он есть (используем в productView.php)
            $userName = (!empty($_SESSION['user']['name'])) ? $_SESSION['user']['name'] : '';
            $userSurename = (!empty($_SESSION['user']['surname'])) ? $_SESSION['user']['surname'] : '';
            $userPatronymic = (!empty($_SESSION['user']['patronymic'])) ? $_SESSION['user']['patronymic'] : '';
            $userPhone = (!empty($_SESSION['user']['telephone'])) ? $_SESSION['user']['telephone'] : '';
            # Если id продукта не указан в запросе или не число, то считаем его равным 0 (следовательно продукт с id = 0 не будет найден и выполнится перенаправление на ../../catalog)
            $productId = (isset($params[0]) && !empty($params[0]) && is_numeric($params[0])) ? $params[0] : 0;
            $productInfo = productModel::getProductById($productId);

            # Записываем цену одного товара для отправки при совершении заказа addOrder()
            $_SESSION['productId'] = $productId;

            # Если не получили информацию о товаре, отправляем пользователя на страницу каталога
            if($productInfo == NULL) {
                header('Location: ../../catalog');
            }
            
            // print "Просмотр Товара. ID: " . $productId . "<br>";
            // var_dump($productInfo)

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
                    $errors[] = "Почтовый индекс должен состоять из 6 цифр";
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
                        try
                        {
                            productModel::tryMakeAnOrder(
                                $_SESSION["productId"], 
                                $_SESSION['user']["id_user"],
                                $_POST['name'], 
                                $_POST["surname"], 
                                $_POST['patronymic'],
                                $_POST['city'], 
                                $_POST['street'], 
                                $_POST['house'], 
                                $_POST['postal-code'],
                                $_POST['phone'],
                                $_POST['order-product-quantity']
                            );
                        }
                        catch (Exception $e) 
                        {
                            # Если произошла серверная ошибка при заказе (например, заказано продукта больше, чем его на складе), сохраняем их в сессии
                            $_SESSION['order-errors'] = array();
                            $_SESSION['order-errors'][] = $e->getMessage();
                        }

                        header('Location: ' . $_SERVER['HTTP_REFERER']);
                    }
                } 
                else 
                {
                    # Сохраняем сообщения об ошибках в сессии и возвращаем пользователя обратно на страницу заказа
                    $_SESSION['order-errors'] = $errors;
                    header('Location: ' . $_SERVER['HTTP_REFERER']);
                }
            }
            else
            {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
        }
    } 
