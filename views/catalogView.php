<?php
    require_once (VIEWS . "shared" . DIRECTORY_SEPARATOR . "headerView.php");
?>

    <main class="catalog-page">
        <div class="content-grid">
            <aside class="catalog-page__filter">
            <button class="plus-orders">+ Добавить товар</button>
                <form action="../../catalog" method="POST">
                    <section class="filter-criteria filter-criteria_accordion filter-criteria_range">
                        <label class="filter-criteria__accordion-click-wrapper"><!-- Визуальное отображение выбранных фильтров(выбранные фильтры будут активны,filter-criteria__accordion-checkbox активирован). -->
                            <input class="filter-criteria__accordion-checkbox" type="checkbox" <?php if(isset($_COOKIE['priceMin']) || isset($_COOKIE['priceMax']))print('checked="checked"')?>> <!-- accordion на css, чтобы не загружать js -->
                            <h3 class="filter-criteria__caption" <?php isset($_COOKIE['priceMin']) || isset($_COOKIE['priceMax']) ? print('style="color:#cdb67c"'):""?>>Цена, $<span class="filter-criteria__accordion-icon"></span></h3>
                            <div class="filter-criteria__content">
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption">От:</span>
                                    <input name="filterPriceMin" type="number"
                                      value="<?php  print( ceil( isset($_COOKIE['priceMin']) ? $_COOKIE['priceMin'] : $PriceWeightProducts['priceMin']))?>">
                                    <span class="filter-criteria__option-underline"></span> <!-- было решено добавить пустой span после input для создания золотистого подчеркивания, т.к. input::after не поддерживается -->
                                </label>
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption">До:</span>
                                    <input name="filterPriceMax" type="number"
                                      value="<?php  print( ceil( isset($_COOKIE['priceMax']) ? $_COOKIE['priceMax'] : $PriceWeightProducts['priceMax']))?>">
                                    <span class="filter-criteria__option-underline"></span>
                                </label>
                            </div>
                        </label>
                    </section>
                    <section class="filter-criteria filter-criteria_accordion filter-criteria_range">
                        <label class="filter-criteria__accordion-click-wrapper"><!-- Визуальное отображение выбранных фильтров -->
                            <input class="filter-criteria__accordion-checkbox" type="checkbox" <?php if(isset($_COOKIE['weightMin']) || isset($_COOKIE['weightMax']))print('checked="checked"')?>> <!-- accordion на css, чтобы не загружать js -->
                            <h3 class="filter-criteria__caption" <?php isset($_COOKIE['priceMax']) || isset($_COOKIE['weightMin']) ? print('style="color:#cdb67c"'):""?>>Вес, г<span class="filter-criteria__accordion-icon"></span></h3>
                            <div class="filter-criteria__content">
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption">От:</span>
                                    <input name="filterWeightMin" type="number" min="<?php print($PriceWeightProducts['weightMin'])?>" max="<?php print($PriceWeightProducts['weightMax'])?>" 
                                    value="<?php print( isset($_COOKIE['weightMin']) ? $_COOKIE['weightMin'] : $PriceWeightProducts['weightMin'])?>">
                                    <span class="filter-criteria__option-underline"></span>
                                </label>
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption">До:</span>
                                    <input name="filterWeightMax" type="number" min="<?php print($PriceWeightProducts['weightMin'])?>" max="<?php print($PriceWeightProducts['weightMax'])?>" 
                                    value="<?php print( isset($_COOKIE['weightMax']) ? $_COOKIE['weightMax'] : $PriceWeightProducts['weightMax'])?>">
                                    <span class="filter-criteria__option-underline"></span>
                                </label>
                            </div>
                        </label>
                    </section>
                    <section class="filter-criteria filter-criteria_accordion">
                        <label class="filter-criteria__accordion-click-wrapper"><!-- Визуальное отображение выбранных фильтров -->
                            <input class="filter-criteria__accordion-checkbox" type="checkbox" <?php if(isset($_COOKIE['arrManufacturer']))print('checked="checked"')?>> <!-- accordion на css, чтобы не загружать js -->
                            <h3 class="filter-criteria__caption" <?php isset($_COOKIE['arrManufacturer']) ? print('style="color:#cdb67c"'):""?>>Производители <span class="filter-criteria__accordion-icon"></span></h3>
                            <div class="filter-criteria__content">
                            <?php foreach ($ProductManufacturers as $ProductManufacturer): ?>
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption"><?php print($ProductManufacturer['manufacturerName'])?></span>
                                    <input type="checkbox" name="filterManufacturer[]" value="<?php print($ProductManufacturer['id_manufacturer'])?>"
                                    <?php 
                                    #выделение выбранных товаров
                                    if (isset($_COOKIE['arrManufacturer']))for($i=0;$i<count( unserialize($_COOKIE['arrManufacturer']));$i++){
                                        if($ProductManufacturer['id_manufacturer']==unserialize($_COOKIE['arrManufacturer'])[$i])print('checked="checked"');
                                    }
                                    ?>>
                                </label>
                            <?php endforeach; ?>
                            </div>
                        </label>
                    </section>
                    <section class="filter-criteria filter-criteria_accordion">
                        <label class="filter-criteria__accordion-click-wrapper"><!-- Визуальное отображение выбранных фильтров -->
                            <input class="filter-criteria__accordion-checkbox" type="checkbox" <?php if(isset($_COOKIE['arrMaterial']))print('checked="checked"')?>> <!-- accordion на css, чтобы не загружать js -->
                            <h3  class="filter-criteria__caption" <?php isset($_COOKIE['arrMaterial']) ? print('style="color:#cdb67c"'):""?>>Материал <span class="filter-criteria__accordion-icon"></span></h3>
                            <div  class="filter-criteria__content">
                            <?php foreach ($ProductMaterials as $ProductMaterial): ?> 
                                <label class="filter-criteria__option" >
                                    <span class="filter-criteria__option-caption"><?php print($ProductMaterial['materialName'])?></span>
                                    <input type="checkbox" name="filterMaterial[]" value="<?php print($ProductMaterial['id_material'])?>"
                                    <?php 
                                    #выделение выбранных товаров
                                    if (isset($_COOKIE['arrMaterial']))for($i=0;$i<count( unserialize($_COOKIE['arrMaterial']));$i++){
                                        if($ProductMaterial['id_material']==unserialize($_COOKIE['arrMaterial'])[$i])print('checked="checked"');
                                    }
                                    ?>>
                                </label>
                            <?php endforeach; ?>
                            </div>
                        </label>
                    </section>
                    <section class="filter-criteria filter-criteria_accordion">
                        <label class="filter-criteria__accordion-click-wrapper"><!-- Визуальное отображение выбранных фильтров -->
                            <input class="filter-criteria__accordion-checkbox" type="checkbox" <?php if(isset($_COOKIE['arrInkColor']))print('checked="checked"')?>> <!-- accordion на css, чтобы не загружать js -->
                            <h3 class="filter-criteria__caption" <?php isset($_COOKIE['arrInkColor']) ? print('style="color:#cdb67c"'):""?>>Цвет<span class="filter-criteria__accordion-icon"></span></h3>
                            <div class="filter-criteria__content">
                            <?php foreach ($ProductInkColors as $ProductInkColor): ?> 
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption"><?php print($ProductInkColor['colorName'])?></span>
                                    <input type="checkbox" name="filterColor[]" value="<?php print($ProductInkColor['id_inkColor'])?>"
                                    <?php 
                                    #выделение выбранных товаров
                                    if (isset($_COOKIE['arrInkColor']))for($i=0;$i<count( unserialize($_COOKIE['arrInkColor']));$i++){
                                        if($ProductInkColor['id_inkColor']==unserialize($_COOKIE['arrInkColor'])[$i])print('checked="checked"');
                                    }
                                    ?>
                                    >
                                </label>
                            <?php endforeach; ?>
                            </div>
                        </label>
                    </section>
                    <section class="filter-criteria filter-criteria_accordion">
                        <label class="filter-criteria__accordion-click-wrapper"><!-- Визуальное отображение выбранных фильтров -->
                            <input class="filter-criteria__accordion-checkbox" type="checkbox" <?php if(isset($_COOKIE['arrType']))print('checked="checked"')?>> <!-- accordion на css, чтобы не загружать js -->
                            <h3 class="filter-criteria__caption" <?php isset($_COOKIE['arrType']) ? print('style="color:#cdb67c"'):""?>>Тип<span class="filter-criteria__accordion-icon"></span></h3>
                            <div class="filter-criteria__content">
                            <?php foreach ($ProductTypes as $ProductType): ?> 
                                <label class="filter-criteria__option">
                                    <span  class="filter-criteria__option-caption"><?php print($ProductType['typeName'])?> </span>
                                    <input  type="checkbox" name="filterType[]" value="<?php print($ProductType['id_type']) ?>"
                                    <?php 
                                    #выделение выбранных товаров
                                    if (isset($_COOKIE['arrType']))for($i=0;$i<count( unserialize($_COOKIE['arrType']));$i++){
                                        if($ProductType['id_type']==unserialize($_COOKIE['arrType'])[$i])print('checked="checked"');
                                    }
                                    ?> 
                                    >
                                </label>
                            <?php endforeach; ?>
                            </div>
                        </label>
                    </section>
                    <section class="filter-criteria filter-criteria_accordion">
                        <label class="filter-criteria__accordion-click-wrapper"><!-- Визуальное отображение выбранных фильтров -->
                            <input class="filter-criteria__accordion-checkbox" type="checkbox" <?php if(isset($_COOKIE['arrTipThickness']))print('checked="checked"')?>> <!-- accordion на css, чтобы не загружать js -->
                            <h3 class="filter-criteria__caption" <?php isset($_COOKIE['arrTipThickness']) ? print('style="color:#cdb67c"'):""?>>Толщина пиш. части, мм<span class="filter-criteria__accordion-icon"></span></h3>
                            <div class="filter-criteria__content">
                            <?php foreach ($ProductsTipThickness as $ProductTipThickness): ?> 
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption"><?php print($ProductTipThickness['tipThickness'])?></span>
                                    <input type="checkbox" name="filterTipThickness[]" value="<?php print($ProductTipThickness['tipThickness'])?>"
                                    <?php 
                                    #выделение выбранных товаров
                                    if (isset($_COOKIE['arrTipThickness']))for($i=0;$i<count( unserialize($_COOKIE['arrTipThickness']));$i++){
                                        if($ProductTipThickness['tipThickness']==unserialize($_COOKIE['arrTipThickness'])[$i])print('checked="checked"');
                                    }
                                    ?>>
                                </label>
                            <?php endforeach; ?>
                            </div>
                        </label>
                    </section>
                    <section class="filter-criteria filter-criteria_accordion">
                        <label class="filter-criteria__accordion-click-wrapper"><!-- Визуальное отображение выбранных фильтров -->
                            <input class="filter-criteria__accordion-checkbox" type="checkbox" <?php if(isset($_COOKIE['Status']))print('checked="checked"')?>> <!-- accordion на css, чтобы не загружать js -->
                            <h3 class="filter-criteria__caption" <?php isset($_COOKIE['Status']) ? print('style="color:#cdb67c"'):""?>>Показывать только новинки<span class="filter-criteria__accordion-icon"></span></h3>
                            <div class="filter-criteria__content">
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption" <?php if(isset($_COOKIE['Status'])==1)print('style="color:#cdb67c"') ?>>Да</span>
                                    <input type="checkbox" name="filterNewProduct" value="1"<?php if(isset($_COOKIE['Status'])==1)print('checked="checked"') ?>>
                                </label>
                            </div>
                        </label>
                    </section>

                    <section class="filter-criteria filter-criteria_accordion">
                        <label class="filter-criteria__accordion-click-wrapper" style="font-size: 13px;"><!-- Визуальное отображение выбранных фильтров -->
                            <input class="filter-criteria__accordion-checkbox" type="checkbox"> <!-- accordion на css, чтобы не загружать js -->
                            <h3 class="filter-criteria__caption" <?php isset($_COOKIE['sortOrder']) ? print('style="color:#cdb67c"'):""?>>Порядок сортировки<span class="filter-criteria__accordion-icon"></span></h3>
                            <div class="filter-criteria__content">
                            <p class="filter-criteria__option-section">Цена</p>
                                <label class="filter-criteria__option">
                                    <span  class="filter-criteria__option-caption"> </span>
                                        <input  type="radio" name="sortOrder" value="descendingPrice" <?php if(isset($_COOKIE['sortOrder']) && $_COOKIE['sortOrder']=="descendingPrice")print('checked="checked"')?>><p>По убыванию</p>
                                </label>
                                <label class="filter-criteria__option">
                                    <span  class="filter-criteria__option-caption"> </span>
                                        <input  type="radio" name="sortOrder" value="ascendingPrice" <?php if(isset($_COOKIE['sortOrder']) && $_COOKIE['sortOrder']=="ascendingPrice")print('checked="checked"')?>><p>По возрастанию</p>
                                </label>
                            
                            <p class="filter-criteria__option-section">Вес</p>
                                <label class="filter-criteria__option">
                                    <span  class="filter-criteria__option-caption"> </span>
                                        <input type="radio" name="sortOrder" value="descendingWeight" <?php if(isset($_COOKIE['sortOrder']) && $_COOKIE['sortOrder']=="descendingWeight")print('checked="checked"')?>><p>По убыванию</p>
                                </label>
                                <label class="filter-criteria__option">
                                    <span  class="filter-criteria__option-caption"> </span>
                                        <input  type="radio" name="sortOrder" value="ascendingWeight" <?php if(isset($_COOKIE['sortOrder']) && $_COOKIE['sortOrder']=="ascendingWeight")print('checked="checked"')?>><p>По возрастанию</p>
                                </label>
                            </div>
                        </label>
                    </section>
                    
                    <button class="catalog-page__btn-submit" name="button">Применить</button>
                    <button class="catalog-page__btn-reset" name="reset"  <?php if(!isset($_COOKIE['priceMin']))print('style="display: none;"');?>>Cбросить</button>

                </form>
            </aside>
            <section class="catalog-page__items-container">
                <?php if($products != NULL && isset($products) && !empty($products)):?>
                <?php foreach ($products as $product):?> 
                <figure class="catalog-page__item item" <?php if(!is_array($product))print ('style="display: none;"');?>>
                    <a class="item__href" href="/catalog/product/<?php print $product["id_product"] ?>" >
                        <div class="item__upper-row">
                            <span class="item__type">
                                <?php echo $product["typeName"] ?>
                            </span>
                            <?php if($product["status"] == true) echo "<span class=\"item__new-icon\"></span>"?>
                        </div>
                        <div class="item__image-wrapper">
                            <?php 
                                $img = base64_encode($product["picture"]);
                                echo "<img class=\"item__image\" src=\"data:image/jpeg; base64,$img\" alt=\"item image\" >";
                            ?>
                        </div>
                        <div class="item__bottom-row">
                            <span class="item__name">
                                <?php echo $product["title"];?>
                            </span>
                            <span class="item__line"></span>
                            <span class="item__price">
                                <span class="item__price-value">
                                    <?php echo $product["price"] ?>
                                </span>
                                <span class="item__price-currency-sign">$</span>
                            </span>
                        </div>
                    </a>
                </figure>
                <?php endforeach;?>
                <?php endif; ?>
                
                <!-- pagination расположен в items-container для удобного прикрепления его к последней строке item'ов -->

                <nav class="catalog-page__pagination pagination" <?php if(!is_array($product) || $QuantityPage==1)print('style="display: none;"'); ?>> 
                    <a class="pagination__page pagination__page_back" <?php if($QuantityPage==1 || $page==1)print('style="display: none;"');?>
                    href="../../catalog/page/<?php print($page-1)?>">
                        <span class="pagination__back-icon"><</span>
                        <span class="pagination__back-text">Назад</span>
                    </a>
                    
                    <?php 
                        for($i=1;$i<=$QuantityPage;$i++){
                            ?><a style="margin-left: 5px" class="pagination__page <?php  if($i==$page)print("pagination__page_current")  ?>" href="../../catalog/page/<?php print($i) ?>"><?php print($i) ?></a><?php
                        }
                    ?>

                    <a class="pagination__page pagination__page_next" <?php if($QuantityPage==1 || $page==$QuantityPage)print('style="display: none;"'); ?>
                    href="../../catalog/page/<?php print($page+1)?>">
                        <span class="pagination__next-text">Вперед</span>
                        <span class="pagination__next-icon">></span>
                    </a>
                </nav>
            </section>
        </div>
    </main>

<?php
require_once(VIEWS . "shared" . DIRECTORY_SEPARATOR . "footerView.php");