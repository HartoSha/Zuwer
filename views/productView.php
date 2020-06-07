<?php
require_once(VIEWS . "shared" . DIRECTORY_SEPARATOR . "headerView.php");
// <?php echo $ordersInfo[$i]["id_product"]
?>

<main class="product-page">
    <div class="container">
        <div class="main-container">
            <div class="product-name">
                <span><?php echo $productInfo["title"]; ?></span>
            </div>
            <div class="product">
                <div class="product-img-container">
                    <label class="product-img-wrapper <?php echo !$userIsLoggedIn ? 'toggle-modal-log-reg' : '' ?>" for="like-checkbox">
                        <?php
                        $img = base64_encode($productInfo["picture"]);
                        echo "<img class=\"product-img\" src=\"data:image/jpeg; base64,$img\" alt=\"product image\" >";
                        ?>
                    </label>
                    <?php if ($userIsLoggedIn) : ?>
                        <input type="checkbox" id="like-checkbox" <?php echo $isFavorite ? "checked" : "" ?> >
                    <?php endif; ?>
                    <label class="like-animation" for="like-checkbox">
                        <span class="like <?php echo !$userIsLoggedIn ? 'toggle-modal-log-reg' : '' ?>">
                            <?php if ($userIsLoggedIn) : ?>
                                <div class="like-active"></div>
                            <?php endif; ?>
                        </span>
                    </label>
                </div>
                <div class="characteristics">
                    <table>
                        <tr>
                            <td>Вес:</td>
                            <td><?php echo $productInfo["weight"] ?></td>
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
                            <td>Количество на складе:</td>
                            <td><?php echo $productInfo["quantity"]; ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="price-wrapper">
                <form class="purchase-form" method="POST">
                    <?php if(!$isAdmin):?>
                        <span class="price">Цена: <output class="price__value"><?php echo $productInfo["price"]; ?></output> $</span>
                        <div class="quantity-wrapper">
                            <span class="quantity">Количество: </span>
                            <input class="quantity__value entry" type="number" min="1" max="<?php echo $productInfo["quantity"]; ?>" value="1">
                        </div>
                        <button class="buy <?php echo userModel::userIsLoggedIn() ? "toggle-modal-buy" : "toggle-modal-log-reg"; ?>">Купить</button>
                    <?php else :?>
                        <button class="change" formaction="/admin/editingPage/<?php echo $productInfo["id_product"] ?>">Изменить</button>
                    <?php endif;?>
                </form>
            </div>
            <div class="description-wrapper">
                <span class="description">Описание:</span>
                <span class="content-description"><?php echo $productInfo["description"]; ?></span>
            </div>
        </div>
    </div>
</main>
<div class="purchase-modal <?php echo isset($_SESSION["order-errors"]) && count($_SESSION["order-errors"]) ? "": "purchase-modal_hidden" ?>">
    <div class="background"></div>
    <section class="purchase-form-container">
        <h2 class="caption">Оформление заказа</h2>
        <form class="purchase-form-modal" method="POST" action=<?php echo $userIsLoggedIn ? "/catalog/addOrder/" : "#"; ?>>
            <div class="purchase-form-modal__inputs">
                
                <?php if (isset($_SESSION["order-errors"]) && count($_SESSION["order-errors"])) : ?>
                    <ul class="modal-errors">
                        <?php foreach ($_SESSION["order-errors"] as $error) echo '<li class="modal-error-text">' . array_shift($_SESSION["order-errors"]) . '</li>'; ?>
                    </ul>
                <?php endif; ?>
                
                <input class="purchase-form-modal__name" name="name" type="text" placeholder="Имя" required value=<?php echo $userName; ?>>
                <input class="purchase-form-modal__surname" name="surname" type="text" placeholder="Фамилия" required value=<?php echo $userSurename ?>>
                <input class="purchase-form-modal__patronymic" name="patronymic" type="text" placeholder="Отчество" required value=<?php echo $userPatronymic ?>>
                <input class="purchase-form-modal__text" name="city" type="text" required placeholder="Город">
                <input class="purchase-form-modal__street" name="street" type="text" required placeholder="Улица">
                <input class="purchase-form-modal__house" name="house" type="text" required placeholder="Дом">
                <input class="purchase-form-modal__postal-code" name="postal-code" type="text" required placeholder="Почтовый индекс">
                <input class="purchase-form-modal__phone" name="phone" type="text" placeholder="Телефон" required value=<?php echo $userPhone ?>>

                <div class="bottom-row">
                    <label class="purchase-form-modal__quantity-container">
                        <span>Количество:</span>
                        <input class="purchase-form-modal__quantity" type="number" min="1" max="<?php echo $productInfo["quantity"]; ?>" value="1" name="order-product-quantity">
                    </label>
                    <span class="purchase-form-modal__price-container">
                        <span>Цена: </span>
                        <output class="purchase-form-modal__price-value"></output>
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
<script src="../../src/js/switch-favorite-product.js"></script>
<?php
require_once(VIEWS . "shared" . DIRECTORY_SEPARATOR . "footerView.php");
