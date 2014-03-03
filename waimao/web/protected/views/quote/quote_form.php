	<form id="quoteForm" >
	<fieldset>
		<label for="email">单位名称（项目名称）</label>
		<input type='hidden' value='<?php echo $action;?>' name ='action'>
		<input type='hidden' value='<?php echo $data['id'];?>' name ='id'>
		<input value="<?php echo $data['company_name'];?>"  type="text" name="data[company_name]" id='company_name'  class="text ui-widget-content ui-corner-all" >
		<label for="name">日期</label>
		<input value="<?php $show_date = ($data['end_time']) ?  $data['end_time'] : date("Y-m-d") ; echo $show_date;?>"  type="text" name="data[end_time]" id='end_time' class="text ui-widget-content ui-corner-all" >
		<label for="email">变压器类型</label>
		<select name="data[transformer_type]" >
	        <?php foreach(SelectConstent::getSelectTransformerType() as $option):?>
				<option value="<?php echo $option;?>" <?php if ($option==$data['transformer_type']) echo 'selected';?>><?php echo $option;?></option>
	        <?php endforeach;?>
		</select>
		<label for="name">规格型号</label>
		<textarea name='data[specification]' id='specification'><?php echo $data['specification'];?></textarea>
		<label for="name">数量</label>
		<textarea name='data[number]' id='number'><?php echo $data['number'];?></textarea>
		<label for="email">业务员</label>
		<input value="<?php echo $data['slesman'];?>"  type="text" name="data[slesman]" id='slesman' class="text ui-widget-content ui-corner-all" >
		<label for="email">标书管理员</label>
		<input value="<?php echo $data['tender_manager'];?>"  type="text" name="data[tender_manager]" id='tender_manager' class="text ui-widget-content ui-corner-all" >
		<label for="name">备注</label>
		<textarea name='data[remark]' id='remark'><?php echo $data['remark'];?></textarea>
	</fieldset>
	</form>
<script type="text/javascript">
	$(function() {
		var company_name = $("#company_name"),
		end_time = $("#end_time"),
		transformer_type = $("#transformer_type"),
		slesman = $("#slesman"),
		tender_manager = $("#tender_manager"),
		specification = $("#specification"),
		number = $("#number"),
		remark = $("#remark"),
		allFields = $([]).add(number).add(remark).add(tender_manager).add(slesman).add(transformer_type).add(end_time).add(company_name).add(specification),
		tips = $(".validateTips");

	function updateTips(t) {
		tips
			.text(t)
			.addClass('ui-state-highlight');
		setTimeout(function() {
			tips.removeClass('ui-state-highlight', 1500);
		}, 500);
	}
	$("#dialog-form").dialog({
			autoOpen: false,
			height: 530,
			width: 550,
			modal: true,
			buttons: {
				'提交': function() {
					var bValid = true;
					allFields.removeClass('ui-state-error');
					
					bValid = bValid && checkNone(company_name);
					bValid = bValid && checkNone(end_time);
					bValid = bValid && checkNone(slesman);
					bValid = bValid && checkNone(tender_manager);
					bValid = bValid && checkNone(specification);
					
					if (bValid) {
						$.post("<?php echo URL_DOMAIN;?>/index.php?r=quote/option", $("#quoteForm").serialize(),function(data){
							alert(data);
							
							
						});
						$(this).dialog('close');
					}
				},
				'取消': function() {
					$(this).dialog('close');
				}
			},
			close: function() {
				allFields.val('').removeClass('ui-state-error');
			}
		});
		
		function checkNone(o) {

			if ( o.val().length == 0 ) {
				o.addClass('ui-state-error');
				updateTips("请填写内容");
				return false;
			} else {
				return true;
			}

		}

			
	});
	</script>
	
	<script type="text/javascript">
	$(function() {
		var dates = $('#end_time').datepicker({
			changeYear: true,
			changeMonth: true
		});
	});
	</script>
