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

            $products = catalogModel::getProducts($page);
            
            # Если не получили информацию о товарах, отправляем пользователя на страницу каталога
            if($products == NULL) {
                header('Location: ../../catalog');
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
                header('Location: ../../catalog');
            }
            
            print "Просмотр Товара. ID: " . $productId . "<br>";

            var_dump($productInfo);
        }
    } 
