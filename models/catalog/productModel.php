<?php
require_once(ROOT . "models" . DIRECTORY_SEPARATOR . "baseModel.php");

class productModel extends baseModel
{
    public static function getProductById($productId)
    {
        $query = "CALL selectProduct(" . $productId . ");";
        return self::query($query);
    }

    public static function tryMakeAnOrder($productId, $userId, $name, $surname, $patronymic, $city, $street, $house, $postalCode, $phone, $quantity)
    {
        if ($quantity) {
            $product = self::getProductById($productId);
            $inStockQuantity = $product["quantity"];

            if ($inStockQuantity) {
                //проверяем существует ли такой адрес в бд иначе создаем его
                $adressId = self::adressCheck($city, $street, $house, $postalCode)["id_deliveryAddress"];
                if (!$adressId) {
                    $adressId = productModel::createDeliveryAddress($city, $street, $house, $postalCode)["id_deliveryAddress"];
                }

                # Если покупается количество продукта больше, чем его на скаладе
                if ($inStockQuantity - $quantity >= 0) {
                    // var_dump($adressId);
                    $productPrice = $product["price"];
                    $totalPrice = $quantity * $productPrice;
                    self::query("SET @p0='" . $productId . "'");
                    self::query("SET @p1='" . $userId . "'");
                    self::query("SET @p2='" . $quantity . "'");
                    self::query("SET @p3='" . $totalPrice . "'");
                    self::query("SET @p4='" . $name . "'");
                    self::query("SET @p5='" . $surname . "'");
                    self::query("SET @p6='" . $patronymic . "'");
                    self::query("SET @p7='" . $phone . "'");
                    self::query("SET @p8='" . $adressId . "'");
                    self::query('CALL insertOrder(@p0,@p1,@p2,@p3,@p4,@p5,@p6,@p7,@p8)');
                    self::updateProductQuantity($productId, $inStockQuantity - $quantity);
                } else {
                    throw new Exception("You can't purchase " . $quantity . " of the product. There is only " . $inStockQuantity . " left in the stock");
                }
            } else {
                throw new Exception("Product is out of stock");
            }
        } else {
            throw new Exception("Quantity must be positive");
        }
    }

    public static function switchFavorite($productId, $userId)
    {
        self::query("SET @p0='$userId'");
        self::query("SET @p1='$productId'");
        try 
        {
            $productIsFavorite = self::isProductFavoriteForUser($productId, $userId);
            if($productIsFavorite)
            {
                # Удаляем товар из избранных, если он был в них
                self::query("CALL deleteElectProduct(@p0,@p1)");
            }
            else
            {
                # Иначе, добавляем товар в избранное
                self::query("CALL insertElectProduct(@p0,@p1)");
            }
        }
        catch(Exception $e) { throw $e; }
    }

    public static function dropFavorite($productId, $userId)
    {
        try 
        {
            # Удаляем товар из избранных, только если он в избранных пользователя
            if(self::isProductFavoriteForUser($productId, $userId) === true) 
            {
                self::switchFavorite($productId, $userId);
            }
            else throw new Exception("Product with id $productId isn't favorite for user with id $userId");
            
        }
        # Передаем полученную ошибку выше
        catch(Exception $e) { throw $e; }
    }

    private static function productExists($productId) {
        return boolval(self::query("CALL isThereProduct($productId)"));
    }

    public static function isProductFavoriteForUser($productId, $userId)
    {
        self::query("SET @p0='$userId'");
        self::query("SET @p1='$productId'");
        # проверка на несуществующий id продукта
        if(self::productExists($productId)) {
            return boolval(self::query("CALL isInUserFavoites(@p0,@p1)"));
        }
        else throw new Exception("Product with id $productId doen't exist"); 
    }

    private static function adressCheck($city, $street, $house, $postalCode)
    {
        self::query("SET @p0='" . $city . "'");
        self::query("SET @p1='" . $street . "'");
        self::query("SET @p2='" . $house . "'");
        self::query("SET @p3='" . $postalCode . "'");

        $result = self::query('CALL selectDeliveryAddress_id(@p0,@p1,@p2,@p3)');
        return $result;
    }

    private static function createDeliveryAddress($city, $street, $house, $postalCode)
    {
        self::query("SET @p0='" . $city . "'");
        self::query("SET @p1='" . $street . "'");
        self::query("SET @p2='" . $house . "'");
        self::query("SET @p3='" . $postalCode . "'");

        self::query('CALL insertDeliveryAddress(@p0,@p1,@p2,@p3)');

        //получаем новый id адреса доставки так как insertDeliveryAddress не возвращает новый id, а он необходим для дальнейшей работы 
        $result = self::query('CALL selectDeliveryAddress_id(@p0,@p1,@p2,@p3)');
        return $result;
    }

    private static function updateProductQuantity($productId, $quantityBecome)
    {
        self::query("SET @p0='" . $productId . "'");
        self::query("SET @p1='" . $quantityBecome . "'");
        self::query('CALL updateProductQuantity(@p0,@p1)');
    }
}
