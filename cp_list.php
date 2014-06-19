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
<font size=4><caption>渠道列表>></caption></font>
<br><br>


<font size=3><a href='cp_edit.php'>添加</a></font><br>
<!--<table border=1 cellspacing="0">-->
<table border="1" cellspacing="0" cellpadding="1" width="50%" class="tabs">

<tr><th>序号</th><th>CP名称</th><th>状态</th><th>编辑</th><th>删除</th></tr>
<?php

  $buf= "select * from mtrs_cp";
  $result=exsql($buf);
  echo "<div align=left><font size=2>共<font color=red>".mysqli_num_rows($result)."</font>条记录";
  while($row=mysqli_fetch_row($result))
  {
    echo"<tr>";
		//seq
	  echo "<td align=center>$row[0]</td>";
	  
	  //cp name
	  echo "<td align=center>$row[1]</td>";
	  
	  //status
	  if($row[2]==1)
			echo "<td align=center>正常</td>";
		else if($row[2]==2)
			echo "<td align=center>关闭</td>";
		else
			echo "<td align=center>数据异常</td>";
			
		//modify
	//	echo "<td align=center>编辑</td>";
		echo "<td align=center><a href=\"cp_edit.php?cp_id=$row[0]\" ><img src='images/b_edit.png' alt='编辑'></a>&nbsp;</td>";
		//delete
		echo "<td align=center  onclick=\"return ask($row[0]);\"><a href=\"cp_del.php?cpid=$row[0]\" ><img src='images/b_drop.png' alt='删除'></a>&nbsp;</td>";
    echo"</tr>";
  }
?>
</table>

</font>
</body>
