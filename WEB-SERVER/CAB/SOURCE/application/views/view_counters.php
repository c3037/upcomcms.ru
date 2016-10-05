<h1><?php echo $data['page_title']; ?></h1>

<a href="/account/submit" class="btn_blue btn_default">Передать текущие показания</a>

<?php if (count($data['counters']) > 0 ): ?>

<table>
    <tr>
        <th>Услуга</th>
        <th>Серийный номер</th>
        <th>Дата поверки</th>
        <th>Дата начала работы</th>
        <th>Последнее показание</th>
        <th></th>
    </tr>
    
    <?php foreach ($data['counters'] as $counter):
    
    extract($counter);
    echo "<tr>";
    echo "<td>$service</td>";
    echo "<td>$serial_number</td>";
    echo "<td>$check_date</td>";
    echo "<td>$start_date</td>";
    echo "<td class='btn_group",($last_report_mode == 'site') ? " mode_site" : "",($number_of_tariffs > 1) ? " mode_block" : (($last_report_date != "Данных не найдено") ? " mode-box" : ""),"'><span class='left_btn_group'>$last_report_date</span><span class='right_btn_group'>$last_report_value</span></td>";
    echo "<td><a href='/account/history?counter=$id' class='btn_blue'>История показаний</a></td>";
    echo "</tr>";
    
    endforeach; ?>
    
</table>

<?php else: ?>
<p>Данных не найдено</p>
<?php endif; ?>