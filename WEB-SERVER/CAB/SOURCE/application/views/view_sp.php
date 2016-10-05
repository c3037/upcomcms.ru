<div class="container">

<?php if(!Config::$use_pay): ?>

<p>Раздел отключён администратором</p>

<?php else: ?>

<h1>Ваш платёж принят</h1>
<p>После зачисления денежных средств на расчётный счёт компании, вы сможете увидеть<br>его в личном кабинете. Пожалуйста сохраните следующие данные, они<br>могут понадобиться в случае "пропажи" платежа:</p>
<p style="text-align:left;width:320px;margin:0 auto;font-weight:bold;">DT: <?php echo $data["dateTime"]; ?><br>TID: <?php echo $data["transactionID"]; ?><br>OID: <?php echo $data["orderID"]; ?></p>
<p><a href="/account" title="Перейти в личный кабинет">Перейти в личный кабинет</a></p>

</div>


<?php endif; ?>