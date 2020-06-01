<?php
require_once(VIEWS . "shared" . DIRECTORY_SEPARATOR . "headerView.php");
// var_dump($productInfo);
?>
<main class="product-page">
    <div class="container">
        <div class="main-container">
            <div class="product-name">
                <span><?php echo $productInfo["title"]; ?></span>
            </div>
            <div class="product">
                <div class="product-img-container">
                    <label class="product-img-wrapper" for="like-checkbox">
                            <?php 
                                $img = base64_encode($productInfo["picture"]);
                                echo "<img class=\"product-img\" src=\"data:image/jpeg; base64,$img\" alt=\"product image\" >";
                             ?>
                    </label>
                    <input type="checkbox" id="like-checkbox">
                    <label class="like-animation" for="like-checkbox">
                        <span class="like">
                            <div class="like-active"></div>
                        </span>
                    </label>
                </div>
                <div class="characteristics">
                    <table>
                        <tr>
                            <td>Вес:</td>
                            <td><?php echo $productInfo["weight"]?></td>
                        </tr>
                        <tr>
                            <td>Тип:</td>
                            <td><?php echo $productInfo["typeName"]; ?></td>
                        </tr>
                        <tr>
                            <td>Цвет:</td>
                            <td><?php echo $productInfo["colorName"]; ?></td>
                        </tr>
                        <tr>
                            <td>Материал:</td>
                            <td><?php echo $productInfo["materialName"]; ?></td>
                        </tr>
                        <tr>
                            <td>Толщина пишущей части:</td>
                            <td><?php echo $productInfo["tipThickness"]; ?></td>
                        </tr>
                        <tr>
                            <td>Производитель:</td>
                            <td><?php echo $productInfo["manufacturerName"]; ?></td>
                        </tr>
                        <tr>
                            <td>Количество:</td>
                            <td><?php echo $productInfo["quantity"]; ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="price-wrapper">
                <form class="purchase-form">
                    <span class="price">Цена: <span class="price__value"><?php echo $productInfo["price"]; ?></span> $</span>
                    <div class="quantity-wrapper">
                        <span class="quantity">Количество: </span>
                        <input class="quantity__value entry" type="number" min="1" max="<?php echo $productInfo["quantity"]; ?>" value="1">
                    </div>
                    <button class="buy">Купить</button>
                </form>
            </div>
            <div class="description-wrapper">
                <span class="description">Описание:</span>
                <span class="content-description"><?php echo $productInfo["description"]; ?></span>
            </div>
        </div>
    </div>
</main>
<div class="purchase-modal purchase-modal_hidden">
    <div class="background"></div>
    <section class="form-container">
        <h2 class="caption">Оформление заказа</h2>
        <form class="purchase-form-modal" action="purchase.php">
            <div class="purchase-form-modal__inputs">
                <input class="purchase-form-modal__name" name="name" type="text" placeholder="Имя">
                <input class="purchase-form-modal__surname" name="surname" type="text" placeholder="Фамилия">
                <input class="purchase-form-modal__patronymic" name="patronymic" type="text" placeholder="Отчество">
                <input class="purchase-form-modal__text" name="city" type="text" placeholder="Город">
                <input class="purchase-form-modal__street" name="street" type="text" placeholder="Улица">
                <input class="purchase-form-modal__house" name="house" type="text" placeholder="Дом">
                <input class="purchase-form-modal__postal-code" name="postal-code" type="text" placeholder="Почтовый индекс">
                <input class="purchase-form-modal__phone" name="phone" type="text" placeholder="Телефон">
                <div class="bottom-row">
                    <label class="purchase-form-modal__quantity-container">
                        <span>Количество:</span>
                        <input class="purchase-form-modal__quantity" type="number" min="1" max="<?php echo $productInfo["quantity"]; ?>" value="1">
                    </label>
                    <span class="purchase-form-modal__price-container">
                        <span>Цена: </span>
                        <span class="purchase-form-modal__price-value"></span>
                        <span class="purchase-form-modal__currency-sign">$</span>
                    </span>
                    <button class="purchase-btn">Совершить заказ</button>
                </div>
            </div>
        </form>
    </section>
</div>
<script src="../../src/js/purchase-modal.js"></script>
<script src="../../src/js/priceToQuantityLinker.js"></script>
<?php
require_once(VIEWS . "shared" . DIRECTORY_SEPARATOR . "footerView.php");
