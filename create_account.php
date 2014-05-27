<?php 
	include("check.php"); 
	include("style.php");

	$sql="set names utf8";
	mysqli_query($mysqli,$sql) or die (mysqli_error($mysqli));
	$sql="select * from wraith_role";
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
	if(document.form1.name.value=="")
	{
		alert("请输入用户名！");
		document.form1.name.focus();
		return false;
	}
	if(document.form1.pwd1.value==""||document.form1.pwd2.value=="")
	{
		alert("请输入密码！");
		document.form1.pwd1.focus();
		return false;
	}
	if(document.form1.pwd1.value!=document.form1.pwd2.value)
	{
		alert("两次输入的密码不同!");
		return false;
	}
	if(document.form1.position.value)
	{
		alert("请选择帐号类型！");
		document.form1.position.focus();
		return false;
	}
	if(document.form1.member_name.value=="")
	{
		alert("请选择员工姓名");
		return false;
	}
	
}

</script>
<font size=4 color=red>添加用户：</font>
<br><br>
<center>

<table border="1" cellspacing="0" cellpadding="1" width="410" >
<form action=create_accountpro.php name=form1 method=post onsubmit="return checkpwd();">
<tr height="30"><td align=center><font size=2 color=red>用户名：&nbsp;&nbsp;<input type=text name=name></td></tr>
<tr height="30"><td align=center><font size=2 color=red>密码：&nbsp;&nbsp;&nbsp;&nbsp;<input type=password name=pwd1></td></tr>
<tr height="30"><td align=center><font size=2 color=red>重复输入：<input type=password name=pwd2></td></tr>
<tr height="30"><td align=center><font size=2 color=red>请选择帐号的类型：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
<?php
foreach($rows as $v){
	echo "<tr height='30'><td align=center><input type=radio name=role value=$v[id]><font size=2 color=red>$v[name]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>";

}
?>
<tr height="30"><td align=center><font size=2 color=red>员工姓名：<input type=text name=member_name></td></tr>
<tr><td align=center><input type=submit value=确定></td></tr>
</table>

</center>
