
<LINK type="text/css" rel="stylesheet" href="css/tablegear.css" />
<form class="newRow" id="addNewRow_tgTable" method="post" onsubmit="javascript:return checkSubmit();" action='<?php echo $form_info['action'];?>'>
<?php if($data['id']): ?>
<input type='hidden' value='<?php echo $data['id'];?>' name='id'>
<?php endif;?>
<h3><?php echo $form_info['title'];?></h3>
<table style='width: 550px;'>
	<tbody>
	<?php 
	$table_html = '';
	$check_html = '';
	foreach( $form_info['table'] as $key => $value):
		       $table_html .= '<tr><th><span>'.$value['title'].'</span> </th><td>';
		switch($value['type']){
		    case 'textarea':
		       $table_html .= '<textarea name="data['.$data[$value['column']].']">'.$data[$value['column']].'</textarea>';
		        break;
		    case 'select':
		       $table_html .= '<select name="data['.$value['column'].']">';
		       foreach($value['select'] as $option):
		           $selectd = ($option==$data[$value['column']])? 'selected' : '';
		           $table_html .= '<option value="'.$option.'" '.$selectd.' >'.$option.'</option>';
		       endforeach;
		       $table_html .= '</select>';
		       break;
            case 'span':
		       $table_html .= $data[$value['column']];
			    break;
            case 'password':
		       $table_html .= '<input value="'.$data[$value['column']].'"  type="password" name="data['.$value['column'].']">';
			    break;
            case 'timearea':
			 $table_html .= '<input type="text" name="data[from_time]" id="from_time">';
			 $table_html .= '至';
			 $table_html .= '<input type="text" name="data[to_time]" id="to_time">';
             $table_html .= '<script>';
             $table_html .= '$(function() {';
	         $table_html .= 'var dates = $("#from_time, #to_time").datepicker({';
		     $table_html .= 'changeYear: true,';
		     $table_html .= 'changeMonth: true,';
		     $table_html .= 'onSelect: function(selectedDate) { ';
			 $table_html .= 'var option = this.id == "from_time" ? "minDate" : "maxDate";';
			 $table_html .= 'var instance = $(this).data("datepicker");';
			 $table_html .= 'var date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);';
			 $table_html .= 'dates.not(this).datepicker("option", option, date);';
		     $table_html .= '}';
	         $table_html .= '});';
             $table_html .= '});';
             $table_html .= '</script>';
			    break;
            default:
		       $table_html .= '<input value="'.$data[$value['column']].'"  type="text" name="data['.$value['column'].']">';
			    break;
        }
		if($value['need']){
		    $table_html .= '<span style="color:red;">*</span>';
		    $check_html .= '
		    if($("input[name=\'data['.$value['column'].']\']").val().length == 0){
				$("input[name=\'data['.$value['column'].'\']").next().html("必填项！");
				return false;
			}else{
				$("input[name=\'data['.$value['column'].'\']").next().html("");
			}';
		}
		$table_html .= '</td></tr>';
    endforeach;
    
    echo $table_html;?>
		<tr class="newRow even" id="newDataRow_tgTable">
			<th>&nbsp;</th>
			<th><input type="submit" value="提交" class='button_css'></th>
		</tr>
	</tbody>
	<?php if($form_info['backurl']) :?>
	<tfoot>
		<tr>
			<th>&nbsp;</th>
		<td style='text-align:right;'><a href='<?php echo $form_info['backurl'];?>'  class='ui-state-default ui-corner-all'>返回列表>></a> </td>
		</tr>
	</tfoot>
	<?php endif;?>
</table>
</form>

<script>
function checkSubmit(){
	<?php echo $check_html;?>
	return true;
}
</script>
