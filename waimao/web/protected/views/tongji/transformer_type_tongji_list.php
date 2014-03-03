<link type="text/css" rel="stylesheet" href="css/tablegear.css" />
<?php echo $search_html;?>
<div id='show_table'>
<table border=1>
<tr>
<th colspan=9>各类变压器竞争对手中标金额(中标频次)</th>
</tr>
<tr>
<?php foreach(SelectConstent::getSelectKaiBiaoTransformerType() as $type):?>
<td><?php echo $type;?></td>
<?php endforeach;?>
<td>所有变压器</td>
</tr>
<?php foreach($table_list as $bid_company=>$list):?>
<tr>
<?php foreach(SelectConstent::getSelectKaiBiaoTransformerType() as $type):?>
<td><?php echo $list[$type];?></td>
<?php endforeach;?>
<td><?php echo $list[$bid_company.'all_price_total'];?>(<?php echo $list[$bid_company.'all_number_total'];?>)</td>
</tr>
<?php endforeach;?>

</table>

</div>