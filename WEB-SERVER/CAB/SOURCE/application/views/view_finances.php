<h1><?php echo $data['page_title']; ?></h1>

<div class='btn_group btn_group_finances'>
<a href="?year=<?php echo $data['last_year']; ?>" class='left_btn_group left_btn_group_finances'>Назад</a><span class="center_btn_group"><?php echo $data['current_year']; ?></span><a href="?year=<?php echo $data['next_year']; ?>" class='right_btn_group right_btn_group_finances'>Вперёд</a>
</div>

<?php if (count($data['finances']) > 0 ): ?>

<div id="tableWrap">
<table id="table">
    <tr>
        <th></th>
        <th>Дата</th>
        <th>Начислено, руб.</th>
        <th>Пени, руб.</th>
        <th>Перерасчёт, руб.</th>
        <th>Оплачено, руб.</th>
        <th>К оплате, руб.</th>
        <th></th>
    </tr>
<?php foreach($data['finances'] as $megaRow):
    
    $transactions_count = count($megaRow['transactions']);
    $i = 1;
    
    foreach ($megaRow['transactions'] as $row): ?>
    
    <tr<?php if($i == 1) echo " class='newBlock'" ?>>
        <?php if($i == 1): ?>
        <td rowspan="<?php echo $transactions_count; ?>" class="td-center"><em><?php echo $megaRow['period']; ?></em></td>
        <?php endif; ?>
        
        <td><?php echo $row['date']; ?></td> 
        <td><?php echo $row['accrued']; ?></td> 
        <td><?php echo $row['penalty']; ?></td> 
        <td><?php echo $row['recalculation']; ?></td> 
        <td><?php echo $row['paid']; ?></td> 
        <td><?php echo $row['saldo']; ?></td> 
        
        <?php if($i == 1): ?>
        <td rowspan="<?php echo $transactions_count; ?>" class="td-center">
        
        <?php if(isset($megaRow['receipt']) and !empty($megaRow['receipt'])): ?>
        <a href='/account/files?receipt=<?php echo $megaRow['receipt']; ?>' class='btn_blue' target="_blank">Квитанция</a>
        <?php endif; ?>
        
        </td>
        <?php endif; $i++; ?>
    </tr>
    
    <?php endforeach; ?>
    
<?php endforeach; ?>

</table>
</div>

<?php else: ?>
<p>Данных не найдено</p>
<?php endif; ?>