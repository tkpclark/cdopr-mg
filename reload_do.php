<?php 
if(!isset($_GET['type']))
{
	echo "arguments error!";
	exit;
}

$type=$_GET['type'];
if($type == '1')
{
	echo "<font size=4 color=red>加载结果:<br><br></font>";
	$cmd = "/home/tkp/restart_cdopr.sh";
	//$cmd='python /home/sms/MsgTunnel/src/msgforward/config_maker.py';
	//echo "cmd: ".$cmd."<br>";
	exec($cmd, $output, $result);
	if($result != 0)
		echo "加载失败!<br>";
	else
	{
		echo "加载成功!<br>";
	}	
}
else if($type == '2')
{
	echo "<font size=4 color=red>加载结果:<br><br></font>";
	$cmd = "python /home/tkp/cdopr/src/loadcodeseg/loadcodeseg.py";
	//$cmd='python /home/sms/MsgTunnel/src/msgforward/config_maker.py';
	//echo "cmd: ".$cmd."<br>";
	exec($cmd, $output, $result);
	if($result != 0)
	{
		echo "加载失败!<br>";
	}
	else
	{
		foreach($output as $line)
			echo $line."<br>";
	}	
}