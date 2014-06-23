<?php include('style.php'); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title> </title>
<script language="Javascript" src="calendar/js/JQUERY.JS"></script>
<script Language="JavaScript">
$(document).ready(function(){	

  $("#d1").click(function(){
	$('#result').text("正在执行指令，请稍候...");
    $('#result').load('blklist_relode_do.php');
  })
})
</script>
	
<font size=4><caption>重新加载>></caption></font>
<br><br><br>


<button id="d1" type="button">重新加载黑名单数据</button>
<br><br><br>
<div id='result'></div>