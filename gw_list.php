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
<font size=4><caption>网关列表>></caption></font>
<br><br>
<font size=3><a href='gw_edit.php'>添加</a></font><br>

<!--<table border=1 cellspacing="0">-->
<table border="1" cellspacing="0" cellpadding="1" width="50%" class="tabs">

<tr><th><font color=red size=2>序号</th><th><font color=red size=2>网关名称</th><th><font color=red size=2>状态</th><th><font color=red size=2>所属</th><th><font color=red size=2>编辑</th><th><font color=red size=2>删除</th></tr>
<?php

  $buf= "select * from wraith_gw";
  $result=exsql($buf);;
  echo "<div align=left><font size=2>共<font color=red>".mysqli_num_rows($result)."</font>条记录";
  while($row=mysqli_fetch_row($result))
  {
    echo"<tr>";
		//seq
	  echo "<td align=center><font size=2>$row[0]</td>";
	  
	  //sp name
	  echo "<td align=center><font size=2>$row[1]</td>";
	  
	  //status
	  if($row[2]==1)
			echo "<td align=center><font size=2>有效</td>";
		else
			echo "<td align=center><font size=2>无效</td>";
	
	//belongto
	  if($row[3]==1){
			echo "<td align=center><font size=2>自有</td>";
	  }elseif($row[3]==2){
			echo "<td align=center><font size=2>合作方</td>";
	  }else{echo "<td align=center><font size=2></td>";}
		//modify
	//	echo "<td align=center><font size=2>编辑</td>";
		echo "<td align=center><font size=2><a href=\"gw_edit.php?id=$row[0]\" >编辑</a>&nbsp;</td>";
		//delete
		echo "<td align=center onclick=\"return ask($row[0]);\"><font size=2><a href=\"gw_del.php?id=$row[0]\" >删除</a>&nbsp;</td>";
    echo"</tr>";
  }
?>
</table>

</font>
</body>