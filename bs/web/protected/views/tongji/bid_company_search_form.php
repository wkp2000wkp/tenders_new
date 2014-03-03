<form id="seachForm" method="get" action='<?php echo URL_DOMAIN; ?>/index.php' style='margin-bottom: 0px;margin-top: 0px;'>
<input name='r' value='<?php echo $_GET['r'];?>' type='hidden' id='r'>
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
			<td > <input type="button" id="searchtongjicompany" value="搜索（按厂家）" style='width:100px'> </td>
			<td > <input type="button" id="searchtongjitpye" value="搜索（按类型）" style='width:100px'> </td>
		</tr>
	</tbody>
</table>
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

	$("#searchtongjicompany").click(function(){
		$("#r").val('tongji/bcl');
		$("#seachForm").attr('method','get');
		$("#seachForm").attr('action','<?php echo URL_DOMAIN; ?>/index.php');
		$("#seachForm").submit();
	});
	$("#searchtongjitpye").click(function(){
		$("#r").val('tongji/ttl');
		$("#seachForm").attr('method','get');
		$("#seachForm").attr('action','<?php echo URL_DOMAIN; ?>/index.php');
		$("#seachForm").submit();
	});


});
</script>