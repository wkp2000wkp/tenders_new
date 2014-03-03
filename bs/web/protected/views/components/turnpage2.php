<div class="pages">
<ul>
<?php
if ($pageHtml['curpage'] > 1) {
    ?>
<li class="prevpage"><a
		href=<?php
    echo $pageHtml['mpurl'] . 'page=' . ($pageHtml['curpage'] - 1)?>>��һҳ</a></li>
<?php
}
if (($pageHtml['curpage'] - $pageHtml['offset']) > 1 && $pageHtml['pages'] > $pageHtml['page']) {
    ?>
  <li><a href=<?php
    echo $pageHtml['mpurl']?> page=1>1...</a></li>
<?php
}
for ($i = $pageHtml['from']; $i <= $pageHtml['to']; $i++) {
    if ($i == $pageHtml['curpage']) {
        ?>
<li class="select"><a><?php
        echo $i?></a></li>
<?php
    }
    else {
        ?>
<li><a
		href="<?php
        echo $pageHtml['mpurl']?>page=<?php
        echo $i?>"><?php
        echo $i?></a></li>
<?php
    }
}
if ($pageHtml['to'] < $pageHtml['pages']) {
    ?>

<li><a
		href="<?php
    echo $pageHtml['mpurl']?>page=<?php
    echo $pageHtml['pages']?>">...<?php
    echo $pageHtml['pages']?></a></li>
<?php
}
if ($pageHtml['curpage'] < $pageHtml['pages']) {
    ?>
<li class="nextpage"><a
		href="<?php
    echo $pageHtml['mpurl']?>page=<?php
    echo $pageHtml['curpage'] + 1?>">��һҳ</a></li>
<?php
}
if ($pageHtml['to'] < $pageHtml['pages']) {
    ?>
  <li class="lastpage"><a
		href="<?php
    echo $pageHtml['mpurl']?>page=<?php
    echo $pageHtml['pages']?>">���һҳ</a></li>
<?php
}
?>
<?php

if ($pageHtml['pages'] > $pageHtml['page']) {
    ?>
<li class="gopage"><span>����</span><input type="text"
		onkeydown="if(event.keyCode==13) {window.location='<?php
    echo $pageHtml['mpurl']?>page='+this.value; return false;}"
		name="custompagelast" id="custompagelast" class="p_input"><span>ҳ</span>
	<button
		onclick="window.location='<?php
    echo $pageHtml['mpurl']?>page='+document.getElementById('custompagelast').value; return false;">ȷ��</button>
	</li>
<?php
}
?>
</ul>

</div>