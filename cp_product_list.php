﻿<script Language="JavaScript">
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
<font size=4><caption>渠道业务管理列表>></caption></font>
<br><br>


<font size=3><a href='cp_product_edit.php'>添加</a></font><br>
<!--<table border=1 cellspacing="0">-->
<table border="1" cellspacing="0" cellpadding="1" width="50%" class="tabs">

<tr><th>序号</th><th>产品名称</th><th>cp名称</th><th>mourl</th><th>mrurl</th><th>黑名单检测</th><th>同步</th><th>是否询问mt消息</th><th>备注</th><th>创建时间</th><th>编辑</th><th>删除</th></tr>
<?php

  $buf= "select * from wraith_cp_product";
  $result=exsql($buf);
  echo "<div align=left><font size=2>共<font color=red>".mysqli_num_rows($result)."</font>条记录";
  while($row=mysqli_fetch_row($result))
  {
    echo"<tr>";
		//id
	  echo "<td align=center><font size=2>$row[0]</td>";
	  
	  //name				
	  echo "<td align=center><font size=2>$row[1]</td>";

	  //cpID
	  	$sql = "select cpname from mtrs_cp where id=$row[2]";
		$mtrs_cp_result=exsql($sql);
		$mtrs_cp=mysqli_fetch_row($mtrs_cp_result);
	  echo "<td align=center><font size=2>$mtrs_cp[0]</td>";

	  //mourl
	  echo "<td align=center><font size=2>$row[3]</td>";

	  //mrurl
	  echo "<td align=center><font size=2>$row[4]</td>";
	  
	  //checkblk
	  if($row[5]==1)
			echo "<td align=center><font size=2>是</td>";
		else
			echo "<td align=center><font size=2>否</td>";

		//synctype
	  if($row[6]==1)
			echo "<td align=center><font size=2>momr一次同步</td>";
		else
			echo "<td align=center><font size=2>momr分开同步</td>";

		//mt_method
	  if($row[7]==1)
			echo "<td align=center><font size=2>向合作方询问mt消息</td>";
		else
			echo "<td align=center><font size=2>自己生成mt消息</td>";
	
		//remarks
	  echo "<td align=center><font size=2>$row[8]</td>";

	  //createtime
	  echo "<td align=center><font size=2>$row[9]</td>";


		//modify
	//	echo "<td align=center><font size=2>编辑</td>";
		echo "<td align=center><font size=2><a href=\"cp_product_edit.php?id=$row[0]\" >编辑</a>&nbsp;</td>";
		//delete
		echo "<td align=center  onclick=\"return ask($row[0]);\"><font size=2><a href=\"cp_product_del.php?id=$row[0]\" >删除</a>&nbsp;</td>";
    echo"</tr>";
  }
?>
</table>

</font>
</body>
