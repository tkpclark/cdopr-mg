<script Language="JavaScript">
function ask(id)
{
	var str=
		answer=confirm("确定要删除id="+id+"的记录吗？");
	if(answer=="1")
		return true;
	else 
		return false;
}
</script>
<?php
include("check.php"); 
include("style.php");
?>
<body>
<font size=4><caption>用户列表>></caption></font>
<br><br>
<font size=3><a href='account_edit.php'>添加</a></font><br>

<!--<table border=1 cellspacing="0">-->
<table border="1" cellspacing="0" cellpadding="1" width="50%" class="tabs">

<tr><th><font>序号</th><th><font>用户名</th><th><font>真实姓名</th><th><font>权限</th><th><font>渠道</th><th><font>编辑</th><th><font>删除</th></tr>
<?php

  	$sql="set names utf8";
	mysqli_query($mysqli,$sql) or die (mysqli_error($mysqli));
	//渠道
	$sql="select * from mtrs_cp";
	$result=mysqli_query($mysqli,$sql) or die (mysqli_error($mysqli));
	while($rowcp=mysqli_fetch_assoc($result))
	{
		$rowscp[] = $rowcp;
	}

	$sql="select u.* , r.name as name from wraith_users u left join wraith_role r on u.role=r.id where u.id !=".$_COOKIE['id'];
  $result=exsql($sql);;
  echo "<div align=left><font size=2>共<font color=red>".mysqli_num_rows($result)."</font>条记录";
  while($row=mysqli_fetch_assoc($result))
  {
    echo"<tr>";
		
	echo "<td align=center>$row[ID]</td>";

	  echo "<td align=center>$row[username]</td>";
	  
	 
	  echo "<td align=center>$row[membername]</td>";

	
	  echo "<td align=center>$row[name]</td>";

	$cpname="默认";
	foreach($rowscp as $c){
		if($c['ID']==$row['cpID']){
			$cpname=$c['cpname'];
		}
	}
		echo "<td align=center>$cpname</td>";
	  
		echo "<td align=center><a href=\"account_edit.php?id=$row[ID]\" ><img src='images/b_edit.png' alt='编辑'></a>&nbsp;</td>";
		//delete
		echo "<td align=center onclick=\"return ask($row[ID]);\"><a href=\"del_account.php?id=$row[ID]\" ><img src='images/b_drop.png' alt='删除'></a>&nbsp;</td>";
    echo"</tr>";
  }
?>
</table>

</font>
</body>