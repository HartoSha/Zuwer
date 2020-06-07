<?php
    require_once (VIEWS . "shared" . DIRECTORY_SEPARATOR . "headerView.php");    
?>

<body>
<main class="product-page">

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
                    <td><input class="entry-field" type="text" name="productName" value="<?php echo $productInfo['title']; ?>">
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
                    <td><input class="entry-field" type="text" name="productWeight" value="<?php echo $productInfo["weight"]; ?>">
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
                    <td><input class="entry-field" type="text" name="productType" value="<?php echo $productInfo["typeName"]; ?>">
                        <datalist id="product-type">
                        <?php foreach ($productTypes as $key => $value):?>
                            <option value="<?php echo $value["typeName"] ?>"></option>
                        <?php endforeach; ?>
                        </datalist>
                    </td>
                </tr>
                <tr>
                    <td><span>Цвет:</span></td>
                    <td><input class="entry-field" type="text" name="productColor" value="<?php echo $productInfo["colorName"]; ?>">
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
                    <td><input class="entry-field" type="text" name="productMaterial" value="<?php echo $productInfo["materialName"]; ?>">
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
                    <td><input class="entry-field" type="text" name="productTipThickness" value="<?php echo $productInfo["tipThickness"]; ?>">
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
                    <td><input class="entry-field" type="text" name="manufacturerName" value="<?php echo $productInfo["manufacturerName"]; ?>">
                        <datalist id="product-manufacturer">
                        <?php foreach ($productManufacturers as $key => $value):?>
                            <option value="<?php echo $value["manufacturerName"] ?>">
                        <?php endforeach; ?>
                        </datalist>
                    </td>
                   
                </tr>
                <tr>
                    <td><span>Количество:</span></td>
                    <td><input class="entry-field" type="text" name="productQuantity" value="<?php echo $productInfo["quantity"]; ?>"></td>
                </tr>
                <tr>
                    <td><span>Цена:</span></td>
                    <td><input class="entry-field" type="text" name="productPrice" value="<?php echo $productInfo["price"]; ?>"></td>
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
            <textarea class="description-content" name="textarea"><?php echo $productInfo["description"]; ?></textarea>
        </div>
        <div class="delete-save-wrapper">
            <div class="delete-form-and-save">
                <button class="delete" name="delete" formaction="/admin/deleteProduct/<?php print $productInfo["id_product"] ?>">Удалить</button>
                <button class="save" name="save">Сохранить</button>
            </div>
        </div>
        
    </form>
</div>

</main>
<?php
require_once(VIEWS . "shared" . DIRECTORY_SEPARATOR . "footerView.php");