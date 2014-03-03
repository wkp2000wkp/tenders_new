<link type="text/css" rel="stylesheet" href="css/tablegear.css" />
  <?php echo $search_html;?>
<table  style='width:1500px;padding-top: 0px; padding-bottom: 0px;'>
<tr>
<td style='width:750px;'>
<div class="ui-widget">
			<div style="margin-top: 0px; padding: 0pt 0.7em;" class="ui-state-highlight ui-corner-all"> 
<strong>搜索结果统计：投标<?php echo $totals['count_toubiao_bod'];?>份 |
 中标<?php echo $totals['count_bid_bod'];?>份 |
   中标率 <?php echo $totals['bid_percent'];?>% |
   总投标价 <?php echo $totals['total_toubiao_bod'];?>|
    总中标价<?php echo $totals['total_bid_bod'];?>|
占百分比<?php echo $totals['total_bid_percent'];?>% 
    </strong>
			</div>
		</div>
    </td>
<td style='text-align:left;'>
	<a href='#' onclick='javascript:uploadTouBiao();' class='ui-state-default ui-corner-all'>上传文件</a> 
<?php if($user_type != SelectConstent::USER_TYPE_MENGER):?>
	<a href='#' onclick='javascript:updateTouBiao();' class='ui-state-default ui-corner-all'>修改</a> 
<?php endif;?>
<?php if($user_type != SelectConstent::USER_TYPE_MENGER && $history != 'history'):?>
	<a href='#' onclick='javascript:deleteTouBiao();' class='ui-state-default ui-corner-all'>删除</a> 
<?php endif;?>
	<a href='#' onclick='javascript:showChooseSortBox("toubiao");' class='ui-state-default ui-corner-all'>查询结果导出</a> 
	<a href='#' onclick='javascript:showChooseSortBox("kaibiao");' class='ui-state-default ui-corner-all'>开标结果导出</a> 
	<a href='#' onclick='javascript:exportZhongBiao("zhongbiao");' class='ui-state-default ui-corner-all'>中标占比导出</a> 

</td>
</tr>
</table>
<script>
function uploadTouBiao(){
	$("#ZBForm").attr('action','<?php echo URL_DOMAIN; ?>/index.php?r=backend/bor');
	$("#ZBForm").submit();
}
function viewTouBiao(){
	$("#ZBForm").attr('action','<?php echo URL_DOMAIN; ?>/index.php?r=backend/bor&action=view');
	$("#ZBForm").submit();
}
function updateTouBiao(){
	$("#ZBForm").attr('action','<?php echo URL_DOMAIN; ?>/index.php?r=backend/tbf&action=update');
	$("#ZBForm").submit();
}
function deleteTouBiao(){
	if(confirm("确定删除?")){
    	$("#ZBForm").attr('action','<?php echo URL_DOMAIN; ?>/index.php?r=operation/otb&action=delete');
    	$("#ZBForm").submit();
	}else{
		return false;
	}
}
function exportZhaoBiao(){
	$("#seachForm").attr('method','post');
	$("#seachForm").attr('action','<?php echo URL_DOMAIN; ?>/index.php?r=operation/er&export=tb&sort='+$(':radio[name=exprot_sort][checked]').val());
	$("#seachForm").submit();
}
function exportKaiBiao(){
	
	$("#seachForm").attr('method','post');
	$("#seachForm").attr('action','<?php echo URL_DOMAIN; ?>/index.php?r=operation/ekbr&sort='+$(':radio[name=exprot_sort][checked]').val()+'&area='+$(':radio[name=exprot_area][checked]').val());
	$("#seachForm").submit();
	$('#dialog_sort_box').dialog( "close" );
	
}
function exportZhongBiao(){
	
	$("#seachForm").attr('method','post');
	$("#seachForm").attr('action','<?php echo URL_DOMAIN; ?>/index.php?r=operation/ezbr&sort='+$(':radio[name=exprot_sort][checked]').val()+'&area='+$(':radio[name=exprot_area][checked]').val());
	$("#seachForm").submit();
	$('#dialog_sort_box').dialog( "close" );
	
}

