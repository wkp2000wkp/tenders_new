	文件名：<?php
echo $flie_name;
?>
<br />
文件大小:  <?php
echo $flie_size;
?>  Kb
<br />
<br />


<form name='kaiBiaoForm' method='post' action='index.php?r=operation/kbf'>
<input type='hidden' name='tb_id' value='<?php echo $tb_id;?>'> 
<?php
foreach ($header_table_list as $key => $table) :
    ?>
<table border=1>
<tr>
	<td><?php echo $header_table_list[$key][0];?></td>
	<td><?php echo $header_table_list[$key][1];?></td>
	<td><?php echo $header_table_list[$key][2];?></td>
</tr>
<?php
foreach ($show_table_list[$key] as $rowKey => $rowVal) :
    ?>
<tr>
	<td><input type='text' value='<?php echo $rowVal[0];?>' name='record[<?php echo $key;?>][list][<?php echo $rowKey;?>][]'></td>
	<td><input type='text' value='<?php echo $rowVal[1];?>' name='record[<?php echo $key;?>][list][<?php echo $rowKey;?>][bidder]'></td>
	<td><input type='text' value='<?php echo $rowVal[2];?>' name='record[<?php echo $key;?>][list][<?php echo $rowKey;?>][price]'></td>
</tr>
<?php
endforeach
;
?>
</table>
<?php
endforeach
;
?>
<input type='submit' value='保存'>
</form>