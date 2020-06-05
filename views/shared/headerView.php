<?php
    require_once(CONTROLLERS . "userController.php");
?>
    <!DOCTYPE html>
    <html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="../../src/assets/img/shared/icons/favicon.ico">
        <link rel="stylesheet" type="text/css" href="../../src/css/normalize.css">
        <link rel="stylesheet" type="text/css" href="../../src/css/header.css">
        <link rel="stylesheet" type="text/css" href="../../src/css/mainpage.css">
        <link rel="stylesheet" type="text/css" href="../../src/css/catalog-page.css">
        <link rel="stylesheet" type="text/css" href="../../src/css/product-page.css">
        <link rel="stylesheet" type="text/css" href="../../src/css/modal-login-register.css">
        <link rel="stylesheet" type="text/css" href="../../src/css/footer.css">
        <link rel="stylesheet" type="text/css" href="../../src/css/my-orders.css"/>
        <title>Zuwer</title>
    </head>
    <body>
    <?php
        require_once(VIEWS ."shared" . DIRECTORY_SEPARATOR . "modalLogRegView.php");
    ?>
        <header class = "header">
            <div class="burger-menu">
                <input id="header-burger-menu-checkbox" type="checkbox">
                <label class="burger-menu-button" for="header-burger-menu-checkbox">
                    <span class="burger-menu-button-icon">
                        <div class="burger-menu-icon"></div>
                    </span>
                </label>
                <div class="burger-menu-nav-wrapper">
                    <nav class="burger-menu-nav">
                        <a href="/"><span>Главная</span></a>
                        <a href="/catalog"><span>Каталог</span></a>
                    </nav>
                </div>
                <label for="header-burger-menu-checkbox" class="burger-menu-background"></label>
            </div>
            <div class="wrapper">      
                <a href = "/" class="logo">
                    <img class="logoimg" src="../../src/assets/img/shared/icons/logo.svg"></img> 
                </a>
                <nav class = "headernav"> 
                    <ul class="navlink">    
                        <!-- TODO: Добавить отображение текущей страницы -->
                        <li class="navlink-item"><a href="/"><span>Главная</span></a></li>
                        <li class="navlink-item"><a href="/catalog"><span>Каталог</span></a></li>
                        <?php if(!userModel::userIsLoggedIn()):?>
                        <li class="navlink-item navlink-open-modal"><button class="toggle-modal-log-reg">Логин</button></li>
                        <?php else:?>
                        <li class="navlink-item navlink-item_dropdown">
                            <span class="username">
                                <?php
                                # Отображаем имя и фамилию пользователя, если они у него есть, иначе, отображаем только фамилию или только логин.
                                    $headerUserName = "";
                                    $headerUserName .= $_SESSION["user"]['name'];
                                    $headerUserName .= $_SESSION["user"]['surname'] ? " " . $_SESSION["user"]['surname'] : "";
                                    $headerUserName .= !$headerUserName ? $_SESSION["user"]['login'] : "";
                                    echo $headerUserName;
                                ?>
                            </span>
                            <ul class = "dropdown-menu">
                                <li class="dropdown-menu-item">
                                    <a class = "dropdown-menu-link" href="/user/myorders/">
                                        <div class="icon-wrapper">
                                            <span class="my-orders-icon"></span>
                                        </div>
                                        <span class="dropdown-menu-item-name">Мои заказы</span>
                                    </a>
                                </li>
                                <li class="dropdown-menu-item">
                                    <a class = "dropdown-menu-link" href="#">
                                        <div class="icon-wrapper">
                                            <span class="favorites-icon"></span>
                                        </div>
                                        <span class="dropdown-menu-item-name">Избранное</span>
                                    </a>
                                </li>
                                <li class="dropdown-menu-item">
                                    <a class = "dropdown-menu-link" href="/user/logout">
                                        <div class="icon-wrapper">
                                            <span class="exit-icon"></span>
                                        </div>
                                        <span class="dropdown-menu-item-name">Выход</span> 
                                    </a>
                                </li>
                            </ul>
                        <?php endif; ?>
                        </li>
                    </ul>
                </nav>
            </div>
        </header>