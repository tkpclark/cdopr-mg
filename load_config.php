<?php include('style.php'); ?>
	
<font size=4><caption>重新加载配置>></caption></font>
<br><br><br>
<font size=4 color=red>最后加载日期:<br><br></font>


<form name=load_config method=post action=load_config.php?load=1 >
<input type=submit name='submit' value='重新加载配置'  style="width:250px;height:500px;">
</form>


<?php

if(isset($_GET['load']))
{
	echo "<font size=4 color=red>加载结果:<br><br></font>";
	$cmd = "/home/app/wraith/src/controller/start_controller.sh";
	//$cmd='python /home/sms/MsgTunnel/src/msgforward/config_maker.py';
	//echo "cmd: ".$cmd."<br>";
	exec($cmd, $output, $result);
	if($result != 0)
		echo "加载失败!<br>";
	else
		echo $output[0];
	//var_dump($output);
}
?>