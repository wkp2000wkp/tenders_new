       	 <link type="text/css" rel="stylesheet" href="css/tablegear.css" />
       	 <link href="css/960.css" rel="stylesheet" media="screen" />
        <link href="css/defaultTheme.css" rel="stylesheet" media="screen" />
        <link href="css/myTheme.css?20121120" rel="stylesheet" media="screen" />
        <script src="js/jquery.fixedheadertable.js"></script>
<form method="post" id="ZBForm">
        <div class="container_12 divider"> 
        	<div class="grid_8">
        		<table class="fancyTable" id="myTable02" cellpadding="0" cellspacing="0" sytle='table-layout:fixed;width:2250px;'>
        		    <thead>
        		        <tr>
        		        <?php foreach($table_header as $c_key => $c_name): ?>
        		        <th  alt='<?php echo $c_key;?>' width='<?php echo SelectConstent::getTHClassHeadersWidth($c_key); ?>px'><?php echo $c_name; ?></th>
        		        <?php endforeach;?>
        		        </tr>
        		    </thead>
        		    <tfoot>
        		        <tr>
        		            <td colspan=6></td>
        		        </tr>
        		    </tfoot>
        		    <tbody>
        		         <?php foreach($table_list as $list): ?>
        		        <tr>
        		         <?php foreach($table_header as $c_key => $c_name): ?>
        		         
        		         <?php 
        		         $show='';
        		         if($c_key=='bid_fee' && $list[$c_key] == SelectConstent::BID_FEE_FREE):
        		         	$show = nl2br($list['bid_fee_value']).'%';
        		         elseif ($c_key=='bid_fee' && $list[$c_key] == SelectConstent::BID_FEE_QITA):
        		         	$show = nl2br($list['bid_fee_value']);
        		         elseif ($c_key=='bid_fee_sort' && $list[$c_key] == SelectConstent::BID_FEE_QITA):
        		         	$show = nl2br($list['bid_fee_sort_other']);
        		         else:
        		         	$show = nl2br($list[$c_key]);
        		         endif;

        		         if ($c_key=='tender_fee' && $list['currency'] == SelectConstent::BID_FEE_QITA):
        		         	$show = $show.nl2br($list['other_currency']);
        		         elseif ($c_key=='tender_fee'):
        		         	$show = $show.nl2br($list['currency']);
        		         endif;
        		         
        		         if ($c_key=='bid_fee' && $list['currency_bid_fee'] == SelectConstent::BID_FEE_QITA):
        		         	$show = $show.'('.nl2br($list['other_currency_bid_fee']).')';
        		         elseif ($c_key=='bid_fee'):
        		         	$show = $show.'('.nl2br($list['currency_bid_fee']).')';
        		         endif;
        		         
        		         if ($c_key=='bid_bond' && $list['currency_bid_bond'] == SelectConstent::BID_FEE_QITA):
        		         	$show = $show.nl2br($list['other_currency_bid_fee']);
        		         elseif ($c_key=='bid_bond'):
        		         	$show = $show.nl2br($list['currency_bid_bond']);
        		         endif;
        		         ?>
        		         
        		        <td class="fixed_css_<?php echo $c_key;?>"  width='<?php echo SelectConstent::getTHClassHeadersWidth($c_key); ?>px'>
        		        	<?php echo $show; ?>
        		        <?php ?>
        		        </td>
        		        <?php endforeach;?>
        		        </tr>
        		        <?php endforeach;?>
        		    </tbody>
        		</table>
        	</div>
        	<div class="clear"></div>
        	<?php echo $pagination_html;?>
        </div>

<script>
$(document).ready(function() {
    $('#myTable02').fixedHeaderTable({ altClass: 'odd', height:700,footer:true});
});
</script>
</form>