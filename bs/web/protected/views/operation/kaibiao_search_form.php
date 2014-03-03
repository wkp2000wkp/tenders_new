<form id="seachForm" method="get" action='<?php echo URL_DOMAIN; ?>/index.php' style='margin-bottom: 0px;margin-top: 0px;'>
<input name='r' value='<?php echo $_GET['r'];?>' type='hidden'>
<input name='action' value='search' type='hidden'>
<table id='search_table' style='width:850px;padding-top: 0px; padding-bottom: 0px;'>
	<tbody>
		<tr class="newRow even" >
		
				<th><span style='width:80px;'>备份列表</th>
			<td ><select
				name="search[bu_id]">
				<option value=1>未备份信息</option>
					<?php foreach($back_up_list as $option):?>
						<option value="<?php echo $option['id'];?>" <?php if ($option['id']==$data['bu_id']) echo 'selected';?>><?php echo $option['name'];?></option>
					<?php endforeach;?>
						</select></td><td></td>
				<th><span style='width:80px;'>投标记录编号</th>
			<td ><input type="text"
				value="<?php echo $data['tb_show_id'];?>" name="search[tb_show_id]"></td>
				
		</tr>
		<tr>
			<th><span><span style='width:80px;'>开标记录-公司名称</span></th>
			<td ><input type="text" value="<?php echo $data['bid_company'];?>" name="search[bid_company]"></td>
		</tr>
		<tr>
			<th><span style='width:80px;'>时间区域：</th>
			<td ><input type="text"
				value="<?php echo $data['from_creat_time'];?>" name="search[from_creat_time]" id='from_creat_time'></td>
			<th><span style='width:80px;'>--至--</th>
			<td ><input type="text" value="<?php echo $data['to_creat_time'];?>" name="search[to_creat_time]" id='to_creat_time'></td>
			<td > <input type="button" id="searchtongji" value="搜索" style='width:100px'> </td>
			<td > <input type="button" id="showKaiBiao" value="替换" style='width:100px'> </td>
		</tr>
	</tbody>
</table>
</form>
<div id="dialog_sort_box" title="替换" style="display:none;">
查找内容：<input type='text' name='data[find]'>
<br>
<br>
替换为：<input type='text' name='data[replace]'>
<br>
<br>
替换范围：
<input type='radio'>已选择记录<input type='radio'>全部替换
<br>
<br>
<br>
<a href='#' id='startReplace' class='ui-state-default ui-corner-all'>开始替换</a> 
<a href='#' id='emptyReplace' class='ui-state-default ui-corner-all'>清空</a> 
</div>

<script  language="javascript" type="text/javascript">
$(document).ready(function() {	

	var dates = $('#from_creat_time, #to_creat_time').datepicker({
		changeYear: true,
		changeMonth: true,
		onSelect: function(selectedDate) {
			var option = this.id == "from_creat_time" ? "minDate" : "maxDate";
			var instance = $(this).data("datepicker");
			var date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
			dates.not(this).datepicker("option", option, date);
		}
	});

	$("#searchtongji").click(function(){
		$("#seachForm").attr('method','get');
		$("#seachForm").attr('action','<?php echo URL_DOMAIN; ?>/index.php');
		$("#seachForm").submit();
	});

	$("#exporttongji").click(function(){
		$("#seachForm").attr('method','post');
		$("#seachForm").attr('action','<?php echo URL_DOMAIN; ?>/index.php?r=tongji/ertjkb');
		$("#seachForm").submit();
	});
	
	$("#startReplace").click(function(){
		$("#seachForm").attr('method','post');
		$("input[name='action']").val("replace");
		$("#seachForm").attr('action','<?php echo URL_DOMAIN; ?>/index.php?r='.<?php echo $_GET['r'];?>);
		$("#seachForm").submit();
	});
	
	$("#emptyReplace").click(function(){
		$("input[name='data[find]']").val("");
		$("input[name='data[replace]']").val("");
	});
});
</script>



<script  language="javascript" type="text/javascript">

$(document).ready(function() {	
	$("#showKaiBiao").click(function(){
		$('#dialog_sort_box').dialog({width: 460,height: 260});
	});
});
</script>


