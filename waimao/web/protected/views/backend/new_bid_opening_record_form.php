<LINK type="text/css" rel="stylesheet" href="css/tablegear.css" />
<form class="newRow" id="addNewRow_tgTable" method="post"
	action='<?php echo URL_DOMAIN;?>/index.php?r=operation/okbr&action=<?php echo $action;?>&id=<?php echo $tou_biao_id;?>&referer=<?php echo urlencode($referer); ?>'
	onsubmit="javascript:return checkSubmit();"  >
<input type='hidden' name='data[tb_id]' value='<?php echo $tou_biao_id;?>'>
<?php if($kaibiao_list['kaibiao_result']['id']):?>
	<input type='hidden' name='data[id]' value='<?php echo $kaibiao_list['kaibiao_result']['id'];?>'>
<?php endif;?>
<br>
<h3>开标记录（<?php echo $toubiao_info['project_name']; ?>）</h3>
<table style='width: 500px'>

	<tr>
		<th class="sortable">变压器类型</th>
		<td class="editable"><select name="data[transformer_type]" id="data_transformer_type">
				<?php if($action == 'insert'):?>
				<option value=''>请选择</option>
				<?php endif;?>
				<?php foreach(SelectConstent::getSelectKaiBiaoTransformerType() as $option):?>
				<option value="<?php echo $option;?>"
				<?php if ($option==$kaibiao_list['kaibiao_result']['transformer_type']) echo 'selected';?>><?php echo $option;?></option>
				<?php endforeach;?>
			</select><span style='color:red;'>*</span></td>
	</tr>
	<tr>
		<th class="sortable">规格型号</th>
		<td><textarea id='data_specification' name='data[specification]'><?php echo $kaibiao_list['kaibiao_result']['specification'];?></textarea></td>
	</tr>
	<tr>
		<th class="sortable">数量</th>
		<td><textarea name='data[number]'><?php echo $kaibiao_list['kaibiao_result']['number'];?></textarea></td>
	</tr>
	<tr>
		<th class="sortable">核价单保留费率</th>
		<td><input style="width: 150px;" type='text' name='data[baoliu]' value='<?php echo $kaibiao_list['kaibiao_result']['baoliu'];?>'></td>
	</tr>
	<tr>
		<th class="sortable">按价格表下浮点数</th>
		<td><input style="width: 150px;" type='text' name='data[xiafu]' value='<?php echo $kaibiao_list['kaibiao_result']['xiafu'];?>'></td>
	</tr>
	<tr>
		<th class="sortable">基准价</th>
		<td><input style="width: 150px;" type='text' name='data[ji_zhun_price]' value='<?php echo $kaibiao_list['kaibiao_result']['ji_zhun_price'];?>'></td>
	</tr>
	<tr>
		<th class="sortable">中标厂家</th>
		<td><?php echo $bid_record['bid_company'];?></td>
	</tr>
	<tr>
		<th class="sortable">币种</th>
		<td class="editable"><select name="data[currency_ji_zhun_price]" id="data_currency_ji_zhun_price">
				<?php if(!$data['currency_ji_zhun_price'] || !$toubiao_info['currency']):?>
				<option value=''>请选择<?php echo $action;?></option>
				<?php endif;?>
				<?php foreach(SelectConstent::getSelectCurrency() as $option):?>
				<?php if ($action == 'insert'):?>
					<option value="<?php echo $option;?>" <?php if ($option==$toubiao_info['currency']) echo 'selected';?>><?php echo $option;?></option>
				<?php else:?>
					<option value="<?php echo $option;?>" <?php if ($option==$kaibiao_list['kaibiao_result']['currency_ji_zhun_price']) echo 'selected';?>><?php echo $option;?></option>
				<?php endif;?>
				<?php endforeach;?>
			</select><input type="text" size=10 value="<?php echo  ($action == 'insert') ? $toubiao_info['other_currency'] : $kaibiao_list['kaibiao_result']['other_currency_ji_zhun_price'] ;?>" name="data[other_currency_ji_zhun_price]" ></td>
	</tr>
</table>
<br>
<table border=0 style='width: 500px'>
	<tr>
		<td colspan=2>开标记录</td>
		<td><input class="button_css" id="insert_record" type='button'
			value='+新增'></td>
	</tr>

	<tr class='odd'>

		<td>是否中标</td>
		<td>公司名称</td>
		<td>价格（万元）</td>
		<td>操作</td>

	</tr>
	
	<?php if($action == 'insert'): ?>
	<tr>
		<input type='hidden' name='insertlist[1][tb_id]'
			value='<?php echo $tou_biao_id;?>'>
		<td><input type='radio' style="width: 30px;" value='<?php echo KAIBIAO_BID_STR;?>1'
			name="bid" class="bid_radio" tag="0" ></td>
		<td><input type='text' style="width: 150px;" value="<?php echo MY_COMPANY;?>"
			name='insertlist[1][bid_company]' readonly></td>
		<td><input type='text' style="width: 150px;" value="" name='insertlist[1][bid_price]' id='my_company_price'></td>

	</tr>
	
	<?php else: ?>
		<?php 
		if($kaibiao_list['kaibiao_record']):
		foreach($kaibiao_list['kaibiao_record'] as $krtmp => $record): ?>
		<tr id='update_tr_<?php echo $record['id'];?>'>
		<input type='hidden'
			name='updatelist[<?php echo $record['id'];?>][tb_id]'
			value='<?php echo $record['tb_id'];?>'>
		<td><input style="width: 30px;" type='radio'  class="bid_radio"  <?php $checked_tag = ($record['bid'] == BID_STR)? 'tag="1"' : 'tag="0"';?>
			value='<?php echo KAIBIAO_BID_UPDATE_STR;?><?php echo $record['id'];?>'
			name=bid <?php if ($record['bid'] == BID_STR) echo 'checked '.$checked_tag;?>></td>
		<td><input style="width: 150px;" type='text' size=10 value="<?php echo $record['bid_company'];?>"
			name='updatelist[<?php echo $record['id'];?>][bid_company]' <?php if($record['bid_company']== MY_COMPANY && $krtmp == 0 ) echo 'readonly';?>></td>
		<td><input style="width: 150px;" type='text' size=10 value="<?php echo $record['bid_price'];?>"
			name='updatelist[<?php echo $record['id'];?>][bid_price]' <?php if($record['bid_company']== MY_COMPANY && $krtmp == 0 ) echo "id='my_company_price'";?>></td>
		<td>
		 <?php if($record['bid_company']!= MY_COMPANY || $krtmp != 0 ): ?>
			<a href="" onclick="javascript: delete_kaibiao(<?php echo $record['id'];?>);return false;" >删除</a>
		<?php endif;?>
		</td>
	</tr>
		<?php endforeach; 
		endif;
		?>
	<?php endif; ?>
