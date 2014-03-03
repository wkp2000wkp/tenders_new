<form id="seachForm" method="get" action='<?php echo URL_DOMAIN; ?>/index.php' style='margin-bottom: 0px;margin-top: 0px;'>
<input name='r' value='<?php echo $_GET['r'];?>' type='hidden'>
<input name='actionfor' value='search' type='hidden'>
<table id='search_table' style='width:850px;padding-top: 0px; padding-bottom: 0px;'>
	<tbody>
		<tr class="newRow even" >
			<th><span><span style='width:80px;'>开标记录-公司名称</span></th>
			<td ><input type="text" value="<?php echo $ajax_data['bid_company'];?>" name="searchajax[bid_company]"></td>
		</tr>
		<tr>
			<th><span style='width:80px;'>时间区域：</th>
			<td ><input type="text"
				value="<?php echo $data['from_creat_time'];?>" name="search[from_creat_time]" id='from_creat_time'></td>
			<th><span style='width:80px;'>--至--</th>
			<td ><input type="text" value="<?php echo $data['to_creat_time'];?>" name="search[to_creat_time]" id='to_creat_time'></td>
			<td > <input type="button" id="searchcompany" value="搜索公司" style='width:100px'> </td>
			
		</tr>
		<tr>
			<th><span style='width:80px;'>&nbsp;</th>
			<td >
				公司搜索结果
				<br>
				<select multiple="multiple"  id="uncompanyTable" name="uncompanyTable" style="width:245px;" size="8">
				</select>
				<br>
				<input type="button" id="btn1" value=">>" />
				<input type="button" id="btn2" value="全>>" />
			</td>
			<th><span style='width:80px;'>&nbsp;</th>
			<td >
				已选择公司
				<br>
				<select multiple="multiple"  id="companyTable" name="companyTable" style="width:245px;" size="8">
				<?php 
// 				if($data['bid_company']):
// 					$optionList = @explode(SelectConstent::EXPLODE_STRING,$data['bid_company']);
// 					foreach($optionList as $option):
// 						if($option and $option != MY_COMPANY) echo "<option value='{$option}' >{$option}</option>";
// 					endforeach;
// 					endif;
					?>
				</select>
				<input type="hidden" name="search[bid_company]" value="<?php echo $data['bid_company'];?>" />
				<br>
				<input type="button" id="btn3" value="<<" />
				<input type="button" id="btn4" value="<<全" />
				
			</td>
			<td > <input type="button"  id="searchtongji" value="搜索" style='width:100px'> </td>
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

	$("#searchtongji").click(function(){
		var search_bid_company = "";
		$("#companyTable option").each(function(){
			search_bid_company =  $(this).val()+"<?php echo SelectConstent::EXPLODE_STRING;?>"+search_bid_company;	
		});
		$("input[name='search[bid_company]']").val(search_bid_company);
		$("#seachForm").attr('method','get');
		$("#seachForm").attr('action','<?php echo URL_DOMAIN; ?>/index.php');
		$("#seachForm").submit();
	});
	
	$("#searchcompany").click(function(){
			$.ajax({ 
				type: "get", 
				//dataType: "JSON",
				dataType: "html",
				url: "index.php?r=tongji/getkbc&action=show&", 
				data: "searchajax[bid_company]="+encodeURI($("input[name='searchajax[bid_company]']").val())+"&searchajax[from_creat_time]="+$("input[name='search[from_creat_time]']").val()+"&searchajax[to_creat_time]="+$("input[name='search[to_creat_time]']").val(), 
				success: function(msg){ $("#uncompanyTable").html(msg); }
			});
	});
	
	$("#btn2").click(function(){
					$("#uncompanyTable option").each(function(){
						option = "<option value='"+$(this).val()+"'>"+$(this).text()+"</option>";					
						$("#companyTable").append(option);
						$(this).remove();
					});
				});	
	$("#btn4").click(function(){
					$("#companyTable option").each(function(){
						option = "<option value='"+$(this).val()+"'>"+$(this).text()+"</option>";					
						$("#uncompanyTable").append(option);
						$(this).remove();
					});
				});	

	$("#btn1").click(function(){
					$("#uncompanyTable option:selected").each(function(){
						option = "<option value='"+$(this).val()+"'>"+$(this).text()+"</option>";					
						$("#companyTable").append(option);
						$(this).remove();
					});
				});	
	
	$("#btn3").click(function(){
					$("#companyTable option:selected").each(function(){
						option = "<option value='"+$(this).val()+"'>"+$(this).text()+"</option>";					
						$("#uncompanyTable").append(option);
						$(this).remove();
					});
				});	

	$("#uncompanyTable").dblclick(function(){
					$("#uncompanyTable option:selected").each(function(){
						option = "<option value='"+$(this).val()+"'>"+$(this).text()+"</option>";					
						$("#companyTable").append(option);
						$(this).remove();
					});
				});	
	
	$("#companyTable").dblclick(function(){
					$("#companyTable option:selected").each(function(){
						option = "<option value='"+$(this).val()+"'>"+$(this).text()+"</option>";					
						$("#uncompanyTable").append(option);
						$(this).remove();
					});
				});	
	});

</script>


