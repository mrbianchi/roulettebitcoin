<html>
<head>
<style>
body {
	font-family:Consolas;
	color:#20D2AA;
	background-color:black;
	font-size:11px;
}
body a {
	font-family:Consolas;
	color:#20D2AA;
	background-color:black;
	font-size:11px;
}
</style>
</head>
<body>

<?php
ini_set('max_execution_time', 300);
$p[0]=rand(1,904625697);
$p[1]=rand(0,166532776);
$p[2]=rand(0,746648320);
$p[3]=rand(0,380374280);
$p[4]=rand(0,100293470);
$p[5]=rand(0,930272690);
$p[6]=rand(0,489102837);
$p[7]=rand(0,043110636);
$p[8]=rand(0,675);
foreach($p as $key=>$value) if($key != 8) $p[$key] = str_pad($p[$key], 9,"0",STR_PAD_LEFT);
$final = null;
foreach($p as $key=>$value) $final .= $p[$key];
$final = ltrim($final,"0");
echo "<center>Viendo página directory.io/<a href='http://directory.io/$final'>$final</a></center>";
echo "<br>\n";
$json = file_get_contents('http://directory.io/'.$final);
//$json = file_get_contents('http://directory.io/1');

preg_match_all('|<a href="https://blockchain.info/address/(.+)">|U', $json, $match,PREG_PATTERN_ORDER);
$match = $match[1];
$direcciones = array();
foreach($match as $key=>$value) if($key % 2 == 0) array_push($direcciones, $value);
//print_r( ($direcciones));
echo "<table><tr>";
$i=0;
foreach($direcciones as $key=>$value) {
$json = file_get_contents('https://blockchain.info/es/rawaddr/'.$value);
$obj = json_decode($json);
	if($i==4) { $i = 0; echo "</tr><tr>"; }
	if($obj->final_balance>0 || $obj->total_received>0)
	{
		echo "<td style='color:yellow'> $obj->final_balance BTC  <a href='https://blockchain.info/address/$value' style='color:yellow'>$value</a></td>\n";
		$file = 'data.txt';
		$current = file_get_contents($file);
		$current .= "Page $final $value \n";
		file_put_contents($file, $current);
	}else{
		echo "<td>$obj->final_balance BTC <a href='https://blockchain.info/address/$value'><i>$value</i></a></td>\n";
	}
	$i++;
}
echo "</tr></table>";
?>
<script>
location.reload();
</script>
</body>
</html>