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
	$(".update").click(function() {
		var type = $(this).attr('_type');
		var id = $(this).attr('_id');
		var obj = $(this);
		if(obj.has('input').length){
			return;
		}
		var org = obj.html();
		obj.html('');
		obj.append("<input type='text' style='width:70px;height:20px' value='"+org+"'/>"); 
		var input = obj.find('input');
		input.focus();
		input.blur(function(){
			var inputval = input.val();
			if((parseInt(inputval)==0 || isNaN(parseInt(inputval)))){inputval=0}
			obj.empty();
			obj.html(inputval);
			if(org!=inputval){
				$.ajax({
					type: "GET",
					url: 'wo_deduction_ajax.php?id='+id+'&type='+type+'&inputval='+inputval,
					cache:false,
					success: function(msg){
					if(msg!=1){alert("失败")}
					// alert(msg)
					}
				});
			}
		});
	})

	$(".parent").click(function (){
		var num = $(this).attr('_num');
		var dis = $('.child'+num).css("display");
		if(dis == 'none'){
			$('.child'+num).css("display","");
		}else{
			$('.child'+num).css("display","none");
		}
	
	});

});

</script>
<?php
include("check.php"); 
include("style.php");
?>
<body>
<font size=4><caption>wo+扣量列表>></caption></font>
<br><br>
<font size=3><a href='wo_deduction_edit.php'>添加</a></font><br>
<!--<table border=1 cellspacing="0">-->
<table border="1" cellspacing="0" cellpadding="1" width="50%" class="tabs">

<tr><th>序号</th><th>渠道名称</th><th>省份</th><th>上行扣量(%)</th><th>下行扣量(%)</th><th>操作</th></tr>
<?php
	$default=$province=array();
  $sql= "select * from wraith_wo_deduction";
  $result=exsql($sql);
  while($row=mysqli_fetch_row($result))
  {
	if($row[2]=='默认'){
		$default[]=$row;
	}else{
		$province[]=$row;
	}
  }
  //echo "<div align=left><font size=2>共<font color=red>".mysqli_num_rows($result)."</font>条记录";
  foreach($default as $row)
  {
    echo "<tr>";

	  echo "<td align=center class='parent' _num='".$row[0]."'><span style='float:left'>+</span>$row[0]</td>";

	  echo "<td align=center>$row[1]</td>";

	  echo "<td align=center>$row[2]</td>";

	  echo "<td align=center class='update' _type='up' _id='$row[0]' _pro='$row[1]'>$row[3]</td>";
	  
	  echo "<td align=center class='update' _type='down' _id='$row[0]' _pro='$row[1]'>$row[4]</td>";

	  echo "<td align=center onclick=\"return ask($row[0]);\">--</td>";
    echo"</tr>";
	foreach($province as $p){
		if($p[1]==$row[1]){
			echo"<tr class='child".$row[0]."' style='display:none'>";
			echo "<td align=center></span>$p[0]</td>";
 
			echo "<td align=center>$p[1]</td>";

			echo "<td align=center>$p[2]</td>";

			echo "<td align=center class='update' _type='up' _id='$p[0]' _pro='$p[1]'>$p[3]</td>";

			echo "<td align=center class='update' _type='down' _id='$p[0]' _pro='$p[1]'>$p[4]</td>";

			echo "<td align=center onclick=\"return ask($p[0]);\"><a href=\"wo_deduction_del.php?did=$p[0]\" ><img src='images/b_drop.png' alt='删除'></a>&nbsp;</td>";
			echo"</tr>";
		}
	}

  }
?>
</table>

</font>
</body>
