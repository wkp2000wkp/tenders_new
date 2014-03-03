<link type="text/css" rel="stylesheet" href="css/tablegear.css" />
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

<div id='show_table'>
<table border=1 width='200px' style ="table-layout:fixed;word-break:break-all; word-wrap:break-word;">
<tr>
<td width="10%"><input type='checkbox' id='checkbox_all'>全选</td>
<td width="200px" >投标记录编号</td>
<td width="20%">开标厂家(记录数)</td>
</tr>

<?php foreach($table_list as $bid_company=>$list):?>
<tr>
<td><input type='checkbox' name='data[tb_id][]' value='<?php echo join($list['tb_id'],SelectConstent::EXPLODE_STRING); ?>'></td>
<td><?php echo join($list['tb_show_id'],SelectConstent::EXPLODE_STRING);?></td>
<td><?php echo $bid_company;?>(<?php echo $list['kb_count']; ?>)</td>
</tr>
<?php endforeach;?>
</table>
</div>


<div id="dialog_sort_box" title="替换" style="display:none;">
查找内容：<input type='text' name='form[find]' >
<br>
<br>
替换为：<input type='text' name='form[replace]' >
<br>
<br>
<br>
<a href='#' id='startReplace' class='ui-state-default ui-corner-all'>开始替换</a> 
<a href='#' id='emptyReplace' class='ui-state-default ui-corner-all'>清空</a> 
</div>
</form>
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
		$("#seachForm").attr('action','<?php echo URL_DOMAIN; ?>/index.php?r=<?php echo $_GET['r'];?>&form[find]='+$("input[name='form[find]']").val()+'&form[replace]='+$("input[name='form[replace]']").val());
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
		$('#dialog_sort_box').dialog({width: 460,height: 400});
	});
});
</script>


<script>
	$(document).ready(function() {	
	$("#checkbox_all").change(function(){
		if($("#checkbox_all").attr("checked")=="checked")
			$("input[name='data[kb_r_id][]']").attr("checked",true);
		else
			$("input[name='data[kb_r_id][]']").attr("checked",false);
			
	});
});

</script>
