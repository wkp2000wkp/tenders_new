<link type="text/css" rel="stylesheet" href="css/tablegear.css" />
<br>
<h3>开标记录（<?php echo $toubiao_info['project_name']; ?>）</h3>
<a class='ui-state-default ui-corner-all ' target="_blank" style="padding-top: 0px; padding-bottom: 0px;" href="javascript:;" onclick='javascript:window.close();return false;'>关闭此页</a>
<?php if($permission): ?>
<a class='ui-state-default ui-corner-all dialog_bor' target="_blank" style="padding-top: 0px; padding-bottom: 0px;" href="<?php echo URL_DOMAIN;?>/index.php?r=backend/nbor&action=insert&tb_id=<?php echo $tou_biao_id; ?>">+添加投标规格</a>
<?php endif; ?>
<a class='ui-state-default ui-corner-all ' target="_blank" style="padding-top: 0px; padding-bottom: 0px;" href="<?php echo URL_DOMAIN;?>/index.php?r=operation/ekbr&search[id]=<?php echo $tou_biao_id; ?>">导出到execl</a>
<?php if($permission): ?>
<a class='ui-state-default ui-corner-all ' style="padding-top: 0px; padding-bottom: 0px;" href="#" onclick="javascript:copyRecord();return false;">复制</a>
<?php endif; ?>
<div class="ui-widget">
			<div style="margin-top: 0px; padding: 0pt 0.7em; width:500px;" class="ui-state-highlight ui-corner-all"> 
<strong>我公司结果汇总：投标总价： <?php echo $sanbian_total;?>    万元；中标总价： <?php echo $bid_total;?>   万元
    </strong>
			</div>
		</div>
<table border="0" style='width:<?php echo (770+($max_bid-1)*60); ?>px'>	<tbody>
<tr  class='odd'>		
<?php if($permission): ?>
<td rowspan="2" style='width:30px;'></td>		
<td rowspan="2" style='width:60px;'>操作</td>		
<?php endif; ?>
<td rowspan="2" style='width:60px;'>类型</td>		
<td rowspan="2" style='width:150px;'>规格型号</td>		
<td rowspan="2" style='width:50px;'>数量</td>		
<td rowspan="2" style='width:70px;'>中标厂家<br>(相差点数)</td>		
<td rowspan="2" style='width:70px;'>核价单保留费率</td>		
<td rowspan="2" style='width:70px;'>按价格表下浮点数</td>		
<td rowspan="2" style='width:70px;'>基准价<br>(相差点数)</td>		
<td rowspan="2" style='width:70px;'>平均价<br>(相差点数)</td>		
<td rowspan="2" style='width:70px;'>币种</td>		
<td colspan="<?php echo $max_bid; ?>" >开标记录（万元）</td>	
</tr>	
<tr  class='odd'>	
	<td >排名/总数</td>			
<?php for($i=1;$i<$max_bid;$i++): ?>
<td >投标人<?php echo $i; ?></td>		
<?php endfor; ?>
</tr>	

<?php for($kb=0;$kb < count($kaibiao_list);$kb++):?>
<?php $class = ( $kb != 0 & $kb%4 == 2) ? " class='odd' " : " "; ?>
<tr <?php echo $class;?>>	
<?php if($permission): ?>	
<td rowspan="2"><input type='radio' name="copy_kb_id" value="<?php echo $kaibiao_list[$kb]['id'];?>" ></td>		
<td>
	<a target="_blank" class="dialog_bor" href="<?php echo URL_DOMAIN;?>/index.php?r=backend/nbor&action=update&tb_id=<?php echo $kaibiao_list[$kb]['tb_id'];?>&kb_id=<?php echo $kaibiao_list[$kb]['id'];?>">编辑</a>
	</td>
	<?php endif; ?>
