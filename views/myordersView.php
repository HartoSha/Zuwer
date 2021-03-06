<?php
require_once(VIEWS . "shared" . DIRECTORY_SEPARATOR . "headerView.php");
?>
    <main class="my-orders">
    <div class="orders-container">
    <?php if($orders && isset($orders) && !empty($orders)):?>
    <?php for($i = 0; $i < count($orders); $i++):?>
      
          <article class="order-item">
          <a class="" href="/catalog/product/<?php echo $orders[$i]["id_product"]?>">
            <div class="order-item-img">
              <div class="order-item-img-wrapper">
              <?php 
                  $img = base64_encode($orders[$i]["picture"]);
                  echo "<img class=\"item__image\" src=\"data:image/jpeg; base64,$img\" alt=\"item image\" >";
              ?>
              </div>
            </div>
            <div class="order-item-line"></div>
            <div class="order-item-info">
              <h2 class="order-item-title"><?php echo $orders[$i]["product-name"] ?></h2>
              <table>
                <tr>
                  <td class="order-item-prop">Количество</td>
                  <td class="order-item-prop-value"><?php echo $orders[$i]["quantity"] ?></td>
                </tr>
                <tr>
                  <td class="order-item-prop">Текущий статус</td>
                  <td class="order-item-prop-value"><?php echo $orders[$i]["statusName"] ?></td>
                </tr>
                <tr>
                  <td class="order-item-prop">Дата совершения заказа</td>
                  <td class="order-item-prop-value"><?php echo $orders[$i]["date"] ?></td>
                </tr>
                <tr>
                  <td class="order-item-prop">Стоимость заказа</td>
                  <td class="order-item-prop-value"><?php echo $orders[$i]["sum"] ?><span>$</span></td>
                </tr>
              </table>
            </div>
          </a>
        </article>
    <?php endfor;?>
    <?php else: ?>
      <div class="no-items">
        <div class="no-items-wrapper">
          <h1 class="no-items-title">Здесь ничего нет <span class="emoji">＼(º □ º l|l)/</span><br></h1>
          <p><a href="/catalog/">Закажите</a> что-нибудь.</p>
        </div>
      </div>
    <?php endif; ?>  
    </div>
  </main>
<?php
require_once(VIEWS . "shared" . DIRECTORY_SEPARATOR . "footerView.php");