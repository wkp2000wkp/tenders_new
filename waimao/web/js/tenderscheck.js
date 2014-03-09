function checkText(textname,returnkey){
	if($("input[name='data["+textname+"]']").val().length == 0){
		$("input[name='data["+textname+"]']").next().html('必填项！');
		return false;
	}else{
		$("input[name='data["+textname+"]']").next().html('');
	}
	return returnkey;
}
function checkTextArea(textname,returnkey){
	if($("#data_"+textname).val().length == 0){
		$("#data_"+textname).next().html('必填项！');
		return false;
	}else{
		$("#data_"+textname).next().html('');
	}
	return returnkey;
}
function checkSelected(textname,returnkey){
	if($("#data_"+textname).val().length == 0){
		$("#data_"+textname).next().html('必填项！');
		return false;
	}else{
		$("#data_"+textname).next().html('');
	}
	return returnkey;
}

function checkSelecteTextBox(selectid,textboxid,keystring,returnkey){
	if($("#"+selectid).val().length == 0){
		$("#"+selectid).next().html('必填项！');
		return false;
	}else{
		$("#"+selectid).next().html('');
	}
	
	if($("#"+selectid).children('option:selected').val() == keystring && $("input[name='data["+textboxid+"]']").val().length == 0){
		$("input[name='data["+textboxid+"]']").next().html('必填项！');
		return false;
	}else{
		$("input[name='data["+textboxid+"]']").next().html('');
	}
	return returnkey;
}


function showChangeAndDefaultSelect(selectid,textname,keystring){

	if($("#"+selectid).children('option:selected').val() == keystring ){
			$("input[name='data["+textname+"]']").show();
		}else{
			$("input[name='data["+textname+"]']").hide();
			$("input[name='data["+textname+"]']").val('');
		}
	
}

function checkSubmit(){
//	项目信息、招标人、规格型号、业务员、标书管理员
	var returnkey = true;
	returnkey = checkTextArea("project_name",returnkey);
	returnkey = checkText("tenderer",returnkey);
	returnkey = checkTextArea("specification",returnkey);
	returnkey = checkSelected("transformer_type",returnkey);
	returnkey = checkSelected("respective_regions",returnkey);
	returnkey = checkText("respective_provinces",returnkey);
	returnkey = checkText("slesman",returnkey);
	returnkey = checkText("tender_manager",returnkey);
	returnkey = checkText("tender_fee",returnkey);
	returnkey = checkSelecteTextBox("data_currency","other_currency",bid_fee_qita,returnkey);
	returnkey = checkSelecteTextBox("data_currency_bid_fee","other_currency_bid_fee",bid_fee_qita,returnkey);
	if($("#data_bid_fee").children('option:selected').val() == bid_fee_free)
		returnkey = checkSelecteTextBox("data_bid_fee","bid_fee_value",bid_fee_free,returnkey);
	else
		returnkey = checkSelecteTextBox("data_bid_fee","bid_fee_value",bid_fee_qita,returnkey);
	returnkey = checkSelecteTextBox("data_bid_fee_sort","bid_fee_sort_other",bid_fee_qita,returnkey);
	return returnkey ;
}


$(function() {
	$("input[name='data[end_time]']").datepicker({
		changeYear: true,
		changeMonth: true});
	
	$("#data_bid_fee").change(function(){
		if($("#data_bid_fee").children('option:selected').val() == bid_fee_free)
			showChangeAndDefaultSelect("data_bid_fee","bid_fee_value",bid_fee_free);
		else
			showChangeAndDefaultSelect("data_bid_fee","bid_fee_value",bid_fee_qita);
	});
		if($("#data_bid_fee").children('option:selected').val() == bid_fee_free)
			showChangeAndDefaultSelect("data_bid_fee","bid_fee_value",bid_fee_free);
		else
			showChangeAndDefaultSelect("data_bid_fee","bid_fee_value",bid_fee_qita);
		
	$("#data_bid_fee_sort").change(function(){
		showChangeAndDefaultSelect("data_bid_fee_sort","bid_fee_sort_other",bid_fee_qita);
	});
		showChangeAndDefaultSelect("data_bid_fee_sort","bid_fee_sort_other",bid_fee_qita);
		
	$("#data_currency").change(function(){
		showChangeAndDefaultSelect("data_currency","other_currency",bid_fee_qita);
		$(".currency").val($("#data_currency").val());
		showChangeAndDefaultSelect("data_currency_bid_bond","other_currency_bid_bond",bid_fee_qita);
		showChangeAndDefaultSelect("data_currency_bid_fee","other_currency_bid_fee",bid_fee_qita);
	});
		showChangeAndDefaultSelect("data_currency","other_currency",bid_fee_qita);
	$("#data_currency_bid_bond").change(function(){
		showChangeAndDefaultSelect("data_currency_bid_bond","other_currency_bid_bond",bid_fee_qita);
	});
	showChangeAndDefaultSelect("data_currency_bid_bond","other_currency_bid_bond",bid_fee_qita);
	$("#data_currency_bid_fee").change(function(){
		showChangeAndDefaultSelect("data_currency_bid_fee","other_currency_bid_fee",bid_fee_qita);
	});
	showChangeAndDefaultSelect("data_currency_bid_fee","other_currency_bid_fee",bid_fee_qita);
});
