


  <LINK  type="text/css" rel="stylesheet" href="css/tablegear.css" />
<form class="newRow" id="addNewRow_tgTable" method="post" onsubmit="javascript:return checkSubmit();" action='<?php echo URL_DOMAIN;?>/index.php?r=operation/izb&action=<?php echo $action;?>&zb_id=<?php echo $data['id'];?>'>
<h3>招标项目</h3> 
<table style='width: 750px;'>
	<thead>
		<tr>
		</tr>
	</thead>
	<tbody>
		<tr class="newRow even" id="newDataRow_tgTable">
			<th>项目名称</th>
			<td class="editable"><span></span> <textarea id='data_project_name' name='data[project_name]'><?php echo $data['project_name'];?></textarea><span style='color:red;'>*</span></td>
		</tr>
		<tr>
			<th>招标代理</th>
			<td class="editable"><span></span> <input type="text"
				value="<?php echo $data['bidding_agent'];?>" name="data[bidding_agent]"></td>
		</tr>
		<tr>
			<th>招标人</th>
			<td class="editable"><span></span> <input type="text"
				value="<?php echo $data['tenderer'];?>" name="data[tenderer]"><span style='color:red;'>*</span></td>
		</tr>
		<tr>
			<th>规格型号</th>
			<td class="editable"><span></span> <textarea id='data_specification' name='data[specification]'><?php echo $data['specification'];?></textarea><span style='color:red;'>*</span></td>
		</tr>
		<tr>
			<th>变压器类型</th>
			<td class="editable"><span></span> <select id='data_transformer_type'
				name="data[transformer_type]">
				<?php if($action =='insert'):?>
				<option value=''>请选择</option>
				<?php endif;?>
				<?php foreach(SelectConstent::getSelectTransformerType() as $option):?>
				<option value="<?php echo $option;?>" <?php if ($option==$data['transformer_type']) echo 'selected';?>><?php echo $option;?></option>
				<?php endforeach;?>
			</select><span style='color:red;'>*</span></td>
		</tr>
		<tr>
			<th>数量</th>
			<td class="editable"><span></span> 
			<textarea name='data[number]'><?php echo $data['number'];?></textarea></td>
		</tr>
		<tr>
			<th>业务员</th>
			<td class="editable"><span></span> <input type="text"
				value="<?php echo $data['slesman'];?>" name="data[slesman]"><span style='color:red;'>*</span></td>
		</tr>
		<tr>
			<th>开标日期</th>
			<td class="editable"><input type="text" value="<?php echo $data['end_time'];?>" name="data[end_time]"></td>
		</tr>
		<tr>
			<th>标书管理员</th>
			<td class="editable"><span></span> <input type="text"
				value="<?php echo $data['tender_manager'];?>" name="data[tender_manager]"><span style='color:red;'>*</span></td>
		</tr>
		<tr>
			<th>所属区域</th>
			<td class="editable"><span></span>
			<select id='data_respective_regions' 
				name="data[respective_regions]"> 
				<?php if($action =='insert'):?>
				<option value=''>请选择</option>
				<?php endif;?>
				<?php foreach(SelectConstent::getSelectRespectiveRegions() as $option):?>
				<option value="<?php echo $option;?>" <?php if ($option==$data['respective_regions']) echo 'selected';?>><?php echo $option;?></option>
				<?php endforeach;?>
			</select><span style='color:red;'>*</span>
				</td>
		</tr>
		<tr>
			<th>所属省份</th>
			<td class="editable"><span></span> <input type="text"
				value="<?php echo $data['respective_provinces'];?>" name="data[respective_provinces]"><span style='color:red;'>*</span></td>
		</tr>
		<tr>
			<th>标书费(元)</th>
			<td class="editable"><span></span> <input type="text"
				value="<?php echo $data['tender_fee'];?>" name="data[tender_fee]"><span style='color:red;'>*</span></td>
		</tr>
		<tr>
			<th>投标保证金(万元)</th>
			<td class="editable"><span></span> <input type="text"
				value="<?php echo $data['bid_bond'];?>" name="data[bid_bond]"></td>
		</tr>
		<tr>
			<th>投标有效期(天)</th>
			<td class="editable"><span></span> <input type="text"
				value="<?php echo $data['bid_valid'];?>" name="data[bid_valid]"></td>
		</tr>
		<tr>
			<th>中标服务费(%)</th>
			<td class="editable"><span></span>
			<table ><tr><td><select id='data_bid_fee' 
				name="data[bid_fee]" style="margin-left: -5px;"> 
				<?php if(!$data['bid_fee']):?>
				<option value=''>请选择</option>
				<?php endif;?>
				<?php foreach(SelectConstent::getSelectBidFee() as $option):?>
				<option value="<?php echo $option;?>" <?php if ($option==$data['bid_fee']) echo 'selected';?>><?php echo $option;?></option>
				<?php endforeach;?>
			</select><span style='color:red;'>*</span><input type="text" value="<?php echo $data['bid_fee_value'];?>" name="data[bid_fee_value]" ><span style='color:red;'></span></td></tr></table>
			</td>
		</tr>
		<tr>
			<th>就位费</th>
			<td class="editable"><span></span> 
			
			<select id='data_place_fee' 
				name="data[place_fee]"> 
				<?php if(!$data['place_fee']):?>
				<option value=''>请选择</option>
				<?php endif;?>
				<?php foreach(SelectConstent::getSelectPlaceFee() as $option):?>
				<option value="<?php echo $option;?>" <?php if ($option==$data['place_fee']) echo 'selected';?>><?php echo $option;?></option>
				<?php endforeach;?>
			</select><span style='color:red;'>*</span></td>
		</tr>
		<tr>
			<th>设联会费用</th>
			<td class="editable"><span></span> 
			<select id='data_skill_fee' 
				name="data[skill_fee]"> 
				<?php if(!$data['skill_fee']):?>
				<option value=''>请选择</option>
				<?php endif;?>
				<?php foreach(SelectConstent::getSelectSkillFee() as $option):?>
				<option value="<?php echo $option;?>" <?php if ($option==$data['skill_fee']) echo 'selected';?>><?php echo $option;?></option>
				<?php endforeach;?>
			</select><span style='color:red;'>*</span></td>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<td class="editable"> <input type="submit" value="提交" class='button_css'> </td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th>&nbsp;</th>
		<td style='text-align:right;'><a href='<?php echo URL_DOMAIN;?>/index.php?r=backend/zb'  class='ui-state-default ui-corner-all'>返回招标项目列表>></a>  </td>
		</tr>
	</tfoot>
