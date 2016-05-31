<?php
ini_set('display_errors', 'On');
require_once('helpers.php');
require_once('Page.php');

// Create new Page object and display top of page content
$page = new Page();
$page->header = 'Insert Contest into Database';
$page->DisplayTop();

// Extract POST variables
$contest_date = trim($_POST['input_contest_date']);
$contest_state_id = trim($_POST['state_id']);
$contest_party_id = trim($_POST['party_id']);
$contest_type_id = trim($_POST['contest_type_id']);
$contest_delegates = trim($_POST['delegates']);

// Data validation
$dateIsValid = true;

if(!$dateIsValid) {
	echo '<p>Date is not formatted correctly.</p>';
	insert_button("../index.php", "Back");
	exit;
}

// Execute MySQL Query
else {
	// Add slashes if needed
	if (!get_magic_quotes_gpc()) {
		$contest_date = addslashes($contest_date);
		$contest_state_id = addslashes($contest_state_id);
		$contest_party_id = addslashes($contest_party_id);
		$contest_type_id = addslashes($contest_type_id);
		$contest_delegates = addslashes($contest_delegates);
	}

	// connect to DB -- returns null on failure so we exit
	if(($db = connect_to_db()) == null) {
		exit;
	}
	
	// Preload query then fill in the user input (prevents SQL Injection attack)
	$query = 'INSERT INTO contest(contest_date, state_id, party_id, contest_type_id, delegates) VALUES (?, ?, ?, ?, ?)';
	$stmt = $db->prepare($query);
	$stmt->bind_param('siiii', $contest_date, $contest_state_id, $contest_party_id, $contest_type_id, $contest_delegates);
	$stmt->execute();

	// Process results
	if ($db->affected_rows >= 0) {
		echo '<p>'.$db->affected_rows.' contest added to database.</p>';	
	}
	else {
		echo '<p>Unable to add contest to database - probably already exists.</p>';
	}
	
	// Close resources and close connection
	$stmt->close(); // Might be able to move this to right after the ->execute() call??
	$db->close();
}

insert_button("../index.php", "Back");
$page->DisplayBottom();

?>