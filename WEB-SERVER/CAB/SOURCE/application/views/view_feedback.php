<h1><?php echo $data['page_title']; ?></h1>

<a href="/account/messages" class="btn_blue btn_default btn_default_feedback">История отправленных сообщений</a>

<?php
if(isset($_GET['error']) and $_GET['error'] == 'bad_message_length'):
    echo '<p class="danger">Длина сообщения должна быть не менее 10 и не более 32 000 символов.</p>';
elseif(isset($_GET['error']) and $_GET['error'] == 'bad_query_size'):
    echo '<p class="danger">Размер вложения превышает допустимое значение.</p>';
elseif(isset($_GET['error']) and $_GET['error'] == 'does_not_exist_message'):
    echo '<p class="danger">Во время отправки сообщения возникла ошибка. Повторите запрос, проверив данные.</p>';
endif;
?>

<form autocomplete="off" action="/account/feedback_send" method="post" enctype="multipart/form-data" onsubmit="event_feedback();">

<div class="panel panel-info">
<div class="panel-heading">
Сообщение
</div>
<div class="panel-body">
<textarea rows="3" name="message"></textarea>
</div>
</div>

<div class="panel panel-info">
<div class="panel-heading">
Вложение ( <?php echo $data['max_file_size']; ?> МБ )
</div>
<div class="panel-body">
<br>
<input type="file" name="file" />
<br><br>
</div>
</div>

<input type="submit" value="Отправить" class="btn_blue btn_blue_feedback">
</form>