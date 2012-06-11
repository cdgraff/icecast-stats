<?php

include('db.php');

$post = print_r($_POST, true);


$query = 'UPDATE icecast SET duration = '. $_POST['duration'] .', datetime_end = NOW() WHERE icecast_id = '.$_POST['client'].' ORDER BY id DESC LIMIT 1';

echo $query;

$result = mysql_query($query);


?>
