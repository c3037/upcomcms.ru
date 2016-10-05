<div class="container">

<h1>Личный кабинет</h1>

<?php if (count($data['uk_list']) > 0 ): ?>

<?php if(isset($_GET['status']) and $_GET['status'] == 'error'):
echo '<p class="danger">Указанные данные не верны.<br>Обратитесь в Вашу управляющую компанию.</p>';
endif; ?>

<form action="/account/login" method="post">
<input type="text" placeholder="Лицевой счёт" name="account" required>
<input type="password" placeholder="Пароль" name="password" required>
<select name="uk" required>

<?php foreach ($data['uk_list'] as $uk_number => $uk_name):
echo "<option value='$uk_number'",($data['last_uk']==$uk_number) ? " selected" : "",">$uk_name</option>";
endforeach; ?>

</select>
<input type="submit" value="Войти">
</form>

<?php else: ?>
<p>Данных не найдено</p>
<?php endif; ?>

</div>