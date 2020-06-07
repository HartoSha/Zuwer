<?php
    require_once (VIEWS . "shared" . DIRECTORY_SEPARATOR . "headerView.php");    
?>

<body>
<main class="product-page">

<?php if (isset($_SESSION["addProduct-errors"]) && count($_SESSION["addProduct-errors"])) : ?>
        <ul class="modal-errors">
            <?php foreach ($_SESSION["addProduct-errors"] as $error) echo '<li class="modal-error-text">' . array_shift($_SESSION["addProduct-errors"]) . '</li>'; ?>
        </ul>
<?php endif; ?>

<div class="container">
    <form class="main-container" enctype="multipart/form-data" action="/admin/addProduct" method="POST">
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
                    <td><input class="entry-field" type="text" name="productName">
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
                    <td><input class="entry-field" type="text" name="productWeight">
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
                    <td><input class="entry-field" type="text" name="productType">
                        <datalist id="product-type">
                            <option value=""></option>
                            <option value=""></option>
                            <option value=""></option>
                            <option value=""></option>
                        </datalist>
                    </td>
                </tr>
                <tr>
                    <td><span>Цвет:</span></td>
                    <td><input class="entry-field" type="text" name="productColor">
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
                    <td><input class="entry-field" type="text" name="productMaterial">
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
                    <td><input class="entry-field" type="text" name="productTipThickness">
                        <datalist id="product-tip-thickness">
                            <option value=""></option>
                            <option value=""></option>
                            <option value=""></option>
                            <option value=""></option>
                        </datalist>
                    </td>
                </tr>
                <tr>
                    <td><span>Производитель:</span></td>
                    <td><input class="entry-field" type="text" name="manufacturerName">
                        <datalist id="product-manufacturer">
                            <option value=""></option>
                            <option value=""></option>
                            <option value=""></option>
                            <option value=""></option>
                        </datalist>
                    </td>
                   
                </tr>
                <tr>
                    <td><span>Количество:</span></td>
                    <td><input class="entry-field" type="text" name="productQuantity"></td>
                </tr>
                <tr>
                    <td><span>Цена:</span></td>
                    <td><input class="entry-field" type="text" name="productPrice"></td>
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
            <textarea class="description-content" name="textarea"></textarea>
        </div>
        <div class="delete-save-wrapper">
            <div class="delete-form-and-save">
                <button class="save" name="save">Сохранить</button>
            </div>
        </div>
        
    </form>
</div>

</main>
<?php
require_once(VIEWS . "shared" . DIRECTORY_SEPARATOR . "footerView.php");