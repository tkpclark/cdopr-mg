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
function change(type){ 
	var val = $("#"+type+"ID").val();
	  $.get("message_log_json.php", { type: type, id: val },
		  function(data){
			if(type=='sp'){
				$("#serverid").html(data);
			}else{
				$("#serverid").html(data);
			}
		  });
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

<form name=pn_inq action="service_list.php" method=post>
 <table><tr><td>
 
 通道<select id='spID' name='spID' onchange="change('sp')">
		<option value="">全部</option>
<?php
	$where=" 1";
	if(isset($_POST['spID']) && !empty($_POST['spID'])){

		$where .= " and spID = ".$_POST['spID'];
	}

 	$sql="select ID,spname from mtrs_sp";
 	$result=exsql($sql);
 	while($row=mysqli_fetch_row($result))
 	{
 		if(isset($_POST['spID']) && !empty($_POST['spID']) && $_POST['spID']==$row[0]){
 			echo "<option value=$row[0] selected>($row[0])$row[1]</option>";
		}else{
			echo "<option value=$row[0]>($row[0])$row[1]</option>";
		}
 	}
?>
 	</select>
 
 通道业务<select id='serverid' name='serverid' onchange=><option value="">全部</option>
<?php
	
	

 	$sql="select ID,name,sp_number,mo_cmd from mtrs_service where ".$where;
 	$result=exsql($sql);
 	while($row=mysqli_fetch_row($result))
 	{	
		if(isset($_REQUEST['serverid']) && !empty($_REQUEST['serverid']) && $_REQUEST['serverid']==$row[0]){
 			echo "<option value=$row[0] selected>($row[0])$row[1]-$row[2]-$row[3]</option>";
		}else{
			echo "<option value=$row[0]>($row[0])$row[1]-$row[2]-$row[3]</option>";
		}
 	}


	if(isset($_REQUEST['serverid']) && !empty($_REQUEST['serverid'])){

		$where .= " and ID = ".$_REQUEST['serverid'];
	}
?>
</select><input type=submit name=submit value=查询></td></tr></table></form>

<!--<table border=1 cellspacing="0">-->
<table border="1" cellspacing="0" cellpadding="1" width="50%" class="tabs">

<tr>
	<th>序号</th>
	<th>业务名称</th>
	<th>spnumber</th>
	<th>mo指令</th>
	<th>资费(元)</th>
	<th>计费代码</th>
	<th>网关</th>
	<th>信息类型</th>
	<th>计费类型</th>
	<th>所属通道</th>	
	<th>状态</th>
	<th>编辑</th>
	<th>删除</th>
</tr>
<?php

  $buf= "select * from mtrs_service where ".$where;
  //echo $buf;
  $result=exsql($buf);
  echo "<div align=left><font size=2>共<font color=red>".mysqli_num_rows($result)."</font>条记录";
  while($row=mysqli_fetch_row($result))
  {
    echo"<tr>";
		//seq
	  echo "<td align=center>$row[0]</td>";
	  
	  
	  //name
	  echo "<td align=center>$row[3]</td>";
	  
	  //sp number
	  echo "<td align=center>$row[1]</td>";
	  
	  //mocmd
	  echo "<td align=center>$row[2]</td>";
	  
	  //fee
	  echo "<td align=center>".number_format($row[7]/100,2)."</td>";
	  
	  //service_id
	  echo "<td align=center>$row[10]</td>";
	  
	  //gwid
	  if($row[11])
	  {
	  	$sql="select id,comment from wraith_gw where ID=$row[11]";
		$result_gwname=exsql($sql);
	  	$row_gwname=mysqli_fetch_row($result_gwname);
	  	$gwname="($row_gwname[0])".$row_gwname[1];
	  	echo "<td align=center>$gwname</td>";
	  }
	  else
	  	echo "<td align=center></td>";
	  
	  //msgtype
	  if($row[4]==1)
			echo "<td align=center>短信</td>";
		else if($row[4]==2)
			echo "<td align=center>彩信</td>";
		else
			echo "<td align=center>数据异常</td>";
	  
		 //msgtype
	  if($row[8]==1)
			echo "<td align=center>点播</td>";
		else if($row[8]==2)
			echo "<td align=center>包月</td>";
		else if($row[8]==3)
			echo "<td align=center>包月话单</td>";

	  //belong which sp
	  //get spname
		$sql="select spname from mtrs_sp where ID=$row[6]";
		$result_spname=exsql($sql);
	  	$row_spname=mysqli_fetch_row($result_spname);
	  	$spname=$row_spname[0];
	  	echo "<td align=center>$spname</td>";
	  
	  //status
	  if($row[5]==1)
			echo "<td align=center>正常</td>";
		else if($row[5]==2)
			echo "<td align=center>关闭</td>";
		else
			echo "<td align=center>数据异常</td>";
			
		//modify
	//	echo "<td align=center>编辑</td>";
		echo "<td align=center ><a href=\"service_edit.php?serviceID=$row[0] \" ><img src='images/b_edit.png' alt='编辑'></a>&nbsp;</td>";
		//delete
		echo "<td align=center onclick=\"return ask($row[0]);\"><a href=\"service_del.php?serviceid=$row[0]\" ><img src='images/b_drop.png' alt='删除'></a>&nbsp;</td>";
    echo"</tr>";
  }
?>
</table>

</font>
</body>
