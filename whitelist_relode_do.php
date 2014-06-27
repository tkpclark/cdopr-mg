<?php 

	echo "<font size=4 color=red>加载结果:<br><br></font>";
	$cmd = "python /home/tkp/cdopr/src/loadwhitelist/loadwhitelist.py";
	exec($cmd, $output, $result);
	if($result != 0)
		echo "加载失败!<br>";
	else
	{
		foreach($output as $line)
			echo $line."<br>";
	}
?>