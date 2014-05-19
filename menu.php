<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK href="css/admin.css" type="text/css" rel="stylesheet">
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
</HEAD>
<BODY>
<span style="display:none">
<?php   
	include("check.php"); 
	$sql="set names utf8";
	mysqli_query($mysqli,$sql) or die (mysqli_error($mysqli));
	$sql="select * from wraith_menu order by id asc";
	$result=mysqli_query($mysqli,$sql) or die (mysqli_error($mysqli));
	while($row=mysqli_fetch_assoc($result))
	{
		if($row['parent'] == 0)
		{
			$parent[] = $row;
		}
		else
		{
			$childs[] = $row;
		}
	}
	mysqli_free_result($result);

	$sql="select menus from wraith_role where id=".$_COOKIE['role'];
	$result_role=mysqli_query($mysqli,$sql) or die (mysqli_error($mysqli));
	$role=mysqli_fetch_assoc($result_role);
	mysqli_free_result($result_role);
?>
</span>
<TABLE height="100%" cellSpacing=0 cellPadding=0 width=170 
background=images/menu_bg.jpg border=0>
  <TR>
    <TD vAlign=top align=middle>
      <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
        
        <TR>
          <TD height=10></TD></TR></TABLE>


     <!-- <TABLE cellSpacing=0 cellPadding=0 width=150 border=0>
        
        <TR height=22>
          <TD style="PADDING-LEFT: 30px" background=images/menu_bt.jpg><A 
            class=menuParent onclick=expand(1) 
            href="javascript:void(0);">消息查看</A></TD></TR>
        <TR height=4>
          <TD></TD></TR></TABLE>
      <TABLE id=child1 style="DISPLAY: none" cellSpacing=0 cellPadding=0 
      width=150 border=0>
        <TR height=20>
          <TD align=middle width=30><IMG height=9 
            src="images/menu_icon.gif" width=9></TD>
          <TD><A class=menuChild 
            href="query_mo.php" 
            target=main>上行查看</A></TD></TR>
        <TR height=20>
          <TD align=middle width=30><IMG height=9 
            src="images/menu_icon.gif" width=9></TD>
          <TD><A class=menuChild 
            href="query_mt.php" 
            target=main>下行查看</A></TD></TR>
          <TD colSpan=2></TD></TR></TABLE>-->
          
          
 <?php
	if(!empty($parent))
	{
		foreach($parent as $v)
		{	
			if(in_array($v['id'],explode(',',$role['menus'])) || $role['menus']==='0'){
?>
			<TABLE cellSpacing=0 cellPadding=0 width=150 border=0>
			<TR height=22>
			  <TD style="PADDING-LEFT: 30px" background=images/menu_bt.jpg><A 
				class=menuParent onclick=expand(<?php echo $v['id'];?>) 
				href="javascript:void(0);"><?php echo $v['name']?></A></TD></TR>
			<TR height=4>
			  <TD></TD></TR></TABLE>

<?php
			}
				if(!empty($childs))
				{
					echo '<TABLE id=child'.$v['id'].' style="DISPLAY: none" cellSpacing=0 cellPadding=0 width=150 border=0>';
					foreach($childs as $c)
					{
						if($c['parent'] == $v['id'])
						{
							if(in_array($c['id'],explode(',',$role['menus'])) || $role['menus']==='0'){
?>							
							<TR height=20>
							  <TD align=middle width=30><IMG height=9 
								src="images/menu_icon.gif" width=9></TD>
							  <TD><A class=menuChild 
								href="<?php echo $c['url']?>" 
								target=main><?php echo $c['name'];?></A></TD></TR>	
						
<?php
							}
						}
					}
				}
		}
	}		
 ?>        
          
          
          
          
          
          
    <!--  <TABLE cellSpacing=0 cellPadding=0 width=150 border=0>
        <TR height=22>
          <TD style="PADDING-LEFT: 30px" background=images/menu_bt.jpg><A 
            class=menuParent onclick=expand(2) 
            href="javascript:void(0);">包月用户</A></TD></TR>
        <TR height=4>
          <TD></TD></TR></TABLE>
      <TABLE id=child2 style="DISPLAY: none" cellSpacing=0 cellPadding=0 
      width=150 border=0>
        <TR height=20>
          <TD align=middle width=30><IMG height=9 
            src="images/menu_icon.gif" width=9></TD>
          <TD><A class=menuChild 
            href="query_sub.php" 
            target=main>包月用户</A></TD></TR>
            
      
      
            
      <TABLE cellSpacing=0 cellPadding=0 width=150 border=0>
        <TR height=22>
          <TD style="PADDING-LEFT: 30px" background=images/menu_bt.jpg><A 
            class=menuParent onclick=expand(3) 
            href="javascript:void(0);">数据统计</A></TD></TR>
        <TR height=4>
          <TD></TD></TR></TABLE>
      <TABLE id=child3 style="DISPLAY: none" cellSpacing=0 cellPadding=0 
      width=150 border=0>
        <TR height=20>
          <TD align=middle width=30><IMG height=9 
            src="images/menu_icon.gif" width=9></TD>
          <TD><A class=menuChild 
            href="statistic.php" 
            target=main>运营统计</A></TD></TR>
            
            
      <TABLE cellSpacing=0 cellPadding=0 width=150 border=0>
        <TR height=22>
          <TD style="PADDING-LEFT: 30px" background=images/menu_bt.jpg><A 
            class=menuParent onclick=expand(8) 
            href="javascript:void(0);">黑名单管理</A></TD></TR>
        <TR height=4>
          <TD></TD></TR></TABLE>
      <TABLE id=child8 style="DISPLAY: none" cellSpacing=0 cellPadding=0 
      width=150 border=0>
        <TR height=20>
          <TD align=middle width=30><IMG height=9 
            src="images/menu_icon.gif" width=9></TD>
          <TD><A class=menuChild 
            href="blklist.php" 
            target=main>黑名单列表</A></TD></TR>
            
             <TR height=20>
          <TD align=middle width=30><IMG height=9 
            src="images/menu_icon.gif" width=9></TD>
          <TD><A class=menuChild 
            href=" blklist_edit.php" 
            target=main>添加黑名单</A></TD></TR>   
            
            
            
      <TABLE cellSpacing=0 cellPadding=0 width=150 border=0>
        <TR height=22>
          <TD style="PADDING-LEFT: 30px" background=images/menu_bt.jpg><A 
            class=menuParent onclick=expand(4) 
            href="javascript:void(0);">产品管理</A></TD></TR>
        <TR height=4>
          <TD></TD></TR></TABLE>
      <TABLE id=child4 style="DISPLAY: none" cellSpacing=0 cellPadding=0 
      width=150 border=0>
        <TR height=20>
          <TD align=middle width=30><IMG height=9 
            src="images/menu_icon.gif" width=9></TD>
          <TD><A class=menuChild 
            href="product_management.php" 
            target=main>产品配置</A></TD></TR>

        <TR height=20>
          <TD align=middle width=30><IMG height=9 
            src="images/menu_icon.gif" width=9></TD>
          <TD><A class=menuChild 
            href="product_contents.php" 
            target=main>产品下行</A></TD></TR></TABLE>
            
            
        <TABLE cellSpacing=0 cellPadding=0 width=150 border=0>
        <TR height=22>
          <TD style="PADDING-LEFT: 30px" background=images/menu_bt.jpg><A 
            class=menuParent onclick=expand(5) 
            href="javascript:void(0);">访问控制</A></TD></TR>
        <TR height=4>
          <TD></TD></TR></TABLE>
      <TABLE id=child5 style="DISPLAY: none" cellSpacing=0 cellPadding=0 
      width=150 border=0>
        <TR height=20>
          <TD align=middle width=30><IMG height=9 
            src="images/menu_icon.gif" width=9></TD>
          <TD><A class=menuChild 
            href="visit_limit_management.php" 
            target=main>访问控制</A></TD></TR> -->         
            
            
            
      <TABLE cellSpacing=0 cellPadding=0 width=150 border=0>
        
        <TR height=22>
          <TD style="PADDING-LEFT: 30px" background=images/menu_bt.jpg><A 
            class=menuParent onclick=expand(0) 
            href="javascript:void(0);">个人管理</A></TD></TR>
        <TR height=4>
          <TD></TD></TR></TABLE>
      <TABLE id=child0 style="DISPLAY: none" cellSpacing=0 cellPadding=0 
      width=150 border=0>
        <TR height=20>
          <TD align=middle width=30><IMG height=9 
            src="images/menu_icon.gif" width=9></TD>
          <TD><A class=menuChild 
            href="create_account.php" 
            target=main>添加用户</A></TD></TR>
		<TR height=20>
          <TD align=middle width=30><IMG height=9 
            src="images/menu_icon.gif" width=9></TD>
          <TD><A class=menuChild 
            href="account_list.php" 
            target=main>用户列表</A></TD></TR>
		<TR height=20>
          <TD align=middle width=30><IMG height=9 
            src="images/menu_icon.gif" width=9></TD>
          <TD><A class=menuChild 
            href="add_role.php" 
            target=main>添加角色</A></TD></TR>
		<TR height=20>
          <TD align=middle width=30><IMG height=9 
            src="images/menu_icon.gif" width=9></TD>
          <TD><A class=menuChild 
            href="role_list.php" 
            target=main>角色列表</A></TD></TR>
		 <TR height=20>
          <TD align=middle width=30><IMG height=9 
            src="images/menu_icon.gif" width=9></TD>
          <TD><A class=menuChild 
            href="update_account.php" 
            target=main>修改资料</A></TD></TR>
        <TR height=20>
          <TD align=middle width=30><IMG height=9 
            src="images/menu_icon.gif" width=9></TD>
          <TD><A class=menuChild 
            onclick="if (confirm('确定要退出吗？')) return true; else return false;" 
            href="log_off.php" 
            target=_top>退出系统</A></TD></TR></TABLE></TD>
    <TD width=1 bgColor=#d1e6f7></TD></TR></TABLE></BODY></HTML>
