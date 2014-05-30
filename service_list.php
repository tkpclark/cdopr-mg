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
<font size=4><caption>通道业务列表>></caption></font>
<br><br>
<font size=3><a href='service_edit.php'>添加</a></font><br>

<!--<table border=1 cellspacing="0">-->
<table border="1" cellspacing="0" cellpadding="1" width="50%" class="tabs">

<tr>
	<th>序号</th>
	<th>业务名称</th>
	<th>spnumber</th>
	<th>mo指令</th>
	<th>资费</th>
	<th>计费代码</th>
	<th>网关</th>
	<th>信息类型</th>
	<th>所属通道</th>	
	<th>状态</th>
	<th>编辑</th>
	<th>删除</th>
</tr>
<?php

  $buf= "select * from mtrs_service";
  $result=exsql($buf);
  echo "<div align=left><font size=2>共<font color=red>".mysqli_num_rows($result)."</font>条记录";
  while($row=mysqli_fetch_row($result))
  {
    echo"<tr>";
		//seq
	  echo "<td align=center><font size=2>$row[0]</td>";
	  
	  
	  //name
	  echo "<td align=center><font size=2>$row[3]</td>";
	  
	  //sp number
	  echo "<td align=center><font size=2>$row[1]</td>";
	  
	  //mocmd
	  echo "<td align=center><font size=2>$row[2]</td>";
	  
	  //fee
	  echo "<td align=center><font size=2>$row[7]</td>";
	  
	  //service_id
	  echo "<td align=center><font size=2>$row[10]</td>";
	  
	  //gwid
	  if($row[11])
	  {
	  	$sql="select id,comment from wraith_gw where ID=$row[11]";
		$result_gwname=exsql($sql);
	  	$row_gwname=mysqli_fetch_row($result_gwname);
	  	$gwname="($row_gwname[0])".$row_gwname[1];
	  	echo "<td align=center><font size=2>$gwname</td>";
	  }
	  else
	  	echo "<td align=center><font size=2></td>";
	  
	  //msgtype
	  if($row[4]==1)
			echo "<td align=center><font size=2>短信</td>";
		else if($row[4]==2)
			echo "<td align=center><font size=2>彩信</td>";
		else
			echo "<td align=center><font size=2>数据异常</td>";
	  
	  //belong which sp
	  //get spname
		$sql="select spname from mtrs_sp where ID=$row[6]";
		$result_spname=exsql($sql);
	  	$row_spname=mysqli_fetch_row($result_spname);
	  	$spname=$row_spname[0];
	  	echo "<td align=center><font size=2>$spname</td>";
	  
	  //status
	  if($row[5]==1)
			echo "<td align=center><font size=2>正常</td>";
		else if($row[5]==2)
			echo "<td align=center><font size=2>关闭</td>";
		else
			echo "<td align=center><font size=2>数据异常</td>";
			
		//modify
	//	echo "<td align=center><font size=2>编辑</td>";
		echo "<td align=center ><font size=2><a href=\"service_edit.php?serviceID=$row[0] \" ><img src='images/b_edit.png' alt='编辑'></a>&nbsp;</td>";
		//delete
		echo "<td align=center onclick=\"return ask($row[0]);\"><font size=2><a href=\"service_del.php?serviceid=$row[0]\" ><img src='images/b_drop.png' alt='删除'></a>&nbsp;</td>";
    echo"</tr>";
  }
?>
</table>

</font>
</body>
