<?php
require_once(VIEWS . "shared" . DIRECTORY_SEPARATOR . "headerView.php");
?>
<div class="modal-log-reg 
  <?php # Отображаем модальное окно сразу, если были ошибки в регистрации или авторизации
    echo (isset($_SESSION["registration-errors"]) && count($_SESSION["registration-errors"])
        ||isset($_SESSION["login-errors"]) && count($_SESSION["login-errors"]) ) ? "" : "invisible";
  ?>
">
  <div class="background toggle-modal-log-reg"></div>
  <div class="modal-log-reg-container 
    <?php
      echo (isset($_SESSION["registration-errors"]) && count($_SESSION["registration-errors"])) ? "js-inReg" : "js-inLogin";
    ?>
  ">
    <div class="modal-header">
      <button class="login-btn selected-btn" name="login-btn"><span class="btn-text">Вход</span></button>
      <button class="registration-btn" id="registr-btn" name="register-btn"><span class="btn-text">Регистрация</span></button>
    </div>
    <section class="form-container login-container">

      <div class="form-login">
        <?php if (isset($_SESSION["login-errors"]) && count($_SESSION["login-errors"])) : ?>
          <ul class="modal-errors">
            <?php foreach ($_SESSION["login-errors"] as $error) echo '<li class="modal-error-text">' . array_shift($_SESSION["login-errors"]) . '</li>'; ?>
          </ul>
        <?php endif; ?>
        <form action="/user/login" method="POST" class="modal-login">
          <input type="text" placeholder="Введите логин" required name="user-name" />
          <input type="password" placeholder="Введите пароль" required name="user-psw" />
          <button class="login"><span class="btn-text">Войти</span></button>
        </form>
      </div>
    </section>
    <section class="form-container reg-container">
      <div class="form-registration">
        <?php if (isset($_SESSION["registration-errors"]) && count($_SESSION["registration-errors"])) : ?>
          <!-- Выводим ошибки регистрации, если они есть -->
          <ul class="modal-errors">
            <?php foreach ($_SESSION["registration-errors"] as $error) echo '<li class="modal-error-text">' . array_shift($_SESSION["registration-errors"]) . '</li>'; ?>
          </ul>
        <?php endif; ?>
        <!-- TODO: Добавить отображение полей логин, и пароль как обязательных и наоборот. -->
        <form action="/user/register" method="POST" class="modal-reg">
          <input type="text" placeholder="Имя" class="registration-field" name="reg-name" />
          <input type="text" placeholder="Фамилия" class="registration-field" name="reg-surname" />
          <input type="text" placeholder="Отчество" class="registration-field" name="reg-middlename" />
          <input type="text" placeholder="Логин" required class="registration-field" name="reg-account-name" />
          <input type="password" placeholder="Пароль" required class="registration-field" name="reg-pass" />
          <input type="password" placeholder="Пароль повторно" required class="registration-field" name="reg-pass-again" />
          <input type="text" placeholder="Телефон" class="registration-field" name="reg-telephone" />
          <button class="registration">
            <span class="btn-text">Зарегистрироваться</span>
          </button>
        </form>
      </div>
    </section>
  </div>
</div>

<script type="text/javascript" src="../../src/js/modal-login-register.js"></script>