<?php
require('./config.php');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

if($method === "PUT"){
	$output = array();
	$table = 'public.users';
	$headers = getallheaders();
	$raw = file_get_contents('php://input');
	$data = json_decode($raw, true);

	echo $headers;

	echo json_encode($output);

	pg_close($conn);
}
?>