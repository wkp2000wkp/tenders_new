<div class="rate_corner pages">
<ul class="rate_corner">
<?php
if ($pageHtml['curpage'] > 1) {
    ?>
<li class="prevpage"><a
		href=<?php
    echo 'index_' . ($pageHtml['curpage'] - 1) . '.html'?>>��һҳ</a></li>
<?php
}
if (($pageHtml['curpage'] - $pageHtml['offset']) > 1 && $pageHtml['pages'] > $pageHtml['page']) {
    ?>
  <li><a href="index_1.html">1...</a></li>
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
<li><a href="index_<?php
        echo $i?>.html"><?php
        echo $i?></a></li>
<?php
    }
}
if ($pageHtml['to'] < $pageHtml['pages']) {
    ?>
<li><a href="index_<?php
    echo $pageHtml['pages']?>.html">...<?php
    echo $pageHtml['pages']?></a></li>
<?php
}
if ($pageHtml['curpage'] < $pageHtml['pages']) {
    ?>
<li class="nextpage"><a
		href="index_<?php
    echo $pageHtml['curpage'] + 1?>.html">��һҳ</a></li>
<?php
}
if ($pageHtml['to'] < $pageHtml['pages']) {
    ?>
  <li class="lastpage"><a
		href="index_<?php
    echo $pageHtml['pages']?>.html">���һҳ</a></li>
<?php
}
?>
<?php

if ($pageHtml['pages'] > $pageHtml['page']) {
    ?>
<li class="gopage"><span>����</span><input type="text"
		onkeydown="if(event.keyCode==13) {window.location='index_'+this.value+'.html'; return false;}"
		name="custompagelast" id="custompagelast" class="p_input"><span>ҳ</span>
	<button
		onclick="window.location='index_'+document.getElementById('custompagelast').value+'.html'; return false;">ȷ��</button>
	</li>
<?php
}
?>
</ul>

</div>