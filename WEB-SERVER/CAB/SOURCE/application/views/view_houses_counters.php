<h1><?php echo $data['page_title']; ?></h1>

<?php if (count($data['counters']) > 0 ): ?>

<table>
    <tr>
        <th>Вид начисления</th>
        <th>Модель</th>
        <th>Дата начала работы</th>
        <th>Коэффициент трансформации</th>
        <th>Последнее показание</th>
        <th></th>
    </tr>
    
    <?php foreach ($data['counters'] as $counter):
    
    extract($counter);
    echo "<tr>";
    echo "<td>$service</td>";
    echo "<td>$model</td>";
    echo "<td>$start_date</td>";
    echo "<td>$transformation_coefficient</td>";
    echo "<td class='btn_group",($number_of_tariffs > 1) ? " mode_block" : (($last_report_date != "Данных не найдено") ? " mode-box" : ""),"'><span class='left_btn_group'>$last_report_date</span><span class='right_btn_group'>$last_report_value</span></td>";
    echo "<td><a href='/account/houses_counters_history?counter=$id' class='btn_blue'>История показаний</a></td>";
    echo "</tr>";
    
    endforeach; ?>
    
</table>

<?php else: ?>
<p>Данных не найдено</p>
<?php endif; ?>