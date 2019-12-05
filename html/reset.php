<?php
require_once('./includes/dbconnect.php');
if(isset($_GET['token'])){
	$sql = "DELETE FROM data WHERE token = (?)";
	if($stmt = mysqli_prepare($connection, $sql)){
		mysqli_stmt_bind_param($stmt,'s', $_GET['token']);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}

	$sql = "INSERT INTO data (token, trigger_time) VALUES (?, ?)";
	if($stmt = mysqli_prepare($connection, $sql)){
		if(isset($_GET['delay']) && ctype_digit($_GET['delay'])){
		   $delay = (int)$_GET['delay'];
		   if($delay<180){
			   $delay = 180;
		   }
		} else {
			$delay = 3600;
		}
		$delay += time();
		mysqli_stmt_bind_param($stmt,'si', $_GET['token'], $delay);
		mysqli_stmt_execute($stmt);
	}
	mysqli_stmt_close($stmt);
	mysqli_close($connection);
	echo("ok");
} else {
	echo("no token");
}

?>

