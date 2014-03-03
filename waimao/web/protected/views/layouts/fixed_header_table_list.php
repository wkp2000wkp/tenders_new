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
        		        <td class="fixed_css_<?php echo $c_key;?>"  width='<?php echo SelectConstent::getTHClassHeadersWidth($c_key); ?>px'>
        		        <?php if($c_key=='bid_fee' && $list[$c_key] == SelectConstent::BID_FEE_FREE):?>
        		        	<?php echo nl2br($list['bid_fee_value']).'%'; ?>
        		        <?php elseif($c_key=='bid_fee' && $list[$c_key] == SelectConstent::BID_FEE_QITA):?>
        		        	<?php echo nl2br($list['bid_fee_value']); ?>
        		        <?php else:?>
        		        	<?php echo nl2br($list[$c_key]); ?>
        		        <?php endif;?>
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