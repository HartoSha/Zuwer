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
                    <?php if(!isset($productInfo["picture"])) :?>
                    <img class="camera-icon" src="/../src/assets/img/product-edit/camera.svg" alt="product-img">
                    <?php else: ?>
                        <?php 
                        $img = base64_encode($productInfo["picture"]);
                        echo "<img class=\"product-img\" src=\"data:image/jpeg; base64,$img\" alt=\"product image\" >";
                    ?>
                    <?php endif;?>
                    <span class="photo">Загрузите фото</span>
                </div>
            </label>
            
            <div class="characteristics">
                <table>
                <tr>
                    <td><span>Название:</span></td>
                    <td><input class="entry-field" type="text"  required name="productName" value="<?php if($productInfoStatus) echo $productInfo['title']; ?>">
                    </td>
                </tr>
                <tr>
                    <td><span>Вес:</span></td>
                    <td><input class="entry-field" type="text"  required name="productWeight" value="<?php if($productInfoStatus) echo $productInfo["weight"]; ?>">
                    </td>
                </tr>
                <tr>
                    <td><span>Тип:</span></td>
                    <td><select class="entry-field" required name="productType" value="<?php if($productInfoStatus)echo $productInfo["typeName"]; ?>">
                        <?php foreach ($productTypes as $key => $value):?>
                            <option value="<?php echo $value["typeName"]; ?>" <?php echo $productInfoStatus && $productInfo["typeName"] == $value["typeName"] ? "selected" : ""  ?>><?php echo $value["typeName"] ?></option>
                        <?php endforeach; ?>
                    </td>
                </tr>
                <tr>
                    <td><span>Цвет:</span></td>
                    <td><input list="product-color" class="entry-field" required type="text" name="productColor" value="<?php if($productInfoStatus) echo $productInfo["colorName"]; ?>">
                        <datalist id="product-color">
                            <?php foreach ($productColors as $key => $value):?>
                                <option value="<?php echo $value["colorName"] ?>"><?php echo $value["colorName"] ?></option>
                            <?php endforeach; ?>
                        </datalist>
                    </td>
                </tr>
                <tr>
                    <td><span>Материал:</span></td>
                    <td><input list="product-material" required class="entry-field" type="text" name="productMaterial" value="<?php if($productInfoStatus) echo $productInfo["materialName"]; ?>">
                        <datalist id="product-material">
                        <?php foreach ($productMaterials as $key => $value):?>
                                <option value="<?php echo $value["materialName"] ?>"><?php if($productInfoStatus) echo $value["materialName"] ?></option>
                            <?php endforeach; ?>
                        </datalist>
                    </td>
                </tr>
                <tr>
                    <td><span>Толщина пишущей части:</span></td>
                    <td><input list="product-tip-thickness" required class="entry-field" type="text" name="productTipThickness" value="<?php if($productInfoStatus) echo $productInfo["tipThickness"]; ?>">
                        <datalist id="product-tip-thickness">
                            <?php foreach ($tipThiknesses as $key => $value):?>
                                <option value="<?php echo $value["tipThickness"] ?>"><?php echo $value["tipThickness"] ?></option>
                            <?php endforeach; ?>
                        </datalist>
                    </td>
                </tr>
                <tr>
                    <td><span>Производитель:</span></td>
                    <td><select class="entry-field" required name="manufacturerName" value="<?php echo $productInfo["manufacturerName"]; ?>">
                        <?php foreach ($productManufacturers as $key => $value):?>
                            <option value="<?php echo $value["manufacturerName"]?>" <?php echo $productInfoStatus && $productInfo["manufacturerName"] == $value["manufacturerName"] ? "selected" : ""  ?>><?php echo $value["manufacturerName"] ?></option>
                        <?php endforeach; ?>
                    </td>
                   
                </tr>
                <tr>
                    <td><span>Количество:</span></td>
                    <td><input class="entry-field" required type="text" name="productQuantity" value="<?php if($productInfoStatus) echo $productInfo["quantity"]; ?>"></td>
                </tr>
                <tr>
                    <td><span>Цена:</span></td>
                    <td><input class="entry-field" required type="text" name="productPrice" value="<?php if($productInfoStatus) echo $productInfo["price"]; ?>"></td>
                </tr>
                </table>
                <label>
                    <div class="new">
                        <span>Является ли товар новинкой:</span>
                        <input class="new-checkbox" type="checkbox" size="40" name="checkbox" <?php if($productInfoStatus) echo $productInfo["status"] ? "checked" : "" ?>>
                    </div>
                </label>
            </div>
            
        </div>
        <div class="description-wrapper">
            <span class="description-edit">Редактировать описание:</span>
            <textarea class="description-content" required name="textarea"><?php if($productInfoStatus) echo $productInfo["description"]; ?></textarea>
        </div>
        <div class="delete-save-wrapper">
            <div class="delete-form-and-save">
                <?php if($productInfoStatus):?>
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