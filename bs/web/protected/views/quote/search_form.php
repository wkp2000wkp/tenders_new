<form id="seachForm" method="get" action='<?php echo URL_DOMAIN; ?>/index.php' style='margin-bottom: 0px;margin-top: 0px;'>
<input name='r' value='<?php echo $_GET['r'];?>' type='hidden'>
<input name='time' value='<?php echo $history;?>' type='hidden'>
<script>
function showSearchTable(){
	$('#search_table').show();
}
function hiddenSearchTable(){
	$('#search_table').hide();
}
</script>
<table id='search_table' style='width:1250px;padding-top: 0px; padding-bottom: 0px;'>
	<tbody>
		<tr class="newRow even" >
			<th><span><span style='width:80px;'>单位名称</span></th>
			<td ><input type="text"
				value="<?php echo $data['company_name'];?>" name="search[company_name]"></td>
			<th><span style='width:80px;'>业务员</th>
			<td ><input type="text"
				value="<?php echo $data['slesman'];?>" name="search[slesman]"></td>
			<th><span style='width:80px;'>标书管理员</th>
			<td ><input type="text"
				value="<?php echo $data['tender_manager'];?>" name="search[tender_manager]"></td>
			<th><span style='width:80px;'>规格型号</th>
			<td ><input type="text"
				value="<?php echo $data['specification'];?>" name="search[specification]"></td>
			<th><span style='width:80px;'>变压器类型</th>
			<td ><select
				name="search[transformer_type]">
				<option value='0'>请选择</option>
				<?php foreach(SelectConstent::getSelectTransformerType() as $option):?>
				<option value="<?php echo $option;?>" <?php if ($option==$data['transformer_type']) echo 'selected';?>><?php echo $option;?></option>
				<?php endforeach;?>
			</select></td>
		</tr>
		<tr>
			<th><span style='width:80px;'>日期：</th>
			<td ><input type="text"
				value="<?php echo $data['from_time'];?>" name="search[from_time]" id='from_time'></td>
			<th><span style='width:80px;'>--至--</th>
			<td ><input type="text" value="<?php echo $data['to_time'];?>" name="search[to_time]" id='to_time'></td>
		</tr>
		<tr>
				<?php if($back_up_list):?>
			<th><span style='width:80px;'>备份列表</th>
			<td ><select
				name="search[bu_id]">
					<?php foreach($back_up_list as $option):?>
						<option value="<?php echo $option['id'];?>" <?php if ($option['id']==$data['bu_id']) echo 'selected';?>><?php echo $option['name'];?></option>
					<?php endforeach;?>
				<?php else:?>
				<input type='hidden' value='<?php echo $data['bu_id'];?>' name='search[bu_id]'>
				<?php endif;?>
			</select></td>
			<th><span style='width:80px;'>&nbsp;</th>
			<td > <input type="submit" value="搜索" style='width:100px'> </td>
		</tr>
	</tbody>
</table>
</form>
<script type="text/javascript">
	$(function() {
		var dates = $('#from_time, #to_time').datepicker({
			changeYear: true,
			changeMonth: true,
			onSelect: function(selectedDate) {
				var option = this.id == "from_time" ? "minDate" : "maxDate";
				var instance = $(this).data("datepicker");
				var date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
				dates.not(this).datepicker("option", option, date);
			}
		});
	});
	</script>


