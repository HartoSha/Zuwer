<?php
require_once(VIEWS . "shared" . DIRECTORY_SEPARATOR . "headerView.php");
?>
<main class="mainpage">
    <div class="center">
        <div class="slogan">
            <h1>Zuwer</h1>
            <div class="advantages">
                <div class="advantage"><img src="src/assets/img/mainpage/Quality/premium.png" alt="premium"><span>Премиальность</span></div>
                <div class="advantage"><img src="src/assets/img/mainpage/Quality/quality.png" alt="quality"><span>Качество</span></div>
                <div class="advantage"><img src="src/assets/img/mainpage/Quality/realibility.png" alt="reliability"><span>Надежность</span></div>
            </div>
        </div>
    </div>
    <div class="our-partners">
        <h2>Наши Партнеры</h2>
        <div class="partners-wrapper">
            <?php foreach ($manufacturers as $m):?>
                <div class="partners">
                    <?php 
                        $img = base64_encode($m["picture"]);
                        echo "<img class=\"img-partners\" src=\"data:image/jpeg; base64,$img\" alt=\"Partner image\" >";
                    ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>
<div class="slider-decoration">
    <div id="slider" class="slider">
        <button class="slider__leftButton">
            <svg id="Capa_1" data-name="Capa 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 253.02 476.74">
                <defs>
                    <style>
                        .cls-1 {
                            fill: #fff;
                        }
                    </style>
                </defs>
                <title>next 2</title>
                <path class="cls-1" d="M3.84,247.1,228,473.16a13.51,13.51,0,0,0,19.18-19L32.58,237.72,249,23.14a13.45,13.45,0,0,0,.15-19L249.09,4a13.65,13.65,0,0,0-9.49-4,13.15,13.15,0,0,0-9.51,4L4,228.1a13.43,13.43,0,0,0-.2,19Z" transform="translate(0 -0.04)" />
            </svg>
        </button>
        <div class="slider__content">
            <?php foreach ($newProducts as $product):?>
                <article class="slider__item">
                    <a class="slider-fix" href="/catalog/product/<?php print $product["id_product"]?>">
                        <span class="item__new-icon"></span>
                        <div class="circle">
                            <?php 
                                $img = base64_encode($product["picture"]);
                                echo "<img class=\"pen-icon\" src=\"data:image/jpeg; base64,$img\" alt=\"new product\" >";
                            ?>
                        </div>
                        <div class="item__bottom-row">
                            <span class="item__name"><?php print $product["title"] ?></span>
                            <span class="item__line"></span>
                            <span class="item__price">
                                <span class="item__price-value"><?php print $product["price"] ?></span>
                                <span class="item__price-currency-sign">$</span>
                            </span>
                        </div>
                    </a>
                </article>

            <?php endforeach; ?>
        </div>
        <button class="slider__rightButton">
            <svg id="Capa_1" data-name="Capa 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 252.06 477.18">
                <defs>
                    <style>
                        .cls-1 {
                            fill: #fff;
                        }
                    </style>
                </defs>
                <title>next1</title>
                <path class="cls-1" d="M360.73,229.07,135.63,4a13.51,13.51,0,0,0-19.1,19.1L332,238.57,116.53,454.08a13.55,13.55,0,0,0,9.5,23.1,13.17,13.17,0,0,0,9.5-4l225.1-225.1A13.44,13.44,0,0,0,360.73,229.07Z" transform="translate(-112.56 0)" />
            </svg>
        </button>
    </div>
</div>
<script type="text/javascript" src="src/js/mainpage-slider.js"></script>
<?php
require_once(VIEWS . "shared" . DIRECTORY_SEPARATOR . "footerView.php");
?>