<?php
require('./config.php');

$output = array();

if ($method === "PUT") {
	$headers = getallheaders();
	$token = preg_split('/\s/', $headers['Authorization'])[1];
	
	$raw = file_get_contents('php://input');
	$data = json_decode($raw, true);
	
	$first_name = $data['first_name'];
	$last_name = $data['last_name'];

	$query = "UPDATE " . $users_table . " SET {$db_first_name_key} = '" . $first_name . "', {$db_last_name_key} = '" . $last_name . "' 
	WHERE ${$db_token_key} = '" . $token . "' RETURNING first_name, last_name, username, token";

	$result = pg_query($conn, $query);

	if ($row = pg_fetch_assoc($result)) {
		$output = array(
			'status_code' => 200,
			'message' => 'Profile updated!',
			'profile' => $row
		);
	}
	else {
		$output = array(
			'status_code' => 301,
			'message' => 'An error has occur, please try again.'
		);
	}
}

echo json_encode($output);

pg_close($conn);
?>