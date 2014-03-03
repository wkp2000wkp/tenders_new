<link type="text/css" rel="stylesheet" href="css/tablegear.css" />
<div style="padding: 10px;">
<a class='ui-state-default ui-corner-all' style="padding-top: 5px; padding-bottom: 5px;" href="<?php echo URL_DOMAIN;?>/index.php?r=backend/nbor&action=insert&tb_id=<?php echo $tou_biao_id; ?>">+添加投标规格</a>
<a class='ui-state-default ui-corner-all' style="padding-top: 5px; padding-bottom: 5px;" href="<?php echo URL_DOMAIN;?>/index.php?r=backend/nbor&action=insert&tb_id=<?php echo $tou_biao_id; ?>">+添加开标记录</a>
<a class='ui-state-default ui-corner-all' style="padding-top: 5px; padding-bottom: 5px;" href="<?php echo URL_DOMAIN;?>/index.php?r=backend/nbor&action=insert&tb_id=<?php echo $tou_biao_id; ?>">保存</a>
</div>
<table border="0" style='width:<?php echo (700+$max_bid*80); ?>px'>	<tbody>
<tr  class='odd'>		
<td rowspan="2" style='width: 70px;'>操作</td>		
<td rowspan="2" style='width: 60px;'>类型</td>		
<td rowspan="2" style='width: 150px;'>规格型号</td>		
<td rowspan="2" style='width: 60px;'>数量</td>		
<td rowspan="2" style='width: 80px;'>中标厂家</td>		
<td rowspan="2" style='width: 60px;'>相差点数</td>		
<td rowspan="2" style='width: 60px;'>核价单保留费率</td>	
<td rowspan="2" style='width: 60px;'>按价格表下浮点数</td>			
<td colspan="<?php echo $max_bid; ?>" >开标记录</td>	
</tr>	
<tr  class='odd'>	
	<td style='width: 50px;'>我公司</td>			
<?php for($i=1;$i<$max_bid;$i++): ?>
<td style='width: 80px;'>投标人<?php echo $i; ?></td>		
<?php endfor; ?>
</tr>	

<?php for($kb=0;$kb < count($kaibiao_list);$kb++):?>
<?php $class = (($kb+2)%4==0) ? "class='odd'" : "";?>
<tr <?php echo $class;?>>		
<td rowspan="2">
	<a href="<?php echo URL_DOMAIN;?>/index.php?r=operation/okbr&action=delete_result&tb_id=<?php echo $kaibiao_list[$kb]['tb_id'];?>&kb_id=<?php echo $kaibiao_list[$kb]['id'];?>" onclick="javascript:if(!confirm('确定要删除  规格：<?php echo $kaibiao_list[$kb]['specification'];?> 的信息吗？\n此操作不可以恢复！')) { return false; }">删除</a>
	</td>
<td rowspan="2">
<select name="data[transformer_type]" id="data_transformer_type">
				<?php foreach(SelectConstent::getSelectTransformerType() as $option):?>
				<option value="<?php echo $option;?>"
				<?php if ($option==$kaibiao_list[$kb]['transformer_type']) echo 'selected';?>><?php echo $option;?></option>
				<?php endforeach;?>
			</select>
</td>		
<td rowspan="2"><textarea id='data_specification' name='data[specification]'><?php echo $kaibiao_list[$kb]['specification'];?></textarea></td>		
<td rowspan="2"><textarea name='data[number]'><?php echo $kaibiao_list[$kb]['number'];?></textarea></td>		
<td rowspan="2"><input size='6' name="" value="<?php echo $bid_list[$kaibiao_list[$kb]['id']]['bid_company'];?>"></td>		
<td rowspan="2"><input size='6' name="" value="<?php if($bid_list[$kaibiao_list[$kb]['id']]['bid_price']) echo round((($bid_list[$kaibiao_list[$kb]['id']]['bid_price']/$bid_list[$kaibiao_list[$kb]['id']]['my_bid_price']-1)*100),2);?>"></td>		
<td rowspan="2"><input size='6' name="" value="<?php echo $kaibiao_list[$kb]['baoliu'];?>"></td>		
<td rowspan="2"><input size='6' name="" value="<?php echo $kaibiao_list[$kb]['xiafu'];?>"></td>	
<?php $numb=0; ?>
<?php foreach($kaibiao_list[$kb]['bid_info'] as $r):?>
<td><input size='6' name="" value="<?php echo $r;?>"></td>
<?php $numb++; ?>
<?php endforeach; ?>


</tr>	
<?php $kb++; ?>
<tr <?php echo $class;?>>		
			
<?php $numb=0; ?>
<?php foreach($kaibiao_list[$kb]['bid_info'] as $r):?>
<td><input size='6' name="" value="<?php echo $r; ?>"><br>&nbsp;<?php if($bid_list[$kaibiao_list[$kb]['id']]['my_bid_price'] && ( $r != $bid_list[$kaibiao_list[$kb]['id']]['my_bid_price'])) echo '('.(round((($r/$bid_list[$kaibiao_list[$kb]['id']]['my_bid_price']-1)*100),2)).')';?></td>		
<?php $numb++; ?>
<?php endforeach; ?>

</tr>

<?php endfor; ?>


	</tbody></table>
	<br>
				
				
				