<?php 
    require_once(ROOT. "models". DIRECTORY_SEPARATOR. "catalog". DIRECTORY_SEPARATOR . "productModel.php");
    require_once(ROOT. "models". DIRECTORY_SEPARATOR. "catalog". DIRECTORY_SEPARATOR . "catalogModel.php");
    
    class catalogController # Контроллер каталога
     {
        public function index($params) 
        {
            #Если page не указан в запросе, то считаем его равным 0
            $page = (isset($params[0]) && !empty($params[0])) ? $params[0] : 0;

            $products = catalogModel::getProducts($page);
            print "Просмотр Каталога page: " . $page;
            var_dump($products);
        }
        public function product($params) # action для просмотра одного товара
        {
            #Если id продукта не указан в запросе, то считаем его равным 0
            $productId = (isset($params[0]) && !empty($params[0])) ? $params[0] : 0;
            $productInfo = productModel::getProductById($productId);

            # Если не получили информацию о товаре, отправляем пользователя на страницу каталога
            if($productInfo == NULL) {
                header('Location: ../../catalog');
            }
            
            var_dump($productInfo);
        }
    }