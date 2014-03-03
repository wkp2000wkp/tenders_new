<input type='button' value='查询导出结果' id='exportTongJi' >
<input type='button' value='开标结果导出' id='showKaiBiao' >
<table style='width:1000px;'><tr>
<?php 
$k=1;
foreach( $company_list as $company_name => $list): 

?>	

<td>
<table  style='width:500px;padding-top: 0px; padding-bottom: 0px;' border=1>
		<tr>
			<td rowspan=2>产品类</td>
			<td colspan=2>报价总计（万元）</td>
			<td rowspan=2>相差点数</td>
		</tr>
		<tr>
			<td >我公司</td>
			<td ><?php echo $company_name ?></td>
		</tr>
		<?php 
		$all_my_price = $all_company_price = $all_xiangcha =0;
			foreach(SelectConstent::getSelectKaiBiaoTransformerType() as $type ):
				$all_my_price +=$list[$type]['my_price'];
				$all_company_price +=$list[$type]['company_price'];
				
				echo "<tr>";
				echo "<td >{$type}</td>";
				echo "<td >{$list[$type]['my_price']}</td>";
				echo "<td >{$list[$type]['company_price']}</td>";
				echo "<td >{$list[$type]['xiangcha']}</td>";
				echo "</tr>";
			endforeach;	
			$all_xiangcha = round((($all_company_price/$all_my_price)-1)*100,1)."%";
			echo "<tr>";
			echo "<td >总计</td>";
			echo "<td >{$all_my_price}</td>";
			echo "<td >{$all_company_price}</td>";
			echo "<td >{$all_xiangcha}</td>";
			echo "</tr>";
			
			?>	
	
	
</table>
</td>

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
<a href='#' id='exportKaiBiao' class='ui-state-default ui-corner-all'>开标结果导出</a> 
</div>
<?php 
if($k % 2 == 0 ) echo "</tr><tr>";
$k++;
endforeach;
?>
</tr></table>
<script  language="javascript" type="text/javascript">

$(document).ready(function() {	
	$("#exportTongJi").click(function(){
		$("#seachForm").attr('method','post');
		$("#seachForm").attr('action','<?php echo URL_DOMAIN; ?>/index.php?r=tongji/ertj');
		$("#seachForm").submit();
	});
	$("#showKaiBiao").click(function(){
		$('#dialog_sort_box').dialog({width: 460,height: 260});
	});
	$("#exportKaiBiao").click(function(){
		$("#seachForm").attr('method','post');
		$("#seachForm").attr('action','<?php echo URL_DOMAIN; ?>/index.php?r=tongji/ertjdbkb&action=duibi&sort='+$(':radio[name=exprot_sort][checked]').val());
		$("#seachForm").submit();
		$('#dialog_sort_box').dialog( "close" );
	});

	
});
</script>