<tr id='insert_tr'>
		<td></td>
		<td><input class="button_css" type='submit' value='保存'></td>
		<td><input class="button_css"  id='button_show_piliang' type='button' style='width:80px;' value='批量添加'></td>
	</tr>
</tr>
</table>
<br>
<!--<a href='<?php echo $referer; ?>' class='ui-state-default ui-corner-all'>返回>></a>-->
</form>
<script>
var bid_fee_qita = "<?php echo SelectConstent::BID_FEE_QITA; ?>";
</script>
<script>
 	var insert_tr_id=2;
 	var kaibiao_str='<?php echo KAIBIAO_BID_STR;?>';
 	var tou_biao_id='<?php echo $tou_biao_id;?>';
 	var insert_tr_html_id = '';
  $(document).ready(function() {
    $("#insert_record").click(function(){
    	insert_record_click();
    });
    
    $("#button_show_piliang").click(function(){
        if($("#tr_piliang").length > 0) return ;
    	$("#insert_tr").after("<tr id='tr_piliang' colspan=4><td>公司名称与价格需要对称</td><td><textarea id='company_piliang' style='width:160px;height:100px;'></textarea></td><td><textarea id='price_piliang' style='width:160px;height:100px;'></textarea></td><td><input class='button_css' type='button' id='button_piliang' value='提交'></td>");
    });
    
    $("#button_piliang").die().live("click",function(){
		
    	var xxx='';
    	var yyy='';
    	if($("#company_piliang").val()){
	    	xxx=$("#company_piliang").val().split("\n");
	    	yyy=$("#price_piliang").val().split("\n");
	    	for(var i=0;i<xxx.length;i++){
		    	insert_record_click(xxx[i],yyy[i]);
			}

    	}

    	
    	$("#tr_piliang").remove();
    });

    $(".bid_radio").die().live("click",function(){
    	var nm=$(this).attr("name");
        $(":radio[name="+nm+"]:not(:checked)").attr("tag",0);
        if($(this).attr("tag")==1){$(this).attr("checked",false);$(this).attr("tag",0); }
        else{$(this).attr("tag",1);}  
  	});
  
    $("#data_currency_ji_zhun_price").change(function(){
		showChangeAndDefaultSelect("data_currency_ji_zhun_price","other_currency_ji_zhun_price",bid_fee_qita);
	});
		showChangeAndDefaultSelect("data_currency_ji_zhun_price","other_currency_ji_zhun_price",bid_fee_qita);
	
  });
  function showChangeAndDefaultSelect(selectid,textname,keystring){

		if($("#"+selectid).children('option:selected').val() == keystring ){
				$("input[name='data["+textname+"]']").show();
			}else{
				$("input[name='data["+textname+"]']").hide();
				$("input[name='data["+textname+"]']").val('');
			}
		
	}
  function insert_record_click(company,price){
	  if(!company){
		  company='';
	  }
	  if(!price){
		  price='';
	  }
	  if(company=='<?php echo MY_COMPANY; ?>'){
		  $("#my_company_price").val(price);
			return ;
	  }else{
	  	insert_tr_html_id = "insert_tr_" + insert_tr_id;
	  	$("#insert_tr").before("<tr id='"+ insert_tr_html_id +"' class='odd'><input type='hidden' name='insertlist[" + insert_tr_id + "][tb_id]' value='"+tou_biao_id+"'><td><input style='width: 30px;' type='radio'  class='bid_radio' tag='0' value='"+kaibiao_str + insert_tr_id + "' name='bid'></td><td><input  style='width: 150px;' type='text' value='"+company+"' name='insertlist[" + insert_tr_id + "][bid_company]'></td><td><input style='width: 150px;' type='text' value='"+price+"' name='insertlist[" + insert_tr_id + "][bid_price]'></td><td><a href='javascript:delete_insert(&quot;"+insert_tr_html_id+"&quot;);' >删除</a></td></tr>");
	  }
	  insert_tr_id ++;
  }
  
  function delete_insert(id){
	  $("#"+id).remove();
  }
  function delete_kaibiao(id){
	  $("#update_tr_"+id).append("<input type='text' name='updatelist["+id+"][is_deleted]' value='1'>");
	  $("#update_tr_"+id).hide();
	  return false;
  }
  function checkSubmit(){
	  if($("#data_transformer_type").val().length == 0){
			$("#data_transformer_type").next().html('必填项！');
			return false;
		}else{
			$("#data_transformer_type").next().html('');
		}
	  return true;
	}
  </script>