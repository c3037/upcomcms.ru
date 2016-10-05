<h1><?php echo $data['page_title']; ?></h1>

<?php if (count($data['messages']) > 0 ): ?>

<?php foreach( $data['messages'] as $message): 
extract($message); ?>

<div class="panel panel-<?php echo ($viewed == 'yes') ? "info" : "default"; ?>">
<div class="panel-heading">
<?php echo $date; ?>
</div>
<div class="panel-body panel-body_messages">

<?php echo $body; ?>

<?php if(isset($include) and $include != ''): ?>

<br><br><strong>Вложение:</strong> <a href="/account/files?upload=<?php echo $include; ?>" title=""><?php echo $include_name; ?></a>

<?php endif; ?>

</div>
</div>

<?php endforeach; ?>

<?php else: ?>
<p>Данных не найдено</p>
<?php endif; ?>