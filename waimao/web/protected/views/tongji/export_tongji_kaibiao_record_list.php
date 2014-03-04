<table border=1>
<?php foreach($table_list as $company=>$list):?>

<tr bgcolor='bule'>
<td>编号</td>
<td>区域</td>
<td>国家</td>
<td>项目简称</td>
<td>招标人</td>
<td>业务员</td>
<td>开标日期</td>
<td>类型</td>
<td>规格型号</td>
<td>数量</td>
<td>我公司报价</td>
<td><?php echo $company;?></td>
<td>中标厂家</td>
<td>平均价</td>
</tr>
<?php foreach($list as $id=>$lt):?>
<tr>
<td><?php echo $lt['tb_show_id'];?></td>
<td><?php echo $lt['respective_regions'];?></td>
<td><?php echo $lt['respective_provinces'];?></td>
<td><?php echo $lt['project_name'];?></td>
<td><?php echo $lt['tenderer'];?></td>
<td><?php echo $lt['slesman'];?></td>
<td><?php echo $lt['end_time'];?></td>
<td><?php echo $lt['transformer_type'];?></td>
<td><?php echo $lt['specification'];?></td>
<td><?php echo $lt['number'];?></td>
<td><?php echo $lt['my_company_price'];?></td>
<td><?php echo $lt['bid_company'].$lt['bid_price'].$lt['xiangcha_search_price'];?></td>
<td><?php echo $lt['show_bid_company'].$lt['show_bid_price'].$lt['xiangcha_bid_price'];?>(<?php echo $lt['bid_price_number']?>/<?php echo $lt['list_price_count']?>)</td>
<td><?php echo $lt['show_agv_price'].$lt['xiangcha_agv_price'];?></td>
</tr>
<?php endforeach;?>
<?php endforeach;?>
</table>