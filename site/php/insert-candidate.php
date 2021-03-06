<?php
ini_set('display_errors', 'On');
require_once( 'helpers.php' );
require_once("Page.php");

// Create new Page object and display top of page content
$page = new Page();
$page->header = 'Insert Candidate into Database';
$page->DisplayTop();

// Extract POST variables
$candidate_fname = trim($_POST['input_candidate_fname']);
$candidate_lname = trim($_POST['input_candidate_lname']);
$candidate_party_id = trim($_POST['party_id']);

// Data Validation
define('NAME_MIN', 3);
define('NAME_MAX', 255);
$candidate_name_is_valid = (has_length_in_range($candidate_fname, NAME_MIN, NAME_MAX) && has_length_in_range($candidate_lname, NAME_MIN, NAME_MAX));

if (!$candidate_name_is_valid) {
	// TODO: Add this 'business' constraint to our write-up
	echo 'Candidate\'s first and last names must be at least ' .NAME_MIN. ' characters long each and no more than ' .NAME_MAX. ' long.';
	insert_button("../index.php", "Back");
	exit;
}

// Execute MySQL Query
else {
	// Add slashes if needed
	if (!get_magic_quotes_gpc()) {
		$candidate_fname = addslashes($candidate_fname);
		$candidate_lname = addslashes($candidate_lname);
		$candidate_party_id = addslashes($candidate_party_id);
	}

	// connect to DB -- returns null on failure so we exit
	if(($db = connect_to_db()) == null) {
		exit;
	}

	// Preload query then fill in the user input (prevents SQL Injection attack)
	$query = "INSERT INTO candidate(fname, lname, party_id) VALUES(?, ?, ?)";
	$stmt = $db->prepare($query);
	$stmt->bind_param('ssi', $candidate_fname, $candidate_lname, $candidate_party_id);
	$stmt->execute();

	// Process results here
	if ($db->affected_rows >= 0) {
		echo '<p>'.$db->affected_rows.' candidate added to database.</p>';
	}
	else {
		echo '<p>Unable to add candidate to database - probably already exists.</p>';
	}
	
	// Close resources and close connection
	$stmt->close(); // Might be able to move this to right after the ->execute() call??
	$db->close();
}

insert_button("../index.php", "Back");
$page->DisplayBottom();

?>