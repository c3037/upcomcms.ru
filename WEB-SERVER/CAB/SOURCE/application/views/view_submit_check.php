<h1><?php echo $data['page_title']; ?></h1>

<?php if (count($data['counter_values']) > 0 ): ?>

<form autocomplete="off" action="/account/submit_send" method="post" onsubmit="event_send_counters_values();">

<?php foreach ($data['counter_values'] as $counter):
extract($counter); ?>

<div class="panel panel-info">
<div class="panel-heading">
<?php echo $service; ?> <?php if(!empty($serial)) echo '&nbsp; &#124; &nbsp;'; ?> <?php echo $serial; ?>
</div>
<div class="panel-body">
<?php if( $number_of_tariffs > 1 ) : ?>
<input type="text" value="<?php echo $value1; ?>" name="counter[<?php echo $id; ?>][1]" readonly="readonly"><br />
<input type="text" value="<?php echo $value2; ?>" name="counter[<?php echo $id; ?>][2]" readonly="readonly">
<?php else : ?>
<input type="text" value="<?php echo $value; ?>" name="counter[<?php echo $id; ?>]" readonly="readonly">
<?php endif; ?>
</div>
</div>

<?php endforeach; ?>

<input type="submit" value="Передать" class="btn_blue btn_blue_submit">
</form>

<?php else: ?>
<p>Данных не найдено</p>
<?php endif; ?>