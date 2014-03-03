	<?php echo $table_html;?>
	<table>
<tr>
<td>&nbsp;</td>
<td>
	<td><a href='<?php echo URL_DOMAIN;?>/index.php?r=quote/uform&quote_id=<?php echo $quote_id; ?>&referer=<?php echo urlencode($referer); ?>'  class='ui-state-default ui-corner-all'>【上传文件】</a> |
	<a href='#'  id="opener" class='ui-state-default ui-corner-all'>修改</a> |
	<a href='#' onclick='javascript:deleteUploadFile();' class='ui-state-default ui-corner-all'>删除</a> |
	<a href='<?php echo $referer; ?>'  id="opener" class='ui-state-default ui-corner-all'>返回</a> </td>
<script type="text/javascript" src="js/jquery.ui.dialog.js"></script>
<script>
	function deleteUploadFile(){
		if(confirm("确定删除?")){
	    	$("#ZBForm").attr('action','<?php echo URL_DOMAIN; ?>/index.php?r=quote/uoption&action=delete&tb_id=<?php echo $quote_id; ?>');
	    	$("#ZBForm").submit();
		}else{
			return false;
		}
	}
	function postRemark(){
		var url = '<?php echo URL_DOMAIN;?>/index.php?r=operation/oufr&action=update';
		var id = $("input[name=id]:checked").val();
		var remark = $("#remarkUpdate").val();
			if(remark.length != 0){
				if(remark.length > 200){
					alert('备注内容过长');
				}else{
				var dataPost = {id : id ,remark : remark};
				$.ajax({
					   type: "POST",
					   url: url,
					   data: dataPost,
					   dataType : 'html',
					   success: function(msg){
							$("#remark_"+ id).html(remark);
							$("#dialog").dialog('close');
					   }
					}); 
				}
			}else{
				alert('请填写备注');
			}
	}
	$(function() {
		$('#dialog').dialog({
			autoOpen: false,
			show: 'blind',
			hide: 'explode'
		});
		
		$('#opener').click(function() {
			var id = $("input[name=id]:checked").val();
			if(id){
				var remark_txt = $("#remark_"+ id).text();
				$("#remarkUpdate").text( remark_txt );
				$("#dialog").dialog('open');
			}else{
				alert('请先选择');
			}
			return false;
		});

	});
	</script>
	<div class="demo" id="remark_update">
		<div id="dialog"  align="center" title="备注内容">
			<textarea id='remarkUpdate' cols="35" rows="5"></textarea><br>
			<button onclick='javascript:postRemark();'>提交</button>
		</div>
	</div>
<td></td>
</tr>
</table>


