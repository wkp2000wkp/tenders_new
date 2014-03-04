
<LINK type="text/css" rel="stylesheet" href="css/tablegear.css" />
<form class="newRow" id="addNewRow_tgTable" method="post" onsubmit="javascript:return checkSubmit();" action='<?php echo URL_DOMAIN; ?>/index.php?r=operation/otb&action=update&tb_id=<?php echo $data['id'];?>'>
<h3>投标信息</h3>
<table style='width: 550px;'>
	<tbody>
		<tr>
			<th class="sortable"><span>项目名称</span> </th>
			<td class="editable td_css_project_name">
			<textarea id='data_project_name' name='data[project_name]'><?php echo $data['project_name'];?></textarea>
			<span style='color:red;'>*</span></td>
		</tr>
		<tr>
			<th class="sortable"><span>招标代理</span> </th>
			<td class="editable td_css_bidding_agent"><input
				 value="<?php echo $data['bidding_agent'];?>"  type="text" name="data[bidding_agent]"></td>
		</tr>
		<tr>
			<th class="sortable"><span>招标人</span> </th>
			<td class="editable td_css_tenderer"><input type="text"
				value="<?php echo $data['tenderer'];?>" name="data[tenderer]"><span style='color:red;'>*</span></td>
		</tr>
		<tr>
			<th>规格型号</th>
			<td class="editable"><span></span> <textarea id='data_specification' name='data[specification]'><?php echo $data['specification'];?></textarea><span style='color:red;'>*</span></td>
		</tr>
		<tr>
			<th class="sortable"><span>变压器类型</span> </th>
			<td class="editable td_css_transformer_type"><select
				name="data[transformer_type]">
				<?php foreach(SelectConstent::getSelectTransformerType() as $option):?>
				<option value="<?php echo $option;?>" <?php if ($option==$data['transformer_type']) echo 'selected';?>><?php echo $option;?></option>
				<?php endforeach;?>
			</select></td>
		</tr>
		<tr>
			<th class="sortable"><span>数量</span> </th>
			<td class="editable td_css_number">
			<textarea name='data[number]'><?php echo $data['number'];?></textarea></td>
		</tr>
		<tr>
			<th class="sortable"><span>业务员</span> </th>
			<td class="editable td_css_slesman"><input type="text"
				value="<?php echo $data['slesman'];?>" name="data[slesman]"><span style='color:red;'>*</span></td>
		</tr>
		<tr>
			<th class="sortable"><span>开标日期</span> </th>
			<td class="editable td_css_end_time"><input type="text"
				value="<?php echo $data['end_time'];?>" name="data[end_time]"></td>
		</tr>
		<tr>
			<th class="sortable"><span>标书管理员</span> </th>
			<td class="editable td_css_tender_manager"><input
				 value="<?php echo $data['tender_manager'];?>"  type="text" name="data[tender_manager]"><span style='color:red;'>*</span></td>
		</tr>
		<tr>
			<th class="sortable"><span>所属区域</span> </th>
			<td class="editable td_css_respective_regions">
			<select
				name="data[respective_regions]">
				<?php foreach(SelectConstent::getSelectRespectiveRegions() as $option):?>
				<option value="<?php echo $option;?>" <?php if ($option==$data['respective_regions']) echo 'selected';?>><?php echo $option;?></option>
				<?php endforeach;?>
			</select><span style='color:red;'>*</span>
			
			</td>
		</tr>
		<tr>
			<th>所属国家</th>
			<td class="editable"><span></span> <input type="text"
				value="<?php echo $data['respective_provinces'];?>" name="data[respective_provinces]"></td>
		</tr>
		<tr>
			<th class="sortable"><span>标书费(多币种)</span> </th>
			<td class="editable td_css_tender_fee"><input
				 value="<?php echo $data['tender_fee'];?>"  type="text" name="data[tender_fee]"><span style='color:red;'>*</span></td>
		</tr>
		<tr>
			<th class="sortable"><span>投标保证金(多币种)</span> </th>
			<td class="editable td_css_bid_bond"><input type="text"
				value="<?php echo $data['bid_bond'];?>" name="data[bid_bond]"></td>
		</tr>
		<tr>
			<<th class="sortable"><span>币种</span> </th>
			<td class="editable"><span></span>
			<table ><tr><td><select id='data_currency' 
				name="data[currency]" style="margin-left: -5px;"> 
				<?php if(!$data['currency']):?>
				<option value=''>请选择</option>
				<?php endif;?>
				<?php foreach(SelectConstent::getSelectCurrency() as $option):?>
				<option value="<?php echo $option;?>" <?php if ($option==$data['currency']) echo 'selected';?>><?php echo $option;?></option>
				<?php endforeach;?>
			</select><span style='color:red;'>*</span><input type="text" value="<?php echo $data['other_currency'];?>" name="data[other_currency]" ><span style='color:red;'></span></td></tr></table>
			</td>
		</tr>
		<tr>
			<th class="sortable"><span>投标有效期(天)</span> </th>
			<td class="editable td_css_bid_valid"><input type="text"
				value="<?php echo $data['bid_valid'];?>" name="data[bid_valid]"></td>
		</tr>
		
		<tr>
			<th class="sortable"><span>是否中标</span> </th>
			<td class="editable"><select name="data[bid]">
			    <?php foreach(SelectConstent::getSelectBid() as $option):?>
				<option value="<?php echo $option;?>" <?php if ($option==$data['bid']) echo 'selected';?>><?php echo $option;?></option>
				<?php endforeach;?>
			</select></td>
		</tr>
		<tr>
			<th class="sortable"><span>三变投标总报价(万元)</span> 
			</th>
			<td class="editable"><input type="text"
				value="<?php echo $data['san_bid_all_price'];?>" name="data[san_bid_all_price]"></td>
		</tr>
		<tr>
			<th class="sortable"><span>三变中标总价(万元)</span> 
			</th>
			<td class="editable"><input type="text"
				value="<?php echo $data['san_bid_price'];?>" name="data[san_bid_price]"></td>
		</tr>
		<tr>
			<th class="sortable"><span>中标厂家</span> </th>
			<td class="editable"><input type="text"
				value="<?php echo $data['manufacturers'];?>" name="data[manufacturers]"></td>
		</tr>
		<tr>
			<th class="sortable"><span>是否反馈</span> </th>
			<td class="editable"><select name="data[feedback]">
			    <?php foreach(SelectConstent::getSelectYesOrNo() as $option):?>
				<option value="<?php echo $option;?>" <?php if ($option==$data['feedback']) echo 'selected';?>><?php echo $option;?></option>
				<?php endforeach;?>
			</select></td>
		</tr>
		<tr>
			<th class="sortable"><span>是否报销</span> </th>
			<td class="editable"><select name="data[reimbursement]">
			    <?php foreach(SelectConstent::getSelectYesOrNo() as $option):?>
				<option value="<?php echo $option;?>" <?php if ($option==$data['reimbursement']) echo 'selected';?>><?php echo $option;?></option>
				<?php endforeach;?>
			</select></td>
		</tr>
		<tr class="newRow even" id="newDataRow_tgTable">
			<th>&nbsp;</th>
			<th><input type="submit" value="提交" class='button_css'></th>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th>&nbsp;</th>
		<td style='text-align:right;'><a href='<?php echo URL_DOMAIN;?>/index.php?r=backend/tb'  class='ui-state-default ui-corner-all'>返回投标项目列表>></a> </td>
		</tr>
	</tfoot>
</table>
</form>

<script>
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
	return true;
}
</script>
<script>
$(function() {
	$("input[name='data[end_time]']").datepicker({
		changeYear: true,
		changeMonth: true});
});
</script>