<?php
    require_once (VIEWS . "shared" . DIRECTORY_SEPARATOR . "headerView.php");    
?>

<main class="product-page">

<?php if (isset($_SESSION["addProduct-errors"]) && count($_SESSION["addProduct-errors"])) : ?>
        <ul class="modal-errors">
            <?php foreach ($_SESSION["addProduct-errors"] as $error) echo '<li class="modal-error-text">' . array_shift($_SESSION["addProduct-errors"]) . '</li>'; ?>
        </ul>
<?php endif; ?>

<div class="container">
    <form class="main-container" enctype="multipart/form-data" action="/admin/saveProductChanges/<?php print $productInfo["id_product"] ?>" method="POST">
        <div class="product">
            <label class="product-img-container">
                <div class="product-img-wrapper">
                    <input type="file" id="file-input" name="photo" style="display: none;">
                    <img class="camera-icon" src="/../src/assets/img/product-edit/camera.svg" alt="product-img">
                    <span class="photo">Загрузите фото</span>
                </div>
            </label>
            
            <div class="characteristics">
                <table>
                <tr>
                    <td><span>Название:</span></td>
                    <td><input class="entry-field" require type="text" name="productName" value="<?php if(isset($productInfo))echo $productInfo['title']; ?>">
                        <datalist id="product-name">
                            <option value=""></option>
                            <option value=""></option>
                            <option value=""></option>
                            <option value=""></option>
                        </datalist>
                    </td>
                </tr>
                <tr>
                    <td><span>Вес:</span></td>
                    <td><input class="entry-field" require type="text" name="productWeight" value="<?php if(isset($productInfo))echo $productInfo["weight"]; ?>">
                    <datalist id="product-weight">
                        <option value=""></option>
                        <option value=""></option>
                        <option value=""></option>
                        <option value=""></option>
                    </datalist>
                    </td>
                </tr>
                <tr>
                    <td><span>Тип:</span></td>
                    <td><input class="entry-field" require type="text" name="productType" value="<?php if(isset($productInfo))echo $productInfo["typeName"]; ?>">
                        <datalist id="product-type">
                        <?php foreach ($productTypes as $key => $value):?>
                            <option value="<?php echo $value["typeName"] ?>"></option>
                        <?php endforeach; ?>
                        </datalist>
                    </td>
                </tr>
                <tr>
                    <td><span>Цвет:</span></td>
                    <td><input class="entry-field" require type="text" name="productColor" value="<?php if(isset($productInfo))echo $productInfo["colorName"]; ?>">
                        <datalist id="product-color">
                            <option value=""></option>
                            <option value=""></option>
                            <option value=""></option>
                            <option value=""></option>
                        </datalist>
                    </td>
                </tr>
                <tr>
                    <td><span>Материал:</span></td>
                    <td><input class="entry-field" require type="text" name="productMaterial" value="<?php if(isset($productInfo))echo $productInfo["materialName"]; ?>">
                        <datalist id="product-material">
                            <option value=""></option>
                            <option value=""></option>
                            <option value=""></option>
                            <option value=""></option>
                        </datalist>
                    </td>
                </tr>
                <tr>
                    <td><span>Толщина пишущей части:</span></td>
                    <td><input class="entry-field" require type="text" name="productTipThickness" value="<?php if(isset($productInfo))echo $productInfo["tipThickness"]; ?>">
                        <datalist id="product-tip-thickness">
                            <option value="23"></option>
                            <option value="32"></option>
                            <option value="12"></option>
                            <option value="21"></option>
                        </datalist>
                    </td>
                </tr>
                <tr>
                    <td><span>Производитель:</span></td>
                    <td><input class="entry-field" require type="text" name="manufacturerName" value="<?php if(isset($productInfo))echo $productInfo["manufacturerName"]; ?>">
                        <datalist id="product-manufacturer">
                        <?php foreach ($productManufacturers as $key => $value):?>
                            <option value="<?php echo $value["manufacturerName"] ?>">
                        <?php endforeach; ?>
                        </datalist>
                    </td>
                   
                </tr>
                <tr>
                    <td><span>Количество:</span></td>
                    <td><input class="entry-field" require type="text" name="productQuantity" value="<?php if(isset($productInfo))echo $productInfo["quantity"]; ?>"></td>
                </tr>
                <tr>
                    <td><span>Цена:</span></td>
                    <td><input class="entry-field" require type="text" name="productPrice" value="<?php if(isset($productInfo))echo $productInfo["price"]; ?>"></td>
                </tr>
                </table>
                <label>
                    <div class="new">
                        <span>Является ли товар новинкой:</span>
                        <input class="new-checkbox" type="checkbox" size="40" name="checkbox" value="yes">
                    </div>
                </label>
            </div>
            
        </div>
        <div class="description-wrapper">
            <span class="description-edit">Редактировать описание:</span>
            <textarea class="description-content" require name="textarea"><?php if(isset($productInfo))echo $productInfo["description"]; ?></textarea>
        </div>
        <div class="delete-save-wrapper">
            <div class="delete-form-and-save">
                <?php if(isset($productInfo)):?>
                <button class="delete" name="delete" formaction="/admin/deleteProduct/<?php print $productInfo["id_product"] ?>">Удалить</button>
                <button class="save" name="save">Сохранить</button>
                <?php else: ?>
                <button class="save" name="save" formaction="/admin/addProduct">Сохранить</button>
                <?php endif;?>
            </div>
        </div>
        
    </form>
</div>

</main>
<?php
require_once(VIEWS . "shared" . DIRECTORY_SEPARATOR . "footerView.php");