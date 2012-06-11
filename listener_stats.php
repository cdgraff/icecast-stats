<?php
// Written by Brett Jenkins for Xtreme Radio in July/August 2009
// www.brettjenkins.co.uk

include('db.php');
?>
<html>
<head>
<title>Listener Stats - Cienradios.com.ar</title>
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

$post = print_r($_POST, true);

$query = 'SELECT * from icecast ORDER by id DESC LIMIT 1';

echo "<h2>Most recent first, will only show 100 sessions.</h2>";


$result = mysql_query($query);


$col = mysql_fetch_array($result);

$col = array_keys($col);

echo '<table bgcolor="black"><tr>';

foreach($col as $key=>$value){
	
	if(!is_numeric($value)){
		
		echo '<td bgcolor="white"><b>' . $value .'</b></td>';
		
	}
	
}

echo '</tr>';

$query = 'SELECT * from icecast ORDER by id DESC LIMIT 100';
$result = mysql_query($query);

while($row = mysql_fetch_array($result)){
	echo '<tr>';
//	print_r($row);
	
	foreach($row as $key=>$value){
		
		if(!is_numeric($key)){
		echo '<td ';
		if($row['duration'] == null){
		echo 'bgcolor=green';
		}else{
		echo 'bgcolor="white"';
		}
		echo '>';
		if($key == 'duration'){
			if($value == null){
				echo 'So far... ';
				echo strTime(time() - strtotime($row['datetime_start']));
			}else{
			echo strTime($value);
		}
		}else{
			echo $value;
		}
		echo '</td>';
	}
		
	}
	echo '</tr>';
}
echo '</table>'
?>
</body>
</html>
