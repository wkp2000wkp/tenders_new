<script>
alert('<?php
echo $show_lang;
?>');
jump('<?php
echo $jump_url;
?>');
function jump(url){
	if(url == '-1')
		history.go(url);
	else
		self.location=url;
}

</script>