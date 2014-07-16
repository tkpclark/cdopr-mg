<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title> </title>
<script language="Javascript" src="calendar/js/JQUERY.JS"></script>
 </head>
 <body>
 <?php 
	include("check.php"); 
	include("style.php");
?>
<font size=4><caption>新增上行>></caption></font>
<br><br><br>

<form name='form' ENCTYPE="multipart/form-data"  method=post action='fake_mos_do.php'>

<table>

<?php
	$sql= "select c.mo_cmd,c.sp_number from mtrs_cmd c ,mtrs_service s where s.gwid=40 and s.ID=c.serviceID";
	$result=exsql($sql);
	while($row=mysqli_fetch_row($result))
	{
		$rows[]=$row;
	}
?>
<tr>
	<th>手机号码</th>
	<td align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="hidden" name="MAX_FILE_SIZE"  value="10000000">
		请选取文件:  
		<input NAME="phone_number" TYPE="file">
	</td>
</tr>

<tr>
	<th>spnumber+mo_message</th>
	<td align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<select name='spnumber_mo_message' style="width:170">
		<?php
			foreach($rows as $r)
			{
				echo "<option value='$r[1]-$r[0]'>$r[1]+$r[0]</option>";
			}
		?>
		</select>
	</td>
</tr>
	
</table>
 <br>

 <input type='submit' name="submit" value="添加">
</form>
 </body>
</html>