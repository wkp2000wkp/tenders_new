<link type="text/css" rel="stylesheet" href="css/tablegear.css" />
<?php echo $search_html;?>

<?php if($table_list['info']):?>
<input type="button" id="showKaiBiao" value="中标记录导出" style='width:100px'>
<table style='width:100%;' border=1>
<tr>
<th colspan=10>主要竞争对手中标情况(金额/中标包数/投标包数)</th>
</tr>
<tr>
<th width=10%>公司名称</th>
<?php foreach(SelectConstent::getSelectKaiBiaoTransformerType() as $name):?>
<th width=10%><?php echo $name;?></th>
<?php endforeach;?>
<th width=10%>总中标金额</th>
</tr>
<?php if($table_list['sort']):?>
	<?php foreach($table_list['sort'] as $company=>$price):?>
	<?php $list=$table_list['info'][$company];?>
	<?php if($list['all_bid_number']==0) continue;?>
	<tr>
	<td><?php echo $company;?></td>
	<?php foreach(SelectConstent::getSelectKaiBiaoTransformerType() as $name):?>
	<td><?php if($list[$name]['bid_price']) echo $list[$name]['bid_price'].'('.$list[$name]['bid_number'].'/'.$list[$name]['number'].')';?></td>
	<?php endforeach;?>
	<td><?php if($list['all_price']) echo $list['all_price'].'('.$list['all_bid_number'].'/'.$list['all_number'].')';?></td>
	</tr>
	<?php endforeach;?>
<?php endif;?>
</table>
<?php endif;?>
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
$(document).ready(function() {
	$("#showKaiBiao").click(function(){
		$('#dialog_sort_box').dialog({width: 460,height: 260});
	});
	$("#exporttongji").click(function(){
		$("#seachForm").attr('method','post');
		$("#seachForm").attr('action','<?php echo URL_DOMAIN; ?>/index.php?r=tongji/ertjzbkb&sort='+$(':radio[name=exprot_sort][checked]').val());
		$("#seachForm").submit();
	});
});
</script>