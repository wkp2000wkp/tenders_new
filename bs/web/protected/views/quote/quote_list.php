  <link type="text/css" rel="stylesheet" href="css/tablegear.css" />
  <?php echo $search_html;?>
<table  style='width:1500px;padding-top: 0px; padding-bottom: 0px;'>
<tr>
<td style='text-align:center;'>
	<a href='#' id='upload-form' class='ui-state-default ui-corner-all'>报价相关</a> 
<?php if($history != 'history'):?>
	<a href='#' id='insert-form' class='ui-state-default ui-corner-all'>新增</a> 
<?php endif;?>
<?php if($user_type != SelectConstent::USER_TYPE_MENGER):?>
	<a href='#' id='update-form' class='ui-state-default ui-corner-all'>修改</a> 
<?php endif;?>
<?php if($user_type != SelectConstent::USER_TYPE_MENGER && $history != 'history'):?>
	<a href='#' id='delete-form'  class='ui-state-default ui-corner-all'>删除</a> 
<?php endif;?>
	<a href='#' id='export-form' class='ui-state-default ui-corner-all'>查询结果导入execl</a> 
</td>
</tr>
</table>
<script>
$(function() {
$('#upload-form').click(function() {
	if(!$("input[@name='id']:checked").val()){
		alert('请先选择操作编号！');
		return false;
	}
	$("#ZBForm").attr('action','<?php echo URL_DOMAIN; ?>/index.php?r=quote/ulist');
	$("#ZBForm").submit();
});
$('#insert-form').click(function() {
	$.post("index.php?r=quote/option&action=view",function(data){
			$('#dialog-form').html(data);
			$('#dialog-form').dialog('open');
		});
});
$('#update-form').click(function() {
	if(!$("input[@name='id']:checked").val()){
		alert('请先选择操作编号！');
		return false;
	}
	$.post("index.php?r=quote/option&action=view", $("#ZBForm").serialize(),function(data){
		if(data == '﻿no_permissions'){
			alert('<?php echo ShowLang::getLanguage('no_permissions');?>');
			return false;
		}
		$('#dialog-form').html(data);
		$('#dialog-form').dialog('open');
	});
});
$('#delete-form').click(function() {
	if(!$("input[@name='id']:checked").val()){
		alert('请先选择操作编号！');
		return false;
	}
	if(confirm("确定删除?")){
		$.post("index.php?r=quote/option&action=delete", $("#ZBForm").serialize(),function(data){
			alert(data);
			window.location = '<?php echo URL_DOMAIN;?>/index.php?r=quote/ilist';
		});
	}else{
		return false;
	}
});

$('#export-form').click(function() {
	$("#seachForm").attr('method','post');
	$("#seachForm").attr('action','<?php echo URL_DOMAIN; ?>/index.php?r=operation/er&export=quote');
	$("#seachForm").submit();
});
});
function exportRecord(){
	
}
</script>
<div id='show_table'>
<?php echo $table_html;?>
</div>
	<script type="text/javascript" src="<?php echo URL_DOMAIN;?>/js/jquery.bgiframe-2.1.1.js"></script>
	<script type="text/javascript" src="<?php echo URL_DOMAIN;?>/js/jquery.ui.core.js"></script>
	<script type="text/javascript" src="<?php echo URL_DOMAIN;?>/js/jquery.ui.widget.js"></script>
	<script type="text/javascript" src="<?php echo URL_DOMAIN;?>/js/jquery.ui.mouse.js"></script>
	<script type="text/javascript" src="<?php echo URL_DOMAIN;?>/js/jquery.ui.button.js"></script>
	<script type="text/javascript" src="<?php echo URL_DOMAIN;?>/js/jquery.ui.draggable.js"></script>
	<script type="text/javascript" src="<?php echo URL_DOMAIN;?>/js/jquery.ui.position.js"></script>
	<script type="text/javascript" src="<?php echo URL_DOMAIN;?>/js/jquery.ui.resizable.js"></script>
	<script type="text/javascript" src="<?php echo URL_DOMAIN;?>/js/jquery.ui.dialog.js"></script>
	<script type="text/javascript" src="<?php echo URL_DOMAIN;?>/js/jquery.effects.core.js"></script>	
	<style type="text/css">
		label, input { display:block; }
		input.text { margin-bottom:12px; width:90%; padding: .4em; }
		fieldset { padding:0; border:0; margin-top:25px; }
		h1 { font-size: 1.2em; margin: .6em 0; }
		div#users-contain { width: 350px; margin: 20px 0; }
		div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
		div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
		.ui-dialog .ui-state-error { padding: .3em; }
		.validateTips { border: 1px solid transparent; padding: 0.3em; }
		
	</style>
	<div id="dialog-form" title="报价信息"></div>
