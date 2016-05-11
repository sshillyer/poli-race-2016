<?php
ini_set('display_errors', 'On');
require_once('helpers.php');
require_once('Page.php');

// Create new Page object and display top of page content
$page = new Page();
$page->header = 'Insert Party into Database';
$page->DisplayTop();

// Extract the post variables
$party_name = trim($_POST['input_party_name']);

// Data validation
define('PARTY_MIN', 3);
define('PARTY_MAX', 255);
$party_name_is_valid = has_length_in_range($party_name, PARTY_MIN, PARTY_MAX);

if (!$party_name_is_valid) {
	echo '<p>Party name must be at least '.PARTY_MIN.' letters long.<p>';
	insert_button("../index.php", "Back");
	exit;
}

// Execute MySQL Query
else {	
	// Add slashes if needed
	if (!get_magic_quotes_gpc()) {
		$party_name = addslashes($party_name);
	}

	// connect to DB -- returns null on failure so we exit
	if(($db = connect_to_db()) == null) {
		exit;
	}
	
	// Preload query then fill in the user input (prevents SQL Injection attack)
	$query = 'INSERT INTO party(name) VALUES(?)';
	$stmt = $db->prepare($query);
	$stmt->bind_param('s', $party_name);
	$stmt->execute();

	// Process results
	if ($db->affected_rows >= 0) {
		echo '<p>'.$db->affected_rows.' party added to database.</p>';
	}
	else {
		echo '<p>Unable to add state to database - probably already exists.</p>';
	}

	// Close resources and close connection
	$stmt->close(); // Might be able to move this to right after the ->execute() call??
	$db->close();
}

insert_button("../index.php", "Back");
$page->DisplayBottom();

?>
    