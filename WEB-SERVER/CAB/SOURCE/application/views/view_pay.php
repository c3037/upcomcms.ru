<h1><?php echo $data['page_title']; ?></h1>

<?php if(!Config::$use_pay): ?>

<p>Раздел отключён администратором.</p>

<?php else: ?>

<script>
window.onload=function(){
var sum1 = document.getElementById("sum1");
var sum2 = document.getElementById("sum2");
sum1.onkeydown=function(){};
sum1.onfocus = function(){};
sum1.onkeyup=function(){
    sum2.value = getSumAndFee(sum1.value);
};
sum1.onblur=function(){
    sum2.value = getSumAndFee(sum1.value);
};
function getSumAndFee(sum){
    sum = sum.replace(/,/g,".");
    if (isNaN(sum) || sum < 0 || sum.length==0) return "Неверный формат числа";
    sum = parseFloat(sum);
    var comm = (1/(1-<?php echo Config::$pay_online_commission_percent; ?>/100))-1;
    var fee = sum*comm;
    if(fee<<?php echo Config::$pay_online_min_commission; ?>) fee = <?php echo Config::$pay_online_min_commission; ?>;
    fee = Math.ceil(fee*100)/100;
    if(sum<=0 || fee<=0) fee = 0.00;
    sum = sum+fee;
    sum = sum.toFixed(2);
    return sum.replace(/\./g,",");
}
};
</script>

<form autocomplete="off" action="/account/to_payment" method="get">

<p id="saldo">Текущий долг (+), переплата (-): &nbsp;<?php echo $data['saldo']; ?> руб.</p>

<div class="panel panel-info">
<div class="panel-heading">
Сумма, руб.
</div>
<div class="panel-body">
<input type="text" id="sum1" value="<?php echo $data['sum']; ?>" name="sum1">
</div>
</div>

<div class="panel panel-info">
<div class="panel-heading">
Сумма с учётом комиссии ( <span style="font-size:13px"><?php echo $data["commission"]; ?>%, мин.: <?php echo $data["min_commission"];?> руб.</span> ), руб.
</div>
<div class="panel-body">
<input type="text" id="sum2" value="<?php echo $data['sum_and_fee']; ?>" name="sum2" readonly="readonly">
</div>
</div>

<input type="hidden" name="d" value="<?php echo date("YmdHis"); ?>">
<input type="submit" value="Перейти к оплате" class="btn_blue btn_blue_submit">
</form>


<?php endif; ?>