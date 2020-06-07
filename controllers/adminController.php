<?php 
    require_once(ROOT. "models". DIRECTORY_SEPARATOR. "admin". DIRECTORY_SEPARATOR . "adminModel.php");
    require_once(ROOT. "models". DIRECTORY_SEPARATOR. "catalog". DIRECTORY_SEPARATOR . "productModel.php");
    require_once(ROOT. "models". DIRECTORY_SEPARATOR. "catalog". DIRECTORY_SEPARATOR . "catalogModel.php");

    class adminController
    {
        public function index() {
            header('Location: /');
        }
        public function editingPage($params)  
        {
            if(adminModel::userIsAdmin())
            {
                $productId = (isset($params[0]) && !empty($params[0]) && is_numeric($params[0])) ? $params[0] : 0;
                $productInfo = productModel::getProductById($productId);

                $productManufacturers = catalogModel::getProductManufacturers();
                $productMaterials = catalogModel::getProductMaterial();
                $productTypes = catalogModel::getProductType();
                $productColors = catalogModel::getProductInkColor();
                $tipThiknesses = catalogModel::getProductsTipThickness();

                require_once(VIEWS . "producteditView.php");
            }
            else header('Location: /');
        }
        public function saveProductChanges($params) 
        {
            if(adminModel::userIsLoggedIn() && adminModel::userIsAdmin())
            {
                $productId = (isset($params[0]) && !empty($params[0]) && is_numeric($params[0])) ? $params[0] : 0;
                if($productId && isset($_POST['save'])) 
                {
                    $errors = array();
                    if($_POST['productName'] == "") $errors[] = "Введите название ручки";
                    if($_POST['textarea'] == "") $errors[] = "Введите описание ручки";
                    if($_POST['productPrice'] == "") $errors[] = "Введите цену ручки";
                    if($_POST['productWeight'] == "") $errors[] = "Введите вес ручки";
                    if($_POST['productTipThickness'] == "") $errors[] = "Введите толщину пишущей части ручки";
                    if($_POST['productColor'] == "") $errors[] = "Введите цвет ручки";
                    if($_POST['productMaterial'] == "") $errors[] = "Введите материал ручки";
                    if($_POST['manufacturerName'] == "") $errors[] = "Введите производителя ручки";
                    if($_POST['productType'] == "") $errors[] = "Введите тип ручки";

                    if(empty($errors)) 
                    {
                        $productStatus = isset($_POST["checkbox"]) ? 1 : 0;
                        if(isset($_FILES["photo"]["tmp_name"]) && $_FILES["photo"]["tmp_name"])
                        {
                            // print "Кастомная картинка";
                            $newImg = adminModel::encodeImg($_FILES["photo"]["tmp_name"]);
                            adminModel::changeProductImage($productId, $newImg);
                        }

                        $productName = trim($_POST['productName']);
                        $textarea = trim($_POST['textarea']);
                        $productPrice = trim($_POST['productPrice']);
                        $productWeight = trim($_POST['productWeight']);
                        $productQuantity = trim($_POST['productQuantity']);
                        $productTipThickness = trim($_POST['productTipThickness']);
                        $productColor = trim($_POST['productColor']);
                        $productMaterial = trim($_POST['productMaterial']);
                        $manufacturerName = trim($_POST['manufacturerName']);
                        $productType = trim($_POST['productType']);

                        adminModel::changeProductDescription(
                            $productId,
                            $productName,
                            $textarea,
                            $productPrice,
                            $productWeight,
                            $productQuantity,
                            $productTipThickness,
                            $productStatus,
                            $productColor,
                            $productMaterial,
                            $manufacturerName,
                            $productType
                        );
                    }
                    else 
                    {
                        $_SESSION["admin-product-errors"] = $errors;
                    }
                    header('Location: ' . $_SERVER['HTTP_REFERER']);
                }   
            }
            else header('Location: /');
        } 
        public function deleteProduct($params)
        {
            if(isset($_POST['delete']) && adminModel::userIsLoggedIn() && $_SESSION['user']['status'])
            {
                $productId = (isset($params[0]) && !empty($params[0]) && is_numeric($params[0])) ? $params[0] : 0;
                adminModel::deleteProduct($productId);
                header('Location: ../../catalog');
            }
            else header('Location: /');
        }  
        public function addProductPage()
        {
            if(adminModel::userIsAdmin())
            {
                $productManufacturers = catalogModel::getProductManufacturers();
                $productMaterials = catalogModel::getProductMaterial();
                $productTypes = catalogModel::getProductType();
                $productColors = catalogModel::getProductInkColor();
                $tipThiknesses = catalogModel::getProductsTipThickness();          
                require_once(VIEWS . "producteditView.php");
            }
            else header('Location: /');
        }
        public function addProduct()
        {
            if(isset($_POST['save']) && adminModel::userIsLoggedIn() && $_SESSION['user']['status'])
            {
                $productStatus = 0;
                if(isset($_POST["checkbox"])) $productStatus = 1;
                
                $errors = array();
                if($_POST['productName'] == "") $errors[] = "Введите название ручки";
                if($_POST['textarea'] == "") $errors[] = "Введите описание ручки";
                if($_POST['productPrice'] == "") $errors[] = "Введите цену ручки";
                if($_POST['productWeight'] == "") $errors[] = "Введите вес ручки";
                if($_POST['productTipThickness'] == "") $errors[] = "Введите толщину пишущей части ручки";
                if($_POST['productColor'] == "") $errors[] = "Введите цвет ручки";
                if($_POST['productMaterial'] == "") $errors[] = "Введите материал ручки";
                if($_FILES["photo"]["tmp_name"] == "") $errors[] = "Ввставьте изображение ручки";
                if($_POST['manufacturerName'] == "") $errors[] = "Введите производителя ручки";
                if($_POST['productType'] == "") $errors[] = "Введите тип ручки";

                if (empty($errors)) 
                {
                    adminModel::addProduct(
                        $_POST['productName'],
                        $_POST['textarea'],
                        $_POST['productPrice'],
                        $_POST['productWeight'],
                        $_POST['productQuantity'],
                        $_POST['productTipThickness'],
                        $_FILES["photo"]["tmp_name"],
                        $productStatus,
                        $_POST['productColor'],
                        $_POST['productMaterial'],
                        $_POST['manufacturerName'],
                        $_POST['productType']
                    );
                }
                else
                {
                    $_SESSION["admin-product-errors"] = $errors;
                }
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
        }
    }