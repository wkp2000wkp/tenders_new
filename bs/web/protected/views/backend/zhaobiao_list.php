<?php echo $search_html;?>
<h3>招标项目公示</h3>
<table>
<tr>
<td>
<?php if($user_type != SelectConstent::USER_TYPE_MENGER):?>
	<a href='<?php echo URL_DOMAIN;?>/index.php?r=backend/tf&action=insert'  class='ui-state-default ui-corner-all'>新增</a>  
	<a href='#' onclick='javascript:copyZhaoBiao();'  class='ui-state-default ui-corner-all'>复制</a> 
	<a href='#' onclick='javascript:updateZhaoBiao();'  class='ui-state-default ui-corner-all'>修改</a> 
	<a href='#' onclick='javascript:deleteZhaoBiao();'  class='ui-state-default ui-corner-all'>删除</a> 
	<a href='#' onclick='javascript:submitIntoTouBiao();'  class='ui-state-default ui-corner-all'>转入投标项目信息</a> 
<?php endif;?>
	<a href='#' onclick='javascript:exportZhaoBiao();'  class='ui-state-default ui-corner-all'> >>导出</a> 
</td>
</tr>
</table><?php echo $table_html;?>
<table>
<tr>
<td>
<?php if($user_type != SelectConstent::USER_TYPE_MENGER):?>
	<a href='<?php echo URL_DOMAIN;?>/index.php?r=backend/tf&action=insert'  class='ui-state-default ui-corner-all'>新增</a>  
	<a href='#' onclick='javascript:copyZhaoBiao();'  class='ui-state-default ui-corner-all'>复制</a> 
	<a href='#' onclick='javascript:updateZhaoBiao();'  class='ui-state-default ui-corner-all'>修改</a> 
	<a href='#' onclick='javascript:deleteZhaoBiao();'  class='ui-state-default ui-corner-all'>删除</a> 
	<a href='#' onclick='javascript:submitIntoTouBiao();'  class='ui-state-default ui-corner-all'>转入投标项目信息</a> 
<?php endif;?>
	<a href='#' onclick='javascript:exportZhaoBiao();'  class='ui-state-default ui-corner-all'> >>导出</a> 
</td>
</tr>
</table>
<script>
function submitIntoTouBiao(){
	$("#ZBForm").attr('action','<?php echo URL_DOMAIN; ?>/index.php?r=operation/itb&action=import');
	$("#ZBForm").submit();
}
function updateZhaoBiao(){
	$("#ZBForm").attr('action','<?php echo URL_DOMAIN; ?>/index.php?r=backend/tf&action=update');
	$("#ZBForm").submit();
}
function deleteZhaoBiao(){
	if(confirm("确定删除?")){
    	$("#ZBForm").attr('action','<?php echo URL_DOMAIN; ?>/index.php?r=operation/itb&action=delete');
    	$("#ZBForm").submit();
	}else{
		return false;
	}
}
function copyZhaoBiao(){
	if(confirm("确定复制?")){
    	$("#ZBForm").attr('action','<?php echo URL_DOMAIN; ?>/index.php?r=operation/itb&action=copy');
    	$("#ZBForm").submit();
	}else{
		return false;
	}
}

function exportZhaoBiao(){
	$("#seachForm").attr('method','post');
	$("#seachForm").attr('action','<?php echo URL_DOMAIN; ?>/index.php?r=operation/er&export=zb');
	$("#seachForm").submit();
}
</script>

<script>
$(function() {
	 hiddenSearchTable();
});
</script>
		
		
		
