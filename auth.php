<?php
require('./config.php');

if($method === "POST"){
	$output = array();
	$purpose = $_GET['purpose'];
	$table = 'public.auth';

	// LOGIN
	if ($purpose === 'login') {
		$raw = file_get_contents('php://input');
		$data = json_decode($raw, true);

    $phone_number = $data['phone_number'];
    $password = $data['password'];

		$query = "SELECT token, u_id, first_name, last_name, phone_number 
			FROM " . $table . "
			WHERE phone_number = '" . $phone_number . "'
			AND password = '" . $password . "'";
		
		echo $query;
    // $result = pg_query($conn, $query);

		// Login Successful
    // if ($row = pg_fetch_assoc($result)) {
		// 	$output = $row;
    // }
		// Login Failed
		// else {
		// 	$output = array(
		// 		'status_code' => 301,
		// 		'error_message' => 'Wrong username or password. Please try again.',
		// 	);
		// }
	}
	// REGISTER
	else if ($purpose === 'reg') {
		$raw = file_get_contents('php://input');
		$data = json_decode($raw, true);

		$token = bin2hex(openssl_random_pseudo_bytes(20));

		echo $token;
	}
	else {
    $output = array(
			'status_code' => 500,
			'error_message' => 'Invalid Request',
		);
	}

	echo json_encode($output);

	pg_close($conn);
}
?>