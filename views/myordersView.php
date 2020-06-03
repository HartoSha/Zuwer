<?php
require_once(VIEWS . "shared" . DIRECTORY_SEPARATOR . "headerView.php");
// var_dump($productInfo);
?>
    <main class="my-orders">
    <div class="orders-container">
      <article class="order-item">
        <a class="" href="#">
          <div class="order-item-img">
            <div class="order-item-img-wrapper">
              <img src="../assets/img/icons/pen-img.svg" alt="pen" class="item-img" />
            </div>
          </div>
          <div class="order-item-line"></div>
          <div class="order-item-info">
            <h2 class="order-item-title">Montagrappa European</h2>
            <table>
              <tr>
                <td class="order-item-prop">Количество</td>
                <td class="order-item-prop-value">1</td>
              </tr>
              <tr>
                <td class="order-item-prop">Текущий статус</td>
                <td class="order-item-prop-value">В пути</td>
              </tr>
              <tr>
                <td class="order-item-prop">Дата совершения заказа</td>
                <td class="order-item-prop-value">22.05.2003</td>
              </tr>
              <tr>
                <td class="order-item-prop">Стоимость заказа</td>
                <td class="order-item-prop-value">7855.55<span>$</span></td>
              </tr>
            </table>
          </div>
        </a>
      </article>
      <article class="order-item">
        <a class="" href="#">
          <div class="order-item-img">
            <div class="order-item-img-wrapper">
              <img src="../assets/img/icons/pen-img.svg" alt="pen" class="item-img" />
            </div>
          </div>
          <div class="order-item-line"></div>
          <div class="order-item-info">
            <h2 class="order-item-title">Montagrappa European</h2>
            <table>
              <tr>
                <td class="order-item-prop">Количество</td>
                <td class="order-item-prop-value">1</td>
              </tr>
              <tr>
                <td class="order-item-prop">Текущий статус</td>
                <td class="order-item-prop-value">В пути</td>
              </tr>
              <tr>
                <td class="order-item-prop">Дата совершения заказа</td>
                <td class="order-item-prop-value">22.05.2003</td>
              </tr>
              <tr>
                <td class="order-item-prop">Стоимость заказа</td>
                <td class="order-item-prop-value">7855.55<span>$</span></td>
              </tr>
            </table>
          </div>
        </a>
      </article>
    </div>
  </main>
<?php
require_once(VIEWS . "shared" . DIRECTORY_SEPARATOR . "footerView.php");