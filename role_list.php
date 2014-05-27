<?php 
	include("check.php"); 
	include("style.php");

	$sql="set names utf8";
	mysqli_query($mysqli,$sql) or die (mysqli_error($mysqli));
	$sql="select * from wraith_role where id != 1";
	$result=mysqli_query($mysqli,$sql) or die (mysqli_error($mysqli));
	while($row=mysqli_fetch_assoc($result))
	{
		$rows[] = $row;
	}
	
	$sql="select * from wraith_menu";
	$result_menu=mysqli_query($mysqli,$sql) or die (mysqli_error($mysqli));
	while($menu=mysqli_fetch_assoc($result_menu))
	{
		$menus[] = $menu;
	}
	mysqli_free_result($result);
?>
<script language="Javascript">
function checkpwd()
{
	if(document.form1.pwd1.value!="" && document.form1.pwd1.value!=document.form1.pwd2.value)
	{
		alert("两次输入的密码不同!");
		return false;
	}
	if(document.form1.pwd1.value=="" && document.form1.member_name.value=="")
	{
		alert("没有可更新信息!");
		return false;
	}
	
}

</script>
<font size=4 color=red>管理角色：</font>
<br><br>
<center>

<table border="1" cellspacing="0" cellpadding="1" width="410" >
<form action=update_accountpro.php name=form1 method=post onsubmit="return checkpwd();">
<input type=hidden name=id value="<?php echo $id;?>">
<tr height="30"><th align=center width=20%><font size=2 color=red>名称</font></th><th align=center><font size=2 color=red>菜单列表</font></th><th align=center width=20%><font size=2 color=red>操作</font></th></tr>
<?php
if(!empty($rows)){
	foreach($rows as $v){
		echo '<tr height="30"><td align=center width=25%>'.$v['name'].'</td><td style="text-align:left">';
		foreach($menus as $m){
			if(in_array($m['id'],explode(',',$v['menus']))){
				if($m['parent']==0){
					echo '<br><font size=2 style="font-weight:bold;">'.$m['name'].'</font>=>';
				}else{
					echo $m['name'].'&nbsp';
				}
			}
		}
		echo '</td><td align=center width=25%><a href="add_role.php?id='.$v['id'].'">修改</a>/<a href="del_role.php?id='.$v['id'].'">删除</a></td></tr>';
	}
}else{
	echo '<tr height="30"><td align=center colspan="2"><font size=2 color=red>没有记录</font></td></tr>';
}
?>

</table>

</center>
