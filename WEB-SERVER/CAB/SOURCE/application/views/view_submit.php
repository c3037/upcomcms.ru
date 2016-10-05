<h1><?php echo $data['page_title']; ?></h1>

<?php if (count($data['counters']) > 0 ): ?>

<form autocomplete="off" action="/account/submit_check" method="post">

<?php foreach ($data['counters'] as $counter):
extract($counter); ?>

<div class="panel panel-info">
<div class="panel-heading">
<?php echo $service; ?> <?php if(!empty($serial)) echo '&nbsp; &#124; &nbsp;'; ?> <?php echo $serial; ?>
</div>
<div class="panel-body">
<?php if( $number_of_tariffs > 1 ) : ?>
<input type="text" placeholder="День - Введите значение или оставьте поле пустым" name="counter[<?php echo $id; ?>][1]"><br />
<input type="text" placeholder="Ночь - Введите значение или оставьте поле пустым" name="counter[<?php echo $id; ?>][2]">
<?php else : ?>
<input type="text" placeholder="Введите значение или оставьте поле пустым" name="counter[<?php echo $id; ?>]">
<?php endif; ?>
</div>
</div>

<?php endforeach; ?>

<input type="submit" value="Проверить" class="btn_blue btn_blue_submit">
</form>

<?php else: ?>
<p>Данных не найдено</p>
<?php endif; ?>