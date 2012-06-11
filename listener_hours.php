<?php
// Written by Brett Jenkins for Xtreme Radio in July/August 2009
// www.brettjenkins.co.uk

include('db.php');
?>
<html>
<head>
<title>Listener Hours - Cienradios.com.ar</title>
<style>
body{
	font-family:arial;
}
</style>
</head>
<body>
<?php

function strTime($s) {
  $d = intval($s/86400);
  $s -= $d*86400;

  $h = intval($s/3600);
  $s -= $h*3600;

  $m = intval($s/60);
  $s -= $m*60;

  if ($d) $str = $d . 'd ';
  if ($h) $str .= $h . 'h ';
  if ($m) $str .= $m . 'm ';
  if ($s) $str .= $s . 's';

  return $str;
}


if(!isset($_GET['start'])){
	$query = 'SELECT datetime_start as start
	FROM `icecast` ORDER BY id LIMIT 1';
	
	$result = mysql_query($query);

	$row = mysql_fetch_array($result);
	
	$start = $row['start'];
}else{
	$start = $_GET['start'];
}
if(!isset($_GET['end'])){
	$end = date("Y-m-d H:i:s");
}else{
	$end = $_GET['end'];
}



$query = 'SELECT datetime_start as start FROM icecast WHERE duration is null';
$result = mysql_query($query);
$total = 0;
$listeners = 0;
while($row = mysql_fetch_array($result)){
	$temp = time() - strtotime($row['start']);
	$total = $total + $temp;
	$listeners++;
}

$current = $total;
unset($total);

$query = 'SELECT sum( duration ) as duration, avg( duration ) as average, count( id ) as listeners
FROM `icecast` WHERE datetime_start >= \''.$start.'\' AND datetime_end <= \''.$end.'\'';

echo '<h1>Total Listener Hours</h1>';

//echo $query;

echo '<form action="" method="GET"><br />
Format is: YYYY-MM-DD HH:MM:SS <br />
You don\'t have to supply all the date, so for example:<br />
2009 will work, as will 2009-09 and 2009-01-08 and 2009-01-09 08<br /><br /><table>
<tr><td>Start:</td><td><input type="text" name="start" value="'.$start .'"></td></tr>
<tr><td>End:</td><td><input type="text" name="end" value="'. $end .'"></td></tr>
<tr><td></td><td><input type="submit" value="get"></td></tr></table></form>';
if((isset($_GET['start'])) OR (isset($_GET['end']))){
echo '<a href="?">Go to All Time stats</a><br />';
}

$result = mysql_query($query);

$row = mysql_fetch_array($result);
echo '<br />';

//echo $row['duration'] .' seconds - which is:<Br />';
/*
$secs = $row['duration'];
$mins = $row['duration'] / 60;

$hours = floor($mins / 60);

$mins = floor($mins - (floor($hours) * 60));

if($mins < 10){
	$mins = '0'.$mins;
}

$secs = $secs - (($hours * 60 * 60) + ($mins * 60));

echo $hours.' hours '.$mins.' mins '.$secs.' secs';
*/


echo '<br /><b>Current Listeners:</b> '.$listeners .'<br /><b>Current Listener Duration (so far):</b> '.strTime($current).'<br /><br /><b>Total Listener Duration:</b> ';
$hours = ((($row['duration'] + $current) /60)/60);
$secs = ($row['duration'] + $current) - ((floor($hours)*60)*60);
$mins = $secs / 60;
echo strTime($row['duration'] + $current) . '<br /><b>AKA:</b> ' . floor($hours) .' hours and '.round($mins).' minutes<br />';

echo '<br /><b>Average Listener Duration</b> <i>(Rounded - Doesn\'t include listeners who are still listening)</i>: ';
echo strTime(round($row['average']));



echo '<br /><b>Max Listener Sessions:</b> ';

echo $row['listeners'];


?>

</body>
</html>
