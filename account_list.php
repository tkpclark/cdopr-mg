<?php 
	include("check.php"); 
	include("style.php");

	$sql="set names utf8";
	mysqli_query($mysqli,$sql) or die (mysqli_error($mysqli));
	$sql="select u.* , r.name as name from wraith_users u left join wraith_role r on u.role=r.id where u.id !=".$_COOKIE['id'];
	$result=mysqli_query($mysqli,$sql) or die (mysqli_error($mysqli));
	while($row=mysqli_fetch_assoc($result))
	{
		$rows[] = $row;
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
<font size=4 color=red>管理用户：</font>
<br><br>
<center>

<table border="1" cellspacing="0" cellpadding="1" width="410" >
<form action=update_accountpro.php name=form1 method=post onsubmit="return checkpwd();">
<input type=hidden name=id value="<?php echo $id;?>">
<tr height="30"><td align=center width=25%><font size=2 color=red>用户名</font></td><td align=center width=25%><font size=2 color=red>真实姓名</font></td><td align=center width=25%><font size=2 color=red>权限</font></td><td align=center width=25%><font size=2 color=red>操作</font></td></tr>
<?php
if(!empty($rows)){
	foreach($rows as $v){
		echo '<tr height="30"><td align=center width=25%>'.$v['username'].'</td><td align=center width=25%>'.$v['membername'].'</td><td align=center width=25%>'.$v['name'].'</td><td align=center width=25%><a href="update_account.php?id='.$v['ID'].'">修改</a>/<a href="del_account.php?id='.$v['ID'].'">删除</a></td></tr>';
	}
}else{
	echo '<tr height="30"><td align=center colspan="4"><font size=2 color=red>没有记录</font></td></tr>';
}
?>

</table>

</center>
