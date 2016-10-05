<h1><?php echo $data['page_title']; ?></h1>

<?php if (count($data['counter']) > 0 ): ?>

<div class="info"> <?php echo $data['counter']['service']; ?> <?php if(!empty($data['counter']['model'])) echo '&nbsp; &#124; &nbsp;'; ?> <?php echo $data['counter']['model']; ?></div>

<?php if (count($data['counter']['values']) > 0 ): ?>

<table>
    <tr>
        <th>Дата</th>
        <th>Значение</th>
    </tr>
    
    <?php foreach ($data['counter']['values'] as $row):
    
    extract($row);
    echo "<tr>";
    echo "<td>$date</td>";
    echo "<td>$value</td>";
    echo "</tr>";
    
    endforeach; ?>
    
</table>

<?php else: ?>
<p>Данных не найдено</p>
<?php endif; ?>

<?php else: ?>
<p>Данных не найдено</p>
<?php endif; ?>