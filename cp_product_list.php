<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="jquery.js"></script>
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
$(document).ready(function(){
		/*
		//$.setTable();
		 */
		$("see_deduction").click(function(){
			var cpProd=$(this);
			var cpProdID=$(this).parent().parent("tr").children("td:eq(0)").text();
			//var cpProdID=$(this).text();
			//alert(cpProdID);
			$.get("cpProd_display_deduction.php?cpProdID="+cpProdID,function(result){
				$(cpProd).prev().replaceWith(result);
				});
			});
		



});
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

<tr><th>序号</th><th>产品名称</th><th>所属渠道</th><th>上行转发地址</th><th>报告转发地址</th><th>扣量</th><th>备注</th><th>创建时间</th><th>编辑</th><th>删除</th></tr>
<?php

  $buf= "select * from mtrs_cp_product";
  $result=exsql($buf);
  echo "<div align=left><font size=2>共<font color=red>".mysqli_num_rows($result)."</font>条记录";
  while($row=mysqli_fetch_row($result))
  {
    echo"<tr>";
		//id
	  echo "<td align=center>$row[0]</td>";
	  
	  //name				
	  echo "<td align=center>$row[1]</td>";

	  //cpID
	  	$sql = "select cpname from mtrs_cp where id=$row[2]";
		$mtrs_cp_result=exsql($sql);
		$mtrs_cp=mysqli_fetch_row($mtrs_cp_result);
	  echo "<td align=center>$mtrs_cp[0]</td>";

	  //mourl
	  echo "<td align=center>$row[3]</td>";

	  //mrurl
	  echo "<td align=center>$row[4]</td>";
	  

	echo "<td align=center>";
	echo "<display_deduction></display_deduction>";
	//echo "<add_deduction><a href='#'>添加扣量</a></add_deduction>";
	echo "<see_deduction style=''><a href='#'><img src='images/chakan.png' alt='查看扣量' width=16 height=16></a></see_deduction>";
	echo "</td>";


		//remarks
	  echo "<td align=center>$row[5]</td>";

	  //createtime
	  echo "<td align=center>$row[6]</td>";


		//modify
	//	echo "<td align=center>编辑</td>";
		echo "<td align=center><a href=\"cp_product_edit.php?id=$row[0]\" ><img src='images/b_edit.png' alt='编辑'></a>&nbsp;</td>";
		//delete
		echo "<td align=center  onclick=\"return ask($row[0]);\"><a href=\"cp_product_del.php?id=$row[0]\" ><img src='images/b_drop.png' alt='删除'></a>&nbsp;</td>";
    echo"</tr>";
  }
?>
</table>

</font>
</body>