<td rowspan="2"><?php echo $kaibiao_list[$kb]['transformer_type'];?></td>		
<td rowspan="2"><?php echo nl2br($kaibiao_list[$kb]['specification']);?></td>		
<td rowspan="2"><?php echo nl2br($kaibiao_list[$kb]['number']);?></td>		
<td rowspan="2"><?php echo $bid_list[$kaibiao_list[$kb]['id']]['bid_company'];?><?php if($bid_list[$kaibiao_list[$kb]['id']]['bid_price'] && $bid_list[$kaibiao_list[$kb]['id']]['my_bid_price'] != 0) echo "<br>(".round((($bid_list[$kaibiao_list[$kb]['id']]['bid_price']/$bid_list[$kaibiao_list[$kb]['id']]['my_bid_price']-1)*100),1).")";?></td>		
<td rowspan="2"><?php echo $kaibiao_list[$kb]['baoliu'];?></td>
<td rowspan="2"><?php echo $kaibiao_list[$kb]['xiafu'];?></td>
<td rowspan="2"><?php if($kaibiao_list[$kb]['ji_zhun_price']) echo($kaibiao_list[$kb]['ji_zhun_price']); ?>
<?php if($bid_list[$kaibiao_list[$kb]['id']]['my_bid_price'] != 0 && $kaibiao_list[$kb]['ji_zhun_price']) echo "<br>(".round((($kaibiao_list[$kb]['ji_zhun_price']/$bid_list[$kaibiao_list[$kb]['id']]['my_bid_price']-1)*100),1).")";?>
</td>		
<td rowspan="2"><?php if($kaibiao_list[$kb]['num_bid_price']) echo round(($kaibiao_list[$kb]['all_bid_price']/$kaibiao_list[$kb]['num_bid_price']),1);?>
<?php if($bid_list[$kaibiao_list[$kb]['id']]['my_bid_price'] != 0 && $kaibiao_list[$kb]['num_bid_price']) echo "<br>(".round(((($kaibiao_list[$kb]['all_bid_price']/$kaibiao_list[$kb]['num_bid_price'])/$bid_list[$kaibiao_list[$kb]['id']]['my_bid_price']-1)*100),1).")";?>
</td>		
<td rowspan="2"><?php echo ($kaibiao_list[$kb]['currency_ji_zhun_price'] == SelectConstent::BID_FEE_QITA) ? $kaibiao_list[$kb]['other_currency_ji_zhun_price'] : $kaibiao_list[$kb]['currency_ji_zhun_price'] ;?></td>

<?php
if($kaibiao_list[$kb]):
foreach($kaibiao_list[$kb]['bid_info'] as $r):?>
<td style='width: 70px;'><?php echo $r;?></td>		
<?php 
endforeach; 
endif;
?>
</tr>	
<?php $kb++; ?>
<tr <?php echo $class;?> style='width: 70px;'>		
<?php if($permission): ?>
	<td>
		<a href="<?php echo URL_DOMAIN;?>/index.php?r=operation/okbr&action=delete_result&tb_id=<?php echo $kaibiao_list[$kb]['tb_id'];?>&kb_id=<?php echo $kaibiao_list[$kb]['id'];?>" onclick="javascript:if(!confirm('确定要删除  规格：<?php echo  str_replace( array("\r\n", "\n", "\r"),"|",$kaibiao_list[$kb]['specification']);?> 的信息吗？\n此操作不可以恢复！')) { return false; }">删除</a>
	</td>	
<?php endif; ?>	
<?php 
if($kaibiao_list[$kb]):
foreach($kaibiao_list[$kb]['bid_info'] as $k=>$r):?>
<td style='width: 70px;'>
<?php 
	echo $r ? $r:SelectConstent::WEI_TOU; 
	if($bid_list[$kaibiao_list[$kb]['id']]['my_bid_price']  && ( $r != $bid_list[$kaibiao_list[$kb]['id']]['my_bid_price'])) echo '('.(round((($r/$bid_list[$kaibiao_list[$kb]['id']]['my_bid_price']-1)*100),1)).')';
	if($k==0 && $r) echo '('.($kaibiao_list[$kb]['pai_bid_number']).'/'.$kaibiao_list[$kb]['num_bid_price'].')';

?></td>		
<?php endforeach; 
endif;
?>
</tr>

<?php endfor; ?>
	</tbody></table>
	<br>
				
 <script>
  $(document).ready(function() {
    var window_num=0;
    $(".dialog_bor").click(function(){
    	$("#dialog"+window_num).remove();
    	window_num++;
    	$("#dialog_box").html("<div id='dialog"+window_num+"'></div>");
    	$.get($(this).attr("href")+"&suij="+Math.random(), function(data) {
			$('#dialog'+window_num).html(data);
			$('#dialog'+window_num).dialog({width:550,minWidth:300});
			if ($.browser.msie) {          
				$("#dialog"+window_num).css("width", 550+50);               
			}
			});
		return false;
    });

  });

  function copyRecord(){
	var kb_id = ($(":radio[name=copy_kb_id][checked]").val());
	if(kb_id){
		var url = "<?php echo URL_DOMAIN;?>/index.php?r=operation/okbr&action=copy_result&tb_id=<?php echo $tou_biao_id; ?>&kb_id="+kb_id;
		window.location=url;
	}else{
		alert("请选择需要复制的记录");
	}
  }
  </script>
<div id="dialog_box"></div>

				