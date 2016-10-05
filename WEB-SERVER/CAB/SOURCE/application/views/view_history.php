<h1><?php echo $data['page_title']; ?></h1>

<?php if (count($data['counter']) > 0 ): ?>

<div class="info"> <?php echo $data['counter']['service']; ?> <?php if(!empty($data['counter']['serial_number'])) echo '&nbsp; &#124; &nbsp;'; ?> <?php echo $data['counter']['serial_number']; ?></div>

<?php if (count($data['counter']['values']) > 0 ): ?>

<table>
    <tr>
        <th>Дата</th>
        <th>Значение</th>
    </tr>
    
    <?php foreach ($data['counter']['values'] as $row):
    
    extract($row);
    echo "<tr>";
    echo "<td",($mode == 'site') ? " class='mode_site'" : "",">$date</td>";
    echo "<td",($mode == 'site') ? " class='mode_site'" : "",">$value",($mode == 'site') ? " &nbsp;<a href='/account/history?counter={$data['counter']['ID']}&deleteValue={$ID}'><img src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEwAACxMBAJqcGAAAAQdJREFUOI1jYBjygBGXxDs7kyzG/4zfYPz/DAz/hQ6fXkjIAEZDE5PEf/8Y/4Wx/vP79JfxHUyCk5GRe/1fhp1MTP9/nD9zZgVMnAVZt5aWFjcjAzML0/9fO9f8YtiPbhsTAwPD/38s/shiKAZcu3bti4GxqRADI0v+//+MPzE9/E+UgQHVYBZ0Nf8ZGG8w/P054wAfp5Lg4RPn3tuZGAoeOnP+vZ2Jof03ht/Mfxk40F2FA/zVg5jIqI9CY/EWRYB2BvxlYPqMjUYHGAnJwNjYi/Efy/1//348x1DMymrC9O/fy3Pnzl2GiWHEAj8Pz66PX764MTCxq2Pa9+/LuXPnruBy9cAAACjlWcmj7TbxAAAAAElFTkSuQmCC'></a>" : "","</td>";
    echo "</tr>";
    
    endforeach; ?>
    
</table>

<?php else: ?>
<p>Данных не найдено</p>
<?php endif; ?>

<?php else: ?>
<p>Данных не найдено</p>
<?php endif; ?>