<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>三变-投标管理系统</title>
<link href="css/default.css" rel="stylesheet" type="text/css" />
<link href="css/uploadify.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="js/swfobject.js"></script>
<script type="text/javascript" src="js/jquery.uploadify.v2.1.0.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("#uploadify").uploadify({
		'uploader'       : 'js/uploadify.swf',
		'script'         : '<?php echo URL_DOMAIN;?>/index.php?r=operation/oufr%26action=insert%26id=<?php echo $tou_biao_id;?>',
		'cancelImg'      : 'images/cancel.png',
		'folder'         : 'upload',
		'queueID'        : 'fileQueue',
		'auto'           : false,
		'buttonImg'      : 'images/flash.jpg',
		'method' 		 : 'GET',
		'scriptData'	 : {'test' : 'test1'},
		'onAllComplete' : function(event,data) {
		      alert('上传成功！');
		      self.location='<?php echo URL_DOMAIN;?>/index.php?r=backend/bor&id=<?php echo $tou_biao_id;?>&referer=<?php echo urlencode($referer); ?>';
		    },
		'multi'          : true
	});
});
</script>
</head>

<body>
<div id="fileQueue"></div>
<input type="file" name="uploadify" id="uploadify" />
<br>
备注：<textarea id='remark'></textarea>
<br>
<br>
	<p>
      <a href="javascript:uploadifyUpload();"  class='ui-state-default ui-corner-all'>开始上传</a>
      <a href="javascript:$('#uploadify').uploadifyClearQueue()"  class='ui-state-default ui-corner-all'>取消上传</a>
      <a href="<?php echo URL_DOMAIN;?>/index.php?r=backend/bor&id=<?php echo $tou_biao_id;?>&referer=<?php echo urlencode($referer); ?>"  class='ui-state-default ui-corner-all'>返回</a>
    </p>
<!--$_POST['scriptDataVariable']-->
<!---->
<!--uploadifySettings-->
<script>

function uploadifyUpload(){
	var remark = $('#remark').val();
	var remark_length = $('#remark').val().length;
	if(remark_length != 0){
		if(remark_length > 200){
			alert('备注内容过长');
		}else{
			$("#uploadify").uploadifySettings('scriptData',{"data[remark]":remark,"data[uid]":<?php echo $uid;?>});
			$('#uploadify').uploadifyUpload();
		}
	}else{
		alert('请填写备注');
	}
}

</script>
</body>
</html>