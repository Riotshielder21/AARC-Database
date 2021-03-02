<?php
	$mysqli = new mysqli($host, $username, $pword, $database);
	if ($mysqli->connect_errno){
	echo "failed to connect to MySQL: (".$mysqli->connect_errno.") " . $mysqli-connect_error;
	die;
	}
?>