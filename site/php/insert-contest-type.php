<?php
ini_set('display_errors', 'On');
require_once('helpers.php');
require_once('Page.php');

// Create new Page object and display top of page content
$page = new Page();
$page->header = 'Insert Contest Type into Database';
$page->DisplayTop();

// Extract POST variables
$contest_type = trim($_POST['input_contest_type']);

// Data validation
define('CTYPE_MIN', 3);
define('CTYPE_MAX', 255);
$contest_type_is_valid = has_length_in_range($contest_type, CTYPE_MIN, CTYPE_MAX);

if (!$contest_type_is_valid) {
	echo '<p>Contest type must be at least '.CTYPE_MIN.' letters long.</p>';
	insert_button("../index.php", "Back");
	exit;
}	

else {
	// Add slashes if needed
	if (!get_magic_quotes_gpc()) {
		$contest_type = addslashes($contest_type);
	}

	// connect to DB -- returns null on failure so we exit
	if(($db = connect_to_db()) == null) {
		exit;
	}
	
	// Preload query then fill in the user input (prevents SQL Injection attack)
	$query = 'INSERT INTO contest_type(name) VALUES(?)';
	$stmt = $db->prepare($query);
	$stmt->bind_param('s', $contest_type);
	$stmt->execute();

	// Process results
	if ($db->affected_rows >= 0) {
		echo '<p>'.$db->affected_rows.' contest type added to database.</p>';
	}
	else {
		echo '<p>Unable to add contest type to database - probably already exists.</p>';
	}
	
	// Close resources and close connection
	$stmt->close(); // Might be able to move this to right after the ->execute() call??
	$db->close();
}

insert_button("../index.php", "Back");
$page->DisplayBottom();

?>