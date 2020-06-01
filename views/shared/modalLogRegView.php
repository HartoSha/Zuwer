<?php
require_once(VIEWS . "shared" . DIRECTORY_SEPARATOR . "headerView.php");
?>

<div class="modal-log-reg invisible">
  <div class="background"></div>
  <div class="modal-log">
    <section section class="form-container">
      <div class="form-login">
        <div>

          <div class="modal-header">
            <button class="login-btn selected-btn"><span class="btn-text">Вход</span></button>
            <!--
              --><button class="registration-btn" id="registr-btn"><span class="btn-text">Регистрация</span></button>
          </div>

          <form action="user/login" method="POST" class="modal-login">
            <input type="text" placeholder="Введите логин" name="user-name" />

            <input type="password" placeholder="Введите пароль" name="user-psw" />

            <button class="login"><span class="btn-text">Войти</span></button>
          </form>
        </div>
      </div>
    </section>
  </div>

  <div class="modal-registration invisible">
    <section class="form-container">
      <div class="form-registration">
        <div>
          <div class="modal-header">
            <button class="login-btn" id="login-btn"> <span class="btn-text">Вход</span></button>
            <!--
          --><button class="registration-btn"> <span class="btn-text">Регистрация</span> </button>
          </div>
          <form action="user/register" method="POST" class="modal-reg">

            <input type="text" placeholder="Имя" class="name registration-field" name="reg-name" />
            <input type="text" placeholder="Фамилия" class="surname registration-field" name="reg-surname" />
            <input type="text" placeholder="Отчество" class="Middlename registration-field" name="reg-middlename" />
            <input type="text" placeholder="Логин" class="account-name registration-field" name="reg-account-name" />

            <input type="password" placeholder="Пароль" class="password registration-field" name="reg-pass" />
            <input type="password" placeholder="Пароль повторно" class="password password-again registration-field" name="reg-pass-again" />

            <input type="text" placeholder="Телефон" class="telephone registration-field" name="reg-telephone" />

            <button class="registration">
              <span class="btn-text">Зарегистрироваться</span>
            </button>
          </form>
        </div>
      </div>
    </section>
  </div>

</div>

<script type="text/javascript" src="../../src/js/modal-login-register.js"></script>

<?php
require_once(VIEWS . "shared" . DIRECTORY_SEPARATOR . "footerView.php");
