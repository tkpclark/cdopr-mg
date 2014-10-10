<?php 
	include("check.php"); 
	include("style.php");
?>
<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="EditPlus®">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <title>提交投诉</title>
 </head>
 <body>
<div>
	  <form action="message_log_complaint_do.php" method="post" enctype="multipart/form-data">
	  <input type="hidden" name="MAX_FILE_SIZE" value="4000000000">
		提交投诉：<input type="file" name="myfile" >
		<select name='type' >
			<option value='兔'>开森呆萌兔</option>
			<option value='牛'>游戏斗牛</option>
		</select>
		<input type="submit" name="sub" value="提交">
	</form>
</div>
 </body>
</html>