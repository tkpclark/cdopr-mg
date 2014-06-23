<?php 
	include("check.php"); 
	include("style.php");
	$membername = @$_COOKIE['membername'];
	$id = @$_COOKIE['id'];

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
<font size=4 color=red>修改用户：</font>
<br><br>
<center>

<table border="1" cellspacing="0" cellpadding="1" width="410" >
<form action=update_accountpro.php name=form1 method=post onsubmit="return checkpwd();">
<input type=hidden name=id value="<?php echo $id;?>">
<?php if(isset($j))echo "<input type=hidden name=j value='标识'>";?>
<tr height="30"><td align=center><font size=2 color=red>密码：&nbsp;&nbsp;&nbsp;&nbsp;<input type=password name=pwd1></td></tr>
<tr height="30"><td align=center><font size=2 color=red>重复输入：<input type=password name=pwd2></td></tr>
<tr height="30"><td align=center><font size=2 color=red>姓名：&nbsp;&nbsp;&nbsp;&nbsp;<input type=text name='member_name' value="<?php echo $membername;?>"></td></tr>
<tr><td align=center><input type=submit value=确定></td></tr>
</table>

</center>