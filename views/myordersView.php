<?php
require_once(VIEWS . "shared" . DIRECTORY_SEPARATOR . "headerView.php");
// var_dump($productInfo);
?>
    <main class="my-orders">
    <?php if(isset($ordersInfo) && !empty($ordersInfo)):?>
    <?php for($i = 0; $i < count($ordersInfo); $i++):?>
      <div class="orders-container">
          <article class="order-item">
          <a class="" href="#">
            <div class="order-item-img">
              <div class="order-item-img-wrapper">
              <?php 
                  $img = base64_encode($ordersInfo[$i]["picture"]);
                  echo "<img class=\"item__image\" src=\"data:image/jpeg; base64,$img\" alt=\"item image\" >";
              ?>
              </div>
            </div>
            <div class="order-item-line"></div>
            <div class="order-item-info">
              <h2 class="order-item-title"><?php echo $ordersName[$i] ?></h2>
              <table>
                <tr>
                  <td class="order-item-prop">Количество</td>
                  <td class="order-item-prop-value"><?php echo $ordersInfo[$i]["quantity"] ?></td>
                </tr>
                <tr>
                  <td class="order-item-prop">Текущий статус</td>
                  <td class="order-item-prop-value"><?php echo $ordersInfo[$i]["statusName"] ?></td>
                </tr>
                <tr>
                  <td class="order-item-prop">Дата совершения заказа</td>
                  <td class="order-item-prop-value"><?php echo $ordersInfo[$i]["date"] ?></td>
                </tr>
                <tr>
                  <td class="order-item-prop">Стоимость заказа</td>
                  <td class="order-item-prop-value"><?php echo $ordersInfo[$i]["sum"] ?><span>$</span></td>
                </tr>
              </table>
            </div>
          </a>
        </article>
        
      </div>
    <?php endfor;?>
    <?php endif; ?>  
  </main>
<?php
require_once(VIEWS . "shared" . DIRECTORY_SEPARATOR . "footerView.php");