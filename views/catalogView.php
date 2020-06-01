<?php
    require_once (VIEWS . "shared" . DIRECTORY_SEPARATOR . "headerView.php");
    // $QuantityPage=1;
    
?>

    <main class="catalog-page">
        <div class="content-grid">
            <aside class="catalog-page__filter">
                <form action="../../catalog" method="POST">
                    <section class="filter-criteria filter-criteria_accordion filter-criteria_range">
                        <label class="filter-criteria__accordion-click-wrapper">
                            <input class="filter-criteria__accordion-checkbox" type="checkbox"> <!-- accordion на css, чтобы не загружать js -->
                            <h3 class="filter-criteria__caption">Цена, $<span class="filter-criteria__accordion-icon"></span></h3>
                            <div class="filter-criteria__content">
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption">От:</span>
                                    <input name="filterPriceMin" type="number" min="<?php print(round($PriceWeightProducts['priceMin']))?>" max="<?php print($PriceWeightProducts['priceMax'])+1?>" placeholder="<?php print($PriceWeightProducts['priceMin'])?>">
                                    <span class="filter-criteria__option-underline"></span> <!-- было решено добавить пустой span после input для создания золотистого подчеркивания, т.к. input::after не поддерживается -->
                                </label>
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption">До:</span>
                                    <input name="filterPriceMax" type="number" min="<?php print(round($PriceWeightProducts['priceMin']))?>" max="<?php print($PriceWeightProducts['priceMax'])?>" placeholder="<?php print($PriceWeightProducts['priceMax'])?>">
                                    <span class="filter-criteria__option-underline"></span>
                                </label>
                            </div>
                        </label>
                    </section>
                    <section class="filter-criteria filter-criteria_accordion filter-criteria_range">
                        <label class="filter-criteria__accordion-click-wrapper">
                            <input class="filter-criteria__accordion-checkbox" type="checkbox"> <!-- accordion на css, чтобы не загружать js -->
                            <h3 class="filter-criteria__caption">Вес, г<span class="filter-criteria__accordion-icon"></span></h3>
                            <div class="filter-criteria__content">
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption">От:</span>
                                    <input name="filterWeightMin" type="number" min="<?php print($PriceWeightProducts['weightMin'])?>" max="<?php print($PriceWeightProducts['weightMax'])?>" placeholder="<?php print($PriceWeightProducts['weightMin'])?>">
                                    <span class="filter-criteria__option-underline"></span>
                                </label>
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption">До:</span>
                                    <input name="filterWeightMax" type="number" min="<?php print($PriceWeightProducts['weightMin'])?>" max="<?php print($PriceWeightProducts['weightMax'])?>" placeholder="<?php print($PriceWeightProducts['weightMax'])?>">
                                    <span class="filter-criteria__option-underline"></span>
                                </label>
                            </div>
                        </label>
                    </section>
                    <section class="filter-criteria filter-criteria_accordion">
                        <label class="filter-criteria__accordion-click-wrapper">
                            <input class="filter-criteria__accordion-checkbox" type="checkbox"> <!-- accordion на css, чтобы не загружать js -->
                            <h3 class="filter-criteria__caption">Производители <span class="filter-criteria__accordion-icon"></span></h3>
                            <div class="filter-criteria__content">
                            <?php foreach ($ProductManufacturers as $ProductManufacturer): ?>
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption"><?php print($ProductManufacturer['manufacturerName'])?></span>
                                    <input type="checkbox" name="filterManufacturer[]" value="<?php print($ProductManufacturer['id_manufacturer'])?>">
                                </label>
                            <?php endforeach; ?>
                            </div>
                        </label>
                    </section>
                    <section class="filter-criteria filter-criteria_accordion">
                        <label class="filter-criteria__accordion-click-wrapper">
                            <input class="filter-criteria__accordion-checkbox" type="checkbox"> <!-- accordion на css, чтобы не загружать js -->
                            <h3 class="filter-criteria__caption">Материал <span class="filter-criteria__accordion-icon"></span></h3>
                            <div class="filter-criteria__content">
                            <?php foreach ($ProductMaterials as $ProductMaterial): ?> 
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption"><?php print($ProductMaterial['materialName'])?></span>
                                    <input type="checkbox" name="filterMaterial[]" value="<?php print($ProductMaterial['id_material'])?>">
                                </label>
                            <?php endforeach; ?>
                            </div>
                        </label>
                    </section>
                    <section class="filter-criteria filter-criteria_accordion">
                        <label class="filter-criteria__accordion-click-wrapper">
                            <input class="filter-criteria__accordion-checkbox" type="checkbox"> <!-- accordion на css, чтобы не загружать js -->
                            <h3 class="filter-criteria__caption">Цвет<span class="filter-criteria__accordion-icon"></span></h3>
                            <div class="filter-criteria__content">
                            <?php foreach ($ProductInkColors as $ProductInkColor): ?> 
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption"><?php print($ProductInkColor['colorName'])?></span>
                                    <input type="checkbox" name="filterColor[]" value="<?php print($ProductInkColor['id_inkColor'])?>">
                                </label>
                            <?php endforeach; ?>
                            </div>
                        </label>
                    </section>
                    <section class="filter-criteria filter-criteria_accordion">
                        <label class="filter-criteria__accordion-click-wrapper">
                            <input class="filter-criteria__accordion-checkbox" type="checkbox"> <!-- accordion на css, чтобы не загружать js -->
                            <h3 class="filter-criteria__caption">Тип<span class="filter-criteria__accordion-icon"></span></h3>
                            <div class="filter-criteria__content">
                            <?php foreach ($ProductTypes as $ProductType): ?> 
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption"><?php print($ProductType['typeName'])?></span>
                                    <input type="checkbox" name="filterType[]" value="<?php print($ProductType['id_type'])?>">
                                </label>
                            <?php endforeach; ?>
                            </div>
                        </label>
                    </section>
                    <section class="filter-criteria filter-criteria_accordion">
                        <label class="filter-criteria__accordion-click-wrapper">
                            <input class="filter-criteria__accordion-checkbox" type="checkbox"> <!-- accordion на css, чтобы не загружать js -->
                            <h3 class="filter-criteria__caption">Толщина пиш. части, мм<span class="filter-criteria__accordion-icon"></span></h3>
                            <div class="filter-criteria__content">
                            <?php foreach ($ProductsTipThickness as $ProductTipThickness): ?> 
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption"><?php print($ProductTipThickness['tipThickness'])?></span>
                                    <input type="checkbox" name="filterTipThickness[]" value="<?php print($ProductTipThickness['tipThickness'])?>">
                                </label>
                            <?php endforeach; ?>
                            </div>
                        </label>
                    </section>
                    <section class="filter-criteria filter-criteria_accordion">
                        <label class="filter-criteria__accordion-click-wrapper">
                            <input class="filter-criteria__accordion-checkbox" type="checkbox"> <!-- accordion на css, чтобы не загружать js -->
                            <h3 class="filter-criteria__caption">Показывать только новинки<span class="filter-criteria__accordion-icon"></span></h3>
                            <div class="filter-criteria__content">
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption">Да</span>
                                    <input type="checkbox" name="filterNewProduct" value="1">
                                </label>
                            </div>
                        </label>
                    </section>
                    
                    <button class="catalog-page__btn-submit" name="button">Применить</button>
                </form>
            </aside>
            <section class="catalog-page__items-container">
                <?php if($products != NULL && isset($products) && !empty($products)):?>
                <?php foreach ($products as $product):?> 
                <figure class="catalog-page__item item">
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
                <?php if((isset($resultStatus) && !empty($resultStatus)))$QuantityPage=0;
                ?>
                <nav class="catalog-page__pagination pagination"> 
                    <a class="pagination__page pagination__page_back" href="../../catalog/page/<?php if($QuantityPage!=1)print($page-1);else print($page)?>">
                        <span class="pagination__back-icon">< </span><!--
                    --><span class="pagination__back-text"><?php if((isset($resultStatus) && !empty($resultStatus)))print("в разработке");else  print("Назад")?></span>
                    </a>
                    <?php 
                    
                    for($i=1;$i<=$QuantityPage;$i++){
                        ?><a class="pagination__page <?php  if($i==$page)print("pagination__page_current")  ?>" href="../../catalog/page/<?php print ($i) ?>"><?php print ($i) ?></a><?php
                    }
                    ?>
                    
                    <a class="pagination__page pagination__page_next" href="../../catalog/page/<?php if($QuantityPage!=1)print($page+1);else print($page)?>">
                        <span class="pagination__next-text"><?php if((isset($resultStatus) && !empty($resultStatus)))print("в разработке");else  print("Вперед")?></span>
                        <span class="pagination__next-icon">></span>
                    </a>
                </nav>
            </section>
        </div>
    </main>

<?php
require_once(VIEWS . "shared" . DIRECTORY_SEPARATOR . "footerView.php");