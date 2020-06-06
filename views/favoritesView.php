<?php
require_once(VIEWS . "shared" . DIRECTORY_SEPARATOR . "headerView.php");
?>

<body>
    <main class="favorite-items">
        <div class="favorite-items-container">
            <?php if ($favorites) : ?>
                <?php foreach ($favorites as $favorite) : ?>
                    <article class="favorite-item">
                        <a href="/catalog/product/<?php echo $favorite["id_product"] ?>">
                            <div class="img-pen">
                                <div class="img-wrapper">
                                    <?php
                                    $img = base64_encode($favorite["picture"]);
                                    echo "<img class=\"item__image\" src=\"data:image/jpeg; base64,$img\" alt=\"item image\" >";
                                    ?>
                                </div>
                            </div>
                            <div class="line"></div>
                            <div class="item-info">
                                <h1 class="item-title"><?php echo $favorite["title"] ?></h1>
                                <div class="bottom-row">
                                    <h3 class="item-price"><?php echo $favorite["price"] ?>$</h3>
                                    <form action="/catalog/dropFavorite/<?php echo $favorite["id_product"] ?>" method="POST">
                                        <button class="btn-delete">
                                            <span class="btn-text">Удалить</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </a>
                    </article>
                <?php endforeach; ?>
            <?php else : ?>
                <h1 style="color: white; font-size: 25px;">Здесь пусто.<br> <span style="font-size: 16px; font-weight: 200;"> <a href="/catalog/" style="color: white;">Добавьте</a> что-нибудь в избранное. </span> </h1>
            <?php endif; ?>
        </div>

    </main>
</body>

<?php
require_once(VIEWS . "shared" . DIRECTORY_SEPARATOR . "footerView.php");
