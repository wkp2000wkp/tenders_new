<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
  <META http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>三变-投标管理系统</title>
  <LINK  type="text/css" rel="stylesheet" href="css/admin.css" />
</HEAD>
<BODY>

<SCRIPT language=javascript>
	function expand(el)
	{
		childObj = document.getElementById("child" + el);

		if (childObj.style.display == 'none')
		{
			childObj.style.display = 'block';
		}
		else
		{
			childObj.style.display = 'none';
		}
		return;
	}
</SCRIPT>
<TABLE height="100%" cellSpacing=0 cellPadding=0 width=170
	background=images/menu_bg.jpg border=0>
	<TR>
		<TD vAlign=top align=middle>
		<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>

			<TR>
				<TD height=10></TD>
			</TR>
		</TABLE>
			<?php if($user_type == SelectConstent::USER_TYPE_ADMIN):?>
		<TABLE cellSpacing=0 cellPadding=0 width=150 border=0>
			<TR height=22>
				<TD style="PADDING-LEFT: 30px" background=images/menu_bt.jpg><A
					class=menuParent onclick=expand(0) href="javascript:void(0);">系统管理</A></TD>
			</TR>
			<TR height=4>
				<TD></TD>
			</TR>
		</TABLE>
		<TABLE id=child0 style="DISPLAY: block" cellSpacing=0 cellPadding=0
			width=150 border=0>
			<TR height=20>
				<TD align=middle width=30><IMG height=9 src="images/menu_icon.gif"
					width=9></TD>
				<TD><A class=menuChild href="<?php echo URL_DOMAIN;?>/index.php?r=backend/u" target=main>用户管理</A></TD>
			</TR>
			<TR height=20>
				<TD align=middle width=30><IMG height=9 src="images/menu_icon.gif"
					width=9></TD>
				<TD><A class=menuChild href="<?php echo URL_DOMAIN;?>/index.php?r=backup/list&table=<?php echo SelectConstent::TABLE_BACKUP;?>" target=main>转入历史投标</A></TD>
			</TR>
			<TR height=20>
				<TD align=middle width=30><IMG height=9 src="images/menu_icon.gif"
					width=9></TD>
				<TD><A class=menuChild href="<?php echo URL_DOMAIN;?>/index.php?r=backup/list&table=<?php echo SelectConstent::TABLE_QUOTE_BACKUP;?>" target=main>转入历史报价</A></TD>
			</TR>
		</TABLE>
			<?php endif;?>
		<TABLE cellSpacing=0 cellPadding=0 width=150 border=0>

			<TR height=22>
				<TD style="PADDING-LEFT: 30px" background=images/menu_bt.jpg><A
					class=menuParent onclick=expand(1) href="javascript:void(0);">投标管理</A></TD>
			</TR>
			<TR height=4>
				<TD></TD>
			</TR>
		</TABLE>
		<TABLE id=child1 style="DISPLAY: block" cellSpacing=0 cellPadding=0
			width=150 border=0>
			<TR height=20>
				<TD align=middle width=30><IMG height=9 src="images/menu_icon.gif"
					width=9></TD>
				<TD><A class=menuChild href="<?php echo URL_DOMAIN;?>/index.php?r=backend/zb" target=main>招标项目公示</A></TD>
			</TR>
			<TR height=20>
				<TD align=middle width=30><IMG height=9 src="images/menu_icon.gif"
					width=9></TD>
				<TD><A class=menuChild href="<?php echo URL_DOMAIN;?>/index.php?r=backend/tb" target=main>投标项目信息</A></TD>
			</TR>
			<TR height=20>
				<TD align=middle width=30><IMG height=9 src="images/menu_icon.gif"
					width=9></TD>
				<TD><A class=menuChild href="<?php echo URL_DOMAIN;?>/index.php?r=backend/tb&time=history" target=main>历史投标项目</A></TD>
			</TR>
			<TR height=4>
				<TD colSpan=2></TD>
			</TR>
		</TABLE>
		<TABLE cellSpacing=0 cellPadding=0 width=150 border=0>

			<TR height=22>
				<TD style="PADDING-LEFT: 30px" background=images/menu_bt.jpg><A
					class=menuParent onclick=expand(6) href="javascript:void(0);">报价管理</A></TD>
			</TR>
			<TR height=4>
				<TD></TD>
			</TR>
		</TABLE>
		<TABLE id=child6 style="DISPLAY: block" cellSpacing=0 cellPadding=0
			width=150 border=0>
			<TR height=20>
				<TD align=middle width=30><IMG height=9 src="images/menu_icon.gif"
					width=9></TD>
				<TD><A class=menuChild href="<?php echo URL_DOMAIN;?>/index.php?r=quote/ilist" target=main>报价文件信息</A></TD>
			</TR>
			<TR height=20>
				<TD align=middle width=30><IMG height=9 src="images/menu_icon.gif"
					width=9></TD>
				<TD><A class=menuChild href="<?php echo URL_DOMAIN;?>/index.php?r=quote/ilist&time=history" target=main>历史报价文件</A></TD>
			</TR>
			<TR height=4>
				<TD colSpan=2></TD>
			</TR>
		</TABLE>
		<?php if($user_type == SelectConstent::USER_TYPE_ADMIN || $user_type == SelectConstent::USER_TYPE_MENGER):?>
		<TABLE cellSpacing=0 cellPadding=0 width=150 border=0>
			<TR height=22>
				<TD style="PADDING-LEFT: 30px" background=images/menu_bt.jpg><A
					class=menuParent onclick=expand(5) href="javascript:void(0);">统计管理</A></TD>
			</TR>
			<TR height=4>
				<TD></TD>
			</TR>
		</TABLE>
		<TABLE id=child5 style="DISPLAY: block" cellSpacing=0 cellPadding=0
			width=150 border=0>
			<TR height=20>
				<TD align=middle width=30><IMG height=9 src="images/menu_icon.gif"
					width=9></TD>
				<TD><A class=menuChild href="<?php echo URL_DOMAIN;?>/index.php?r=tongji/duibi&action=show" target=main>厂家对比</A></TD>
			</TR>
			<TR height=20>
				<TD align=middle width=30><IMG height=9 src="images/menu_icon.gif"
					width=9></TD>
				<TD><A class=menuChild href="<?php echo URL_DOMAIN;?>/index.php?r=tongji/bcl&action=show" target=main>中标情况统计</A></TD>
			</TR>

		</TABLE>
		<TABLE cellSpacing=0 cellPadding=0 width=150 border=0>
			<TR height=22>
				<TD style="PADDING-LEFT: 30px" background=images/menu_bt.jpg><A
					class=menuParent onclick=expand(7) href="javascript:void(0);">管理工具</A></TD>
			</TR>
			<TR height=4>
				<TD></TD>
			</TR>
		</TABLE>
		<TABLE id=child5 style="DISPLAY: block" cellSpacing=0 cellPadding=0
			width=150 border=0>
			<TR height=20>
				<TD align=middle width=30><IMG height=9 src="images/menu_icon.gif"
					width=9></TD>
				<TD><A class=menuChild href="<?php echo URL_DOMAIN;?>/index.php?r=tool/orkbr&action=show" target=main>开标厂家替换</A></TD>
			</TR>
		</TABLE>
		<?php endif;?>
		<TABLE cellSpacing=0 cellPadding=0 width=150 border=0>
			<TR height=22>
				<TD style="PADDING-LEFT: 30px" background=images/menu_bt.jpg><A
					class=menuParent onclick=expand(2) href="javascript:void(0);">个人管理</A></TD>
			</TR>
			<TR height=4>
				<TD></TD>
			</TR>
		</TABLE>
		<TABLE id=child2 style="DISPLAY: block" cellSpacing=0 cellPadding=0
			width=150 border=0>
			<TR height=20>
				<TD align=middle width=30><IMG height=9 src="images/menu_icon.gif"
					width=9></TD>
				<TD><A class=menuChild href="<?php echo URL_DOMAIN;?>/index.php?r=backend/ui&action=update" target=main>修改口令</A></TD>
			</TR>
			<TR height=20>
				<TD align=middle width=30><IMG height=9 src="images/menu_icon.gif"
					width=9></TD>
				<TD><A class=menuChild
					onclick="if (confirm('确定要退出吗？')) return true; else return false;"
					href="<?php echo URL_DOMAIN;?>" target=_top>退出系统</A></TD>
			</TR>
		</TABLE>

		</TD>
		<TD width=1 bgColor=#d1e6f7></TD>
	</TR>
</TABLE>


</BODY>
</HTML>
