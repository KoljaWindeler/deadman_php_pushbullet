<?php
require_once('./includes/dbconnect.php');

function send_pushbullet_msg($credentials,$title,$body) {
	date_default_timezone_set('UTC');
	error_reporting (E_ALL);
	$url = "https://api.pushbullet.com/v2/pushes";
	$type = "note";

	//process parameters
	$quiet = true; //silent mode
	$headers = false; //show headers for debugging
	$post_fields = json_encode(compact('type', 'title', 'body'));
	$ch = curl_init();
	$options = [
		CURLOPT_URL => $url,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_MAXREDIRS => 6,
		CURLOPT_HTTPHEADER => ['Access-Token: ' . $credentials,
					'Content-Type: application/json',
					'Content-Length: ' . strlen($post_fields)],
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => $post_fields,
		CURLOPT_HEADER => $headers,
	];
	curl_setopt_array($ch, $options);
	$result = curl_exec($ch);
	$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
	return $result;
}

$delete_ids= array();
$sql = "SELECT * FROM data WHERE trigger_time<".time().";";
$result = $connection->query($sql);
while($row = $result->fetch_assoc()) {
	send_pushbullet_msg($row['token'],"Dead man switch","Your dead man switch just triggered");
	array_push($delete_ids,$row['id']);
}

$sql = "DELETE from data WHERE id IN (".implode(',',$delete_ids).");";
$connection->query($sql);
mysqli_close($connection);
?>
