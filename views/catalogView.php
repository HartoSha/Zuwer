<?php
    require_once (VIEWS . "shared" . DIRECTORY_SEPARATOR . "headerView.php");
?>

    <main class="catalog-page">
        <div class="content-grid">
            <aside class="catalog-page__filter">
                <form action="filter.php">
                    <section class="filter-criteria filter-criteria_accordion filter-criteria_range">
                        <label class="filter-criteria__accordion-click-wrapper">
                            <input class="filter-criteria__accordion-checkbox" type="checkbox"> <!-- accordion на css, чтобы не загружать js -->
                            <h3 class="filter-criteria__caption">Цена, $<span class="filter-criteria__accordion-icon"></span></h3>
                            <div class="filter-criteria__content">
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption">От:</span>
                                    <input type="number" min="0" max="1000">
                                    <span class="filter-criteria__option-underline"></span> <!-- было решено добавить пустой span после input для создания золотистого подчеркивания, т.к. input::after не поддерживается -->
                                </label>
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption">До:</span>
                                    <input type="number">
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
                                    <input type="number">
                                    <span class="filter-criteria__option-underline"></span>
                                </label>
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption">До:</span>
                                    <input type="number">
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
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption">Montegrappa</span>
                                    <input type="checkbox">
                                </label>
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption">Parker</span>
                                    <input type="checkbox">
                                </label>
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption">Waterman</span>
                                    <input type="checkbox">
                                </label>
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption">Namiki</span>
                                    <input type="checkbox">
                                </label>
                            </div>
                        </label>
                    </section>
                    <section class="filter-criteria filter-criteria_accordion">
                        <label class="filter-criteria__accordion-click-wrapper">
                            <input class="filter-criteria__accordion-checkbox" type="checkbox"> <!-- accordion на css, чтобы не загружать js -->
                            <h3 class="filter-criteria__caption">Материал <span class="filter-criteria__accordion-icon"></span></h3>
                            <div class="filter-criteria__content">
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption">1</span>
                                    <input type="checkbox">
                                </label>
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption">2</span>
                                    <input type="checkbox">
                                </label>
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption">3</span>
                                    <input type="checkbox">
                                </label>
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption">4</span>
                                    <input type="checkbox">
                                </label>
                            </div>
                        </label>
                    </section>
                    <section class="filter-criteria filter-criteria_accordion">
                        <label class="filter-criteria__accordion-click-wrapper">
                            <input class="filter-criteria__accordion-checkbox" type="checkbox"> <!-- accordion на css, чтобы не загружать js -->
                            <h3 class="filter-criteria__caption">Цвет<span class="filter-criteria__accordion-icon"></span></h3>
                            <div class="filter-criteria__content">
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption">1</span>
                                    <input type="checkbox">
                                </label>
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption">2</span>
                                    <input type="checkbox">
                                </label>
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption">3</span>
                                    <input type="checkbox">
                                </label>
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption">4</span>
                                    <input type="checkbox">
                                </label>
                            </div>
                        </label>
                    </section>
                    <section class="filter-criteria filter-criteria_accordion">
                        <label class="filter-criteria__accordion-click-wrapper">
                            <input class="filter-criteria__accordion-checkbox" type="checkbox"> <!-- accordion на css, чтобы не загружать js -->
                            <h3 class="filter-criteria__caption">Тип<span class="filter-criteria__accordion-icon"></span></h3>
                            <div class="filter-criteria__content">
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption">1</span>
                                    <input type="checkbox">
                                </label>
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption">2</span>
                                    <input type="checkbox">
                                </label>
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption">3</span>
                                    <input type="checkbox">
                                </label>
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption">4</span>
                                    <input type="checkbox">
                                </label>
                            </div>
                        </label>
                    </section>
                    <section class="filter-criteria filter-criteria_accordion">
                        <label class="filter-criteria__accordion-click-wrapper">
                            <input class="filter-criteria__accordion-checkbox" type="checkbox"> <!-- accordion на css, чтобы не загружать js -->
                            <h3 class="filter-criteria__caption">Толщина пиш. части, мм<span class="filter-criteria__accordion-icon"></span></h3>
                            <div class="filter-criteria__content">
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption">1</span>
                                    <input type="checkbox">
                                </label>
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption">2</span>
                                    <input type="checkbox">
                                </label>
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption">3</span>
                                    <input type="checkbox">
                                </label>
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption">4</span>
                                    <input type="checkbox">
                                </label>
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption">4</span>
                                    <input type="checkbox">
                                </label>
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption">4</span>
                                    <input type="checkbox">
                                </label>
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption">4</span>
                                    <input type="checkbox">
                                </label>
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption">4</span>
                                    <input type="checkbox">
                                </label>
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption">4</span>
                                    <input type="checkbox">
                                </label>
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption">4</span>
                                    <input type="checkbox">
                                </label>
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption">4</span>
                                    <input type="checkbox">
                                </label>
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption">4</span>
                                    <input type="checkbox">
                                </label>
                                <label class="filter-criteria__option">
                                    <span class="filter-criteria__option-caption">4</span>
                                    <input type="checkbox">
                                </label>
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
                                    <input type="checkbox">
                                </label>
                            </div>
                        </label>
                    </section>
                    
                    <button class="catalog-page__btn-submit">Применить</button>
                </form>
            </aside>
            <section class="catalog-page__items-container">
                <figure class="catalog-page__item item">
                    <div class="item__upper-row">
                        <span class="item__type">Перьевая</span>
                        <span class="item__new-icon"></span>
                    </div>
                    <div class="item__image-wrapper">
                        <img src="../../src/assets/img/pen.jpg" alt="item image" class="item__image">
                    </div>
                    <div class="item__bottom-row">
                        <span class="item__name">Montegrappa European</span>
                        <span class="item__line"></span>
                        <span class="item__price">
                            <span class="item__price-value">7845,65</span>
                            <span class="item__price-currency-sign">$</span>
                        </span>
                    </div>
                </figure>
                <figure class="catalog-page__item item">
                    <div class="item__upper-row">
                        <span class="item__type">Перьевая</span>
                        <span class="item__new-icon"></span>
                    </div>
                    <div class="item__image-wrapper">
                        <img src="../../src/assets/img/pen.jpg" alt="item image" class="item__image">
                    </div>
                    <div class="item__bottom-row">
                        <span class="item__name">Montegrappa European</span>
                        <span class="item__line"></span>
                        <span class="item__price">
                            <span class="item__price-value">7845,65</span>
                            <span class="item__price-currency-sign">$</span>
                        </span>
                    </div>
                </figure>
                <figure class="catalog-page__item item">
                    <div class="item__upper-row">
                        <span class="item__type">Перьевая</span>
                        <span class="item__new-icon"></span>
                    </div>
                    <div class="item__image-wrapper">
                        <img src="../../src/assets/img/pen.jpg" alt="item image" class="item__image">
                    </div>
                    <div class="item__bottom-row">
                        <span class="item__name">Montegrappa European</span>
                        <span class="item__line"></span>
                        <span class="item__price">
                            <span class="item__price-value">7845,65</span>
                            <span class="item__price-currency-sign">$</span>
                        </span>
                    </div>
                </figure>
                <figure class="catalog-page__item item">
                    <div class="item__upper-row">
                        <span class="item__type">Перьевая</span>
                        <span class="item__new-icon"></span>
                    </div>
                    <div class="item__image-wrapper">
                        <img src="../../src/assets/img/pen.jpg" alt="item image" class="item__image">
                    </div>
                    <div class="item__bottom-row">
                        <span class="item__name">Montegrappa European</span>
                        <span class="item__line"></span>
                        <span class="item__price">
                            <span class="item__price-value">7845,65</span>
                            <span class="item__price-currency-sign">$</span>
                        </span>
                    </div>
                </figure>
                <figure class="catalog-page__item item">
                    <div class="item__upper-row">
                        <span class="item__type">Перьевая</span>
                        <span class="item__new-icon"></span>
                    </div>
                    <div class="item__image-wrapper">
                        <img src="../../src/assets/img/pen.jpg" alt="item image" class="item__image">
                    </div>
                    <div class="item__bottom-row">
                        <span class="item__name">Montegrappa European</span>
                        <span class="item__line"></span>
                        <span class="item__price">
                            <span class="item__price-value">7845,65</span>
                            <span class="item__price-currency-sign">$</span>
                        </span>
                    </div>
                </figure>
                <figure class="catalog-page__item item">
                    <div class="item__upper-row">
                        <span class="item__type">Перьевая</span>
                        <span class="item__new-icon"></span>
                    </div>
                    <div class="item__image-wrapper">
                        <img src="../../src/assets/img/pen.jpg" alt="item image" class="item__image">
                    </div>
                    <div class="item__bottom-row">
                        <span class="item__name">Montegrappa European</span>
                        <span class="item__line"></span>
                        <span class="item__price">
                            <span class="item__price-value">7845,65</span>
                            <span class="item__price-currency-sign">$</span>
                        </span>
                    </div>
                </figure>
                <figure class="catalog-page__item item">
                    <div class="item__upper-row">
                        <span class="item__type">Перьевая</span>
                        <span class="item__new-icon"></span>
                    </div>
                    <div class="item__image-wrapper">
                        <img src="../../src/assets/img/pen.jpg" alt="item image" class="item__image">
                    </div>
                    <div class="item__bottom-row">
                        <span class="item__name">Montegrappa European</span>
                        <span class="item__line"></span>
                        <span class="item__price">
                            <span class="item__price-value">7845,65</span>
                            <span class="item__price-currency-sign">$</span>
                        </span>
                    </div>
                </figure>
                <!-- pagination расположен в items-container для удобного прикрепления его к последней строке item'ов -->
                <nav class="catalog-page__pagination pagination"> 
                    <a class="pagination__page pagination__page_back" href="#">
                        <span class="pagination__back-icon">< </span><!--
                    --><span class="pagination__back-text">Назад</span>
                    </a>
                    <a class="pagination__page" href="#">1</a>
                    <a class="pagination__page pagination__page_current" href="#">2</a>
                    <a class="pagination__page" href="#">3</a>
                    <a class="pagination__page" href="#">4</a>
                    <a class="pagination__page" href="#">5</a>
                    <a class="pagination__page" href="#">6</a>
                    <a class="pagination__page" href="#">7</a>
                    <a class="pagination__page" href="#">8</a>
                    <a class="pagination__page" href="#">9</a>
                    <a class="pagination__page pagination__page_select" href="#">...</a>
                    <a class="pagination__page pagination__page_last" href="#">20</a>
                    <a class="pagination__page pagination__page_next" href="#">
                        <span class="pagination__next-text">Вперед</span>
                        <span class="pagination__next-icon">></span>
                    </a>
                </nav>
            </section>
        </div>
    </main>

<?php
require_once (VIEWS . "shared" . DIRECTORY_SEPARATOR . "footerView.php");