<h1><?php echo $data['page_title']; ?></h1>

<div class="panel panel-info">
<div class="panel-heading">
Лицевой счёт
</div>
<div class="panel-body">
<?php echo $data['user_lc']; ?>
</div>
</div>

<div class="panel panel-info">
<div class="panel-heading">
Собственник
</div>
<div class="panel-body">
<?php echo $data['user_name']; ?>
</div>
</div>

<div class="panel panel-info">
<div class="panel-heading">
Адрес
</div>
<div class="panel-body">
<?php echo $data['user_address']; ?>
</div>
</div>

<div class="panel panel-info">
<div class="panel-heading">
Площадь
</div>
<div class="panel-body">
Общая - <?php echo $data['user_total_space']; ?> кв.м.<br><br>Жилая - <?php echo $data['user_living_space']; ?> кв.м.
</div>
</div>

<div class="panel panel-info">
<div class="panel-heading">
Проживают
</div>
<div class="panel-body">
<?php echo $data['user_residents']; ?>
</div>
</div>

<div class="panel panel-info">
<div class="panel-heading">
Телефон
</div>
<div class="panel-body">
<?php echo $data['user_phone']; ?>
</div>
</div>

<div class="panel panel-info">
<div class="panel-heading">
E-mail адрес
</div>
<div class="panel-body">
<?php echo $data['user_email']; ?>
</div>
</div>