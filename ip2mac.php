<?php
for ( $i=0; $i < 3; $i++ )
{
	exec("sudo arp-scan ".$_POST['ip'], $ans);
	if (strcmp("",$ans[2]))
	{
		$data = explode("\t",$ans[2]);
		$mac = strtoupper($data[1]);
		echo $mac;
		return 1;
	}
}
echo "";
return 0;
?>