function showChooseSortBox(string){
	if(string=='toubiao'){
		$('#toubiao_exprot_button').show();
		$('#kaibiao_exprot_button').hide();
		$('#zhongbiao_exprot_button').hide();
		$('#kaibiao_exprot_section').hide();
	}else if(string=='kaibiao'){
		$('#toubiao_exprot_button').hide();
		$('#kaibiao_exprot_button').show();
		$('#zhongbiao_exprot_button').hide();
		$('#kaibiao_exprot_section').show();
	}else if(string=='zhongbiao'){
		$('#toubiao_exprot_button').hide();
		$('#kaibiao_exprot_button').hide();
		$('#zhongbiao_exprot_button').show();
		$('#kaibiao_exprot_section').hide();

	}
	$('#dialog_sort_box').dialog({width: 540,height: 260});
	
}
</script>

 <script>
  $(document).ready(function() {
    //$(".dialog_bor").dialog();
    $(".dialog_bor").click(function(){
    	var dialog_id=$(this).attr("id");
    	window.open( "<?php echo URL_DOMAIN;?>/index.php?r=backend/abor&id="+$(this).attr("id")+"","", "scrollbars=yes,status=yes,resizable=yes,top=0,left=0,width="+(screen.availWidth-10)+",height="+(screen.availHeight-30));
		return false;
        });
  });
  </script>

<div id='show_table'>
<?php echo $table_html;?>
</div>

<div id="dialog_box"></div>
<div id="dialog_sort_box" title="请选中导出结果的排序" style="display:none;">
选择排序：
<?php 
	foreach($export_sort_list['list'] as $sort_key=>$sort_value):
		$checked = ($sort_key == $export_sort_list['checked']) ? "checked" : "";
		echo "<input type='radio' name='exprot_sort' value='{$sort_key}' {$checked} >{$sort_value}";
	endforeach;
?>
<br>
<br>
<span id='kaibiao_exprot_section' >
选择开标：
<?php 
	foreach($export_area_list['list'] as $sort_key=>$sort_value):
		$checked = ($sort_key == $export_area_list['checked']) ? "checked" : "";
		echo "<input type='radio' name='exprot_area' value='{$sort_key}' {$checked}  >{$sort_value}";
	endforeach;
?>
</span>
<br>
<br>
<a href='#' id='toubiao_exprot_button' onclick='javascript:exportZhaoBiao();' class='ui-state-default ui-corner-all'>查询结果导出</a> 
<a href='#' id='kaibiao_exprot_button' onclick='javascript:exportKaiBiao();' class='ui-state-default ui-corner-all'>开标结果导出</a> 
<a href='#' id='zhongbiao_exprot_button' onclick='javascript:exportZhongBiao();' class='ui-state-default ui-corner-all'>中标占比导出</a> 
</div>
<script>
	$(document).ready(function() {
		<?php 
		if($kaibiao_logo):
		
			foreach($kaibiao_logo as $kb): 
				switch ($kb['status']){
					case SelectConstent::TOUBIAO_BID_STATUS_NONE:
						echo '$("#'.$kb['id'].'").append("<img src=\'images/0.gif\' width=\'15px\' height=\'15px\' border=0> ");';
						break;
					case SelectConstent::TOUBIAO_BID_STATUS_NO:
						echo '$("#'.$kb['id'].'").append("<img src=\'images/no.gif\' width=\'15px\' height=\'15px\' border=0>");';
						echo '$("#'.$kb['id'].'").append("<img src=\'images/1.gif\' width=\'15px\' height=\'15px\' border=0>");';
						break;
					case SelectConstent::TOUBIAO_BID_STATUS_OK:
						echo '$("#'.$kb['id'].'").append("<img src=\'images/ok.gif\' width=\'15px\' height=\'15px\' border=0>");';
						echo '$("#'.$kb['id'].'").append("<img src=\'images/1.gif\' width=\'15px\' height=\'15px\' border=0>");';
						break;
					case SelectConstent::TOUBIAO_BID_STATUS_YES:
						echo '$("#'.$kb['id'].'").append("<img src=\'images/yes.gif\' width=\'15px\' height=\'15px\' border=0>");';
						echo '$("#'.$kb['id'].'").append("<img src=\'images/1.gif\' width=\'15px\' height=\'15px\' border=0>");';
						break;
				}
			
			endforeach;
		endif;
			?>
		
  });

</script>


