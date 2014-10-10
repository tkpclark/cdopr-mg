<?php
include("check.php");
include("style.php");
?>
<font size=4><caption>黑名单添加>></caption></font>
<br><br><br>

<table>
<tr>
<td>单个添加</td>
<td>
<form name=wo_blklist_edit_form action='wo_blklist_edit_do.php' method='post' >
手机号码：<input type=text name=phone_number size=30>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=submit name=submit value=添加>
</form>
</td>
</tr>
</table>

