<h1><?php echo $data['page_title']; ?></h1>

<div class='btn_group btn_group_odns'>
<a href="?year=<?php echo $data['last_year']; ?>" class='left_btn_group left_btn_group_odns'>Назад</a><span class="center_btn_group"><?php echo $data['current_year']; ?></span><a href="?year=<?php echo $data['next_year']; ?>" class='right_btn_group right_btn_group_odns'>Вперёд</a>
</div>

<?php if (count($data['odns']) > 0 ): ?>
<div id="tableWrap">
<table id="table">
    <tr>
        <th></th>
        
        <th>Вид начисления</th>
        <th>Единицы измерения</th>
        <th>Реальное потребление общедомовых приборов учёта</th>
        <th>Расчётное потребление общедомовых приборов учёта</th>
        <th>Потребление квартирных приборов учёта по счётчикам</th>
        <th>Потребление по нормативу</th>
        <th>Суммарное потребление квартирных приборов учёта</th>
        <th>Разница в потреблении, отнесённая на ОДН</th>
        <th>Общая площадь дома</th>
        <th>Коэффициент распределения</th>
        <th>Площадь квартиры</th>
        <th>Объём коммунального ресурса, отнесённый на площадь квартиры</th>
    </tr>
    <tr class='newBlock'>
        <th></th>
        
        <th>[1]</th>
        <th>[2]</th>
        <th>[3]</th>
        <th>[4]</th>
        <th>[5]</th>
        <th>[6]</th>
        <th>[7]</th>
        <th>[8]</th>
        <th>[9]</th>
        <th>[10]</th>
        <th>[11]</th>
        <th>[12]</th>
    </tr>
<?php foreach($data['odns'] as $megaRow):
    
    $transactions_count = count($megaRow['transactions']);
    $i = 1;
    
    foreach ($megaRow['transactions'] as $row): ?>
    
    <tr<?php if($i == 1) echo " class='newBlock'" ?>>
        <?php if($i == 1): ?>
        <td rowspan="<?php echo $transactions_count; ?>" class="td-center"><em><?php echo $megaRow['period']; ?></em></td>
        <?php endif; ?>
        
        <td><?php echo $row['type']; ?></td>
        <td><?php echo $row['units']; ?></td>
        <td><?php echo $row['real_overall_consumption']; ?></td>
        <td><?php echo $row['estimated_overall_consumption']; ?></td>
        <td><?php echo $row['counters_consumption']; ?></td>
        <td><?php echo $row['norm_consumption']; ?></td>
        <td><?php echo $row['sum_consumption']; ?></td>
        <td><?php echo $row['diff']; ?></td>
        <td><?php echo $row['total_square']; ?></td>
        <td><?php echo $row['distribution_coefficient']; ?></td>
        <td><?php echo $row['flat_square']; ?></td>
        <td><?php echo $row['odn_value']; ?></td>
        <?php $i++; ?>
    </tr>
    
    <?php endforeach; ?>
    
<?php endforeach; ?>

</table>
</div>

<p class="legend"><strong>[1]</strong> - Вид начисления</p>
<p class="legend"><strong>[2]</strong> - Единицы измерения</p>
<p class="legend"><strong>[3]</strong> - Реальное потребление общедомовых приборов учёта</p>
<p class="legend"><strong>[4]</strong> - Расчётное потребление общедомовых приборов учёта</p>
<p class="legend"><strong>[5]</strong> - Потребление квартирных приборов учёта по счётчикам</p>
<p class="legend"><strong>[6]</strong> - Потребление по нормативу</p>
<p class="legend"><strong>[7] = [5] + [6]</strong> - Суммарное потребление квартирных приборов учёта</p>
<p class="legend"><strong>[8] = [4] - [7]</strong> - Разница в потреблении, отнесённая на ОДН</p>
<p class="legend"><strong>[9]</strong> - Общая площадь дома</p>
<p class="legend"><strong>[10] = [8] / [9]</strong> - Коэффициент распределения</p>
<p class="legend"><strong>[11]</strong> - Площадь квартиры</p>
<p class="legend"><strong>[12] = [10] x [11]</strong> - Объём коммунального ресурса, отнесённый на площадь квартиры</p>

<?php else: ?>
<p>Данных не найдено</p>
<?php endif; ?>