</table>
</form>
<script>
var bid_fee_free = "<?php echo SelectConstent::BID_FEE_FREE; ?>";
var bid_fee_qita = "<?php echo SelectConstent::BID_FEE_QITA; ?>";
function checkSubmit(){
//	项目信息、招标人、规格型号、业务员、标书管理员
	if($("#data_project_name").val().length == 0){
		$("#data_project_name").next().html('必填项！');
		return false;
	}else{
		$("#data_project_name").next().html('');
	}
	if($("input[name='data[tenderer]']").val().length == 0){
		$("input[name='data[tenderer]']").next().html('必填项！');
		return false;
	}else{
		$("input[name='data[tenderer]']").next().html('');
	}
	if($("#data_specification").val().length == 0){
		$("#data_specification").next().html('必填项！');
		return false;
	}else{
		$("#data_specification").next().html('');
	}
	if($("#data_transformer_type").val().length == 0){
		$("#data_transformer_type").next().html('必填项！');
		return false;
	}else{
		$("#data_transformer_type").next().html('');
	}
	if($("#data_respective_regions").val().length == 0){
		$("#data_respective_regions").next().html('必填项！');
		return false;
	}else{
		$("#data_respective_regions").next().html('');
	}
	if($("input[name='data[slesman]']").val().length == 0){
		$("input[name='data[slesman]']").next().html('必填项！');
		return false;
	}else{
		$("input[name='data[slesman]']").next().html('');
	}
	if($("input[name='data[tender_manager]']").val().length == 0){
		$("input[name='data[tender_manager]']").next().html('必填项！');
		return false;
	}else{
		$("input[name='data[tender_manager]']").next().html('');
	}
	
	if($("input[name='data[tender_fee]']").val().length == 0){
		$("input[name='data[tender_fee]']").next().html('必填项！');
		return false;
	}else{
		$("input[name='data[tender_fee]']").next().html('');
	}
	
	if($("#data_bid_fee").val().length == 0){
		$("#data_bid_fee").next().html('必填项！');
		return false;
	}else{
		$("#data_bid_fee").next().html('');
	}
	if($("#data_bid_fee").children('option:selected').val() == bid_fee_free && $("input[name='data[bid_fee_value]']").val().length == 0){
		$("input[name='data[bid_fee_value]']").next().html('必填项！');
		return false;
	}else{
		$("input[name='data[bid_fee_value]']").next().html('');
	}
	if($("#data_bid_fee").children('option:selected').val() == bid_fee_qita && $("input[name='data[bid_fee_value]']").val().length == 0){
		$("input[name='data[bid_fee_value]']").next().html('必填项！');
		return false;
	}else{
		$("input[name='data[bid_fee_value]']").next().html('');
	}
	if($("#data_place_fee").val().length == 0){
		$("#data_place_fee").next().html('必填项！');
		return false;
	}else{
		$("#data_place_fee").next().html('');
	}
	if($("#data_skill_fee").val().length == 0){
		$("#data_skill_fee").next().html('必填项！');
		return false;
	}else{
		$("#data_skill_fee").next().html('');
	}
	
	return true;
}

</script>

<script>
$(function() {
	
	$("input[name='data[end_time]']").datepicker({
		changeYear: true,
		changeMonth: true});
	$("#data_bid_fee").change(function(){
		if($(this).children('option:selected').val() == bid_fee_free || $(this).children('option:selected').val() == bid_fee_qita){
			$("input[name='data[bid_fee_value]']").show();
		}else{
			$("input[name='data[bid_fee_value]']").hide();
			$("input[name='data[bid_fee_value]']").val('');
		}
	});
	if($("#data_bid_fee").children('option:selected').val() == bid_fee_free || $("#data_bid_fee").children('option:selected').val() == bid_fee_qita){
		$("input[name='data[bid_fee_value]']").show();
	}else{
		$("input[name='data[bid_fee_value]']").hide();
	}
});
</script>