<div class="pagination">
			<div class="pages">
			<?php 
			for($i = $min; $i <= $max; $i++):
	    		if ($i == $current_page) : ?>
	    			<span class="current"><?php echo $i;?></span>
	    		<?php else:?>
	    			<a href="<?php echo $uri;?>&page=<?php echo $i;?>"><?php echo $i;?></a>
				<?php 
				endif;
			endfor;?>
			</div>
		</div>
		
		
		