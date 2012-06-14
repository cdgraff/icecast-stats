<?php

header("icecast-auth-user: 1");

include('db.php');

$post = print_r($_POST, true);

$query = 'INSERT into icecast (icecast_id, ip, mount, agent, referrer, server, port, datetime_start) VALUES ('. $_POST['client'] .', \'' .  $_POST['ip']  . '\', \'' . $_POST['mount']  .'\', \''. $_POST['agent'] .'\', \''. $_POST['referrer'] .'\', \'' . $_POST['server'] .'\', ' . $_POST['port'] .', NOW())';

echo $query;

$result = mysql_query($query);



?>
