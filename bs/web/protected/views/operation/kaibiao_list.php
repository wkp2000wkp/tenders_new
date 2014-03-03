<link type="text/css" rel="stylesheet" href="css/tablegear.css" />
<?php echo $search_html;?>
<div id='show_table'>
<table border=1 width='200px'>
<tr>
<td><input type='checkbox' id='checkbox_all'>全选</td>
<td>开标厂家</td>
</tr>

<?php foreach($table_list as $list):?>
<tr>
<td><input type='checkbox' name='data[kb_r_id]' value='<?php echo $list['kb_r_id']; ?>'></td>
<td><?php echo $list['bid_company'];?>(<?php echo $list['kb_count']; ?>)</td>
</tr>
<?php endforeach;?>
</table>
</div>

<script>
	$(document).ready(function() {	
	$("#checkbox_all").click(function(){
		$("input[name='data[kb_r_id]']").attr("checked",$("checkbox_all").attr("checked"));
	});
});

</script>
