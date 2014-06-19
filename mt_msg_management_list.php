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
<font size=4><caption>下发语列表>></caption></font>
<br><br>
<font size=3><a href='mt_msg_management_edit.php'>添加</a></font><br>

<!--<table border=1 cellspacing="0">-->
<table border="1" cellspacing="0" cellpadding="1" width="50%" class="tabs">

<tr><th><font>序号</th><th><font>下发语</th><th><font>通道业务</th><th><font>类型</th><th><font>编辑</th><th><font>删除</th></tr>
<?php

  $buf= "select * from wraith_mt_msg_management";
  $result=exsql($buf);;
  echo "<div align=left><font size=2>共<font color=red>".mysqli_num_rows($result)."</font>条记录";
  while($row=mysqli_fetch_row($result))
  {
    echo"<tr>";
		//seq
	  echo "<td align=center>$row[0]</td>";
	  
	  //message
	  echo "<td align=center>$row[1]</td>";

	  //serviceID
		$s = "select t1.id,t1.sp_number,t1.mo_cmd,t1.name,t2.id,t2.spname from mtrs_service t1,mtrs_sp t2 where t1.id=$row[2] and t1.spID=t2.ID";
		$r = exsql($s);
		$ro = mysqli_fetch_row($r);
		
		if(mysqli_num_rows($r))
		{
		//service
		echo "<td align=center>($ro[4])$ro[5]-($ro[0])$ro[3] $ro[1]+$ro[2] </td>";

		}
	  
	  //msgtype1：sp下发语 2：运营商下发语
	  if($row[3]==1)
			echo "<td align=center>sp下发语</td>";
		else if($row[3]==2)
			echo "<td align=center>运营商下发语</td>";
		else
			echo "<td align=center>数据异常</td>";
			
		//modify
	//	echo "<td align=center>编辑</td>";
		echo "<td align=center><a href=\"mt_msg_management_edit.php?id=$row[0]\" ><img src='images/b_edit.png' alt='编辑'></a>&nbsp;</td>";
		//delete
		echo "<td align=center onclick=\"return ask($row[0]);\"><a href=\"mt_msg_management_del.php?id=$row[0]\" ><img src='images/b_drop.png' alt='删除'></a>&nbsp;</td>";
    echo"</tr>";
  }
?>
</table>

</font>
</body>
