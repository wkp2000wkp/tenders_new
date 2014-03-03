<link type="text/css" rel="stylesheet" href="css/tablegear.css" />
<?php echo $search_html;?>
<?php if($table_list['info']):?>
<input type="button" id="showKaiBiao" value="中标记录导出" style='width:100px'>
<div id='show_table'>
<table border=0 cellpadding=0 cellspacing=0>
<tr><th colspan=9>各类变压器竞争对手中标金额(中标频次)-Top20</th></tr>
<tr>
<?php foreach($tpye_list as $type):?>
<td width=11%><?php echo $type;?></td>
<?php endforeach;?>
</tr>
<tr valign="top">
<?php foreach($tpye_list as $type):?>
<td>
<?php if(!is_array($table_list['sort'][$type])) continue;?>
<table border=1 cellpadding=0 cellspacing=0 style="padding:0;">
<?php arsort($table_list['sort'][$type],SORT_NUMERIC);?>
<?php $list=array_slice($table_list['sort'][$type],0,20);?>
<?php foreach($list as $bid_company=>$bid_price):?>
<tr><td><?php echo $table_list['info'][$type][$bid_company]['bid_company'];?><br><?php echo $table_list['info'][$type][$bid_company]['bid_price'];?>(<?php echo $table_list['info'][$type][$bid_company]['bid_count'];?>)</td></tr>
<?php endforeach;?>
</table>
</td>
<?php endforeach;?>
</tr>
</table>
</div>
<div id="dialog_box"></div>
<div id="dialog_sort_box" title="请选中导出结果的排序" style="display:none;">
选择排序：
<?php 
	foreach($export_sort_list['list'] as $sort_key=>$sort_value):
		$checked = ($sort_key == $export_sort_list['checked']) ? "checked" : "";
		echo "<input type='radio' name='exprot_sort' value='{$sort_key}' {$checked} >{$sort_value}";
	endforeach;
?>
<br>
<br>

<br>
<br>
<a href='#' id='exporttongji' class='ui-state-default ui-corner-all'>开标结果导出</a> 
</div>
<script>
$("#showKaiBiao").click(function(){
	$('#dialog_sort_box').dialog({width: 460,height: 260});
});
$(document).ready(function() {
	$("#exporttongji").click(function(){
		$("#seachForm").attr('method','post');
		$("#seachForm").attr('action','<?php echo URL_DOMAIN; ?>/index.php?r=tongji/ertjzbkb&sort='+$(':radio[name=exprot_sort][checked]').val());
		$("#seachForm").submit();
	});
});
</script>
<?php endif;?>