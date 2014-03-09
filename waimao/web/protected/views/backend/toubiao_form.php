<LINK type="text/css" rel="stylesheet" href="css/tablegear.css" />
<form class="newRow" id="addNewRow_tgTable" method="post" onsubmit="javascript:return checkSubmit();" action='<?php echo URL_DOMAIN;?>/index.php?r=operation/otb&action=update&id=<?php echo $data['id'];?>&referer=<?php echo urlencode($referer); ?>'>
<h3>投标信息</h3>
<table style='width: 850px;'>
	<tbody>
		<tr>
			<th class="sortable"><span>项目名称</span> </th>
			<td class="editable td_css_project_name">
			<textarea id='data_project_name' name='data[project_name]'><?php echo $data['project_name'];?></textarea><span style='color:red;'>*</span></td>
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
			<td class="editable td_css_transformer_type"><select id='data_transformer_type'
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
			<select id='data_respective_regions' 
				name="data[respective_regions]"> 
				<?php foreach(SelectConstent::getSelectRespectiveRegions() as $option):?>
				<option value="<?php echo $option;?>" <?php if ($option==$data['respective_regions']) echo 'selected';?>><?php echo $option;?></option>
				<?php endforeach;?>
			</select>
			</td>
		</tr>
		<tr>
			<th>所属国家</th>
			<td class="editable"><span></span> <input type="text"
				value="<?php echo $data['respective_provinces'];?>" name="data[respective_provinces]"><span style='color:red;'>*</span></td>
		</tr>
		<tr>
			<th class="sortable"><span>标书费(多币种)</span> </th>
			<td class="editable td_css_tender_fee"><input
				 value="<?php echo $data['tender_fee'];?>"  type="text" name="data[tender_fee]"><span style='color:red;'>*</span></td>
		</tr>
		<tr>
			<th>标书费币种</th>
			<td class="editable"><span></span>
			<table ><tr><td><select id='data_currency' class='currency'
				name="data[currency]" style="margin-left: -5px;"> 
				<?php if(!$data['currency']):?>
				<option value=''>请选择</option>
				<?php endif;?>
				<?php foreach(SelectConstent::getSelectCurrency() as $option):?>
				<option value="<?php echo $option;?>" <?php if ($option==$data['currency']) echo 'selected';?>><?php echo $option;?></option>
				<?php endforeach;?>
			</select><span style='color:red;'>*</span><input type="text" size=10 value="<?php echo $data['other_currency'];?>" name="data[other_currency]" ><span style='color:red;'></span></td></tr></table>
			</td>
		</tr>
		<tr>
			<th class="sortable"><span>投标保证金(多币种)</span> </th>
			<td class="editable td_css_bid_bond"><input type="text"
				value="<?php echo $data['bid_bond'];?>" name="data[bid_bond]"></td>
		</tr>
		<tr>
			<th>投标保证金币种</th>
			<td class="editable"><span></span>
			<table ><tr><td><select id='data_currency_bid_bond' class='currency'
				name="data[currency_bid_bond]" style="margin-left: -5px;"> 
				<?php if(!$data['currency_bid_bond']):?>
				<option value=''>请选择</option>
				<?php endif;?>
				<?php foreach(SelectConstent::getSelectCurrency() as $option):?>
				<option value="<?php echo $option;?>" <?php if ($option==$data['currency_bid_bond']) echo 'selected';?>><?php echo $option;?></option>
				<?php endforeach;?>
			</select><input type="text" size=10 value="<?php echo $data['other_currency_bid_bond'];?>" name="data[other_currency_bid_bond]" ><span style='color:red;'></span></td></tr></table>
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
			<th class="sortable"><span>三变投标总价(万元)</span> 
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
		<tr>
			<th>代理费</th>
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
			<th>代理费币种</th>
			<td class="editable"><span></span>
			<table ><tr><td><select id='data_currency_bid_fee' class='currency'
				name="data[currency_bid_fee]" style="margin-left: -5px;"> 
				<?php if(!$data['currency_bid_fee']):?>
				<option value=''>请选择</option>
				<?php endif;?>
				<?php foreach(SelectConstent::getSelectCurrency() as $option):?>
				<option value="<?php echo $option;?>" <?php if ($option==$data['currency_bid_fee']) echo 'selected';?>><?php echo $option;?></option>
				<?php endforeach;?>
			</select><span style='color:red;'>*</span><input type="text" value="<?php echo $data['other_currency_bid_fee'];?>" name="data[other_currency_bid_fee]" ><span style='color:red;'></span></td></tr></table>
			</td>
		</tr>
		<tr>
			<th>代理费种类</th>
			<td class="editable"><span></span>
			<table ><tr><td><select id='data_bid_fee_sort' 
				name="data[bid_fee_sort]" style="margin-left: -5px;"> 
				<?php if(!$data['bid_fee_sort']):?>
				<option value=''>请选择</option>
				<?php endif;?>
				<?php foreach(SelectConstent::getSelectBidFeeSort() as $option):?>
				<option value="<?php echo $option;?>" <?php if ($option==$data['bid_fee_sort']) echo 'selected';?>><?php echo $option;?></option>
				<?php endforeach;?>
			</select><span style='color:red;'>*</span><input type="text" value="<?php echo $data['bid_fee_sort_other'];?>" name="data[bid_fee_sort_other]" ><span style='color:red;'></span></td></tr></table>
			</td>
		</tr>
		<tr>
			<th>投标服务费</th>
			<td class="editable"><span></span> 
			<input type="text"
				value="<?php echo $data['skill_fee'];?>" name="data[skill_fee]">
			</td>
		</tr>
		<tr>
			<th>备注</th>
			<td class="editable"><span></span> <textarea name='data[remark]'><?php echo $data['remark'];?></textarea></td>
		</tr>
		<tr class="newRow even" id="newDataRow_tgTable">
			<th>&nbsp;</th>
			<th><input type="submit" value="提交" class='button_css'></th>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th>&nbsp;</th>
		<td style='text-align:right;'><a href='<?php echo $referer; ?>'  class='ui-state-default ui-corner-all'>返回>></a> </td>
		</tr>
	</tfoot>
</table>
</form>
<script>
var bid_fee_free = "<?php echo SelectConstent::BID_FEE_FREE; ?>";
var bid_fee_qita = "<?php echo SelectConstent::BID_FEE_QITA; ?>";
</script>
<script type="text/javascript" src="js/tenderscheck.js"></script>