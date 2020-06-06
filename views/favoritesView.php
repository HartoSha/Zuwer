<?php
require_once(VIEWS . "shared" . DIRECTORY_SEPARATOR . "headerView.php");
?>

<body>
    <main class="favorite-items">
        <div class="favorite-items-container">
            <article class="favorite-item">
                <a href="#">
                    <div class="img-pen">
                        <div class="img-wrapper">
                            <img src="../imgs/pen-img.svg" alt="pen" class="item-img" />
                        </div>
                    </div>
                    <div class="line"></div>
                    <div class="item-info">
                        <h1 class="item-title">Montagrappa European</h1>
                        <div class="bottom-row">
                            <h3 class="item-price">7845,65 $</h3>
                            <button class="btn-delete">
                                <span class="btn-text">Удалить</span>
                            </button>
                        </div>
                    </div>
                </a>
            </article>
        </div>

    </main>
</body>

<?php
require_once(VIEWS . "shared" . DIRECTORY_SEPARATOR . "footerView.php");
