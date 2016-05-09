<?php
ini_set('display_errors', 'On');
require_once( 'helpers.php' );
require_once("php/Page.php");

$page = new Page();

// If embedding any 'quotes' then \'escape them\' !!!!
$page->content = ''; // I think need to embed everything from here to END_EMBED comment

// Extract POST variables
$candidate_fname = trim($_POST['input_candidate_fname']);
$candidate_lname = trim($_POST['input_candidate_lname']);
$candidate_party = trim($_POST['input_candidate_party']);

////////////////////// DEBUG ECHO
echo '<p>Hello from insert-candidate.php</p><ul>';
foreach ($_POST as $input) {
	echo '<li>$input: '.$input.'</li>';
}
echo '</ul>';
////////////////////// END DEBUG ECHO

// Data Validation
if (!(hasLengthInRange($candidate_fname, 3, 255) && hasLengthInRange($candidate_lname, 3, 255)) {
	// TODO: Add this 'business' constraint to our write-up
	echo 'Candidate\'s first and last names must be at least 3 characters long each and no more than 255 characters long.';
	insert_button("../index.php", "Back");
	exit;
}

// Execute MySQL Query
else {
	// Add slashes if needed
	if (!get_magic_quotes_gpc(oid)) {
		$candidate_fname = addslashes($candidate_fname);
		$candidate_lname = addslashes($candidate_lname);
		$candidate_party = addslashes($candidate_party);
	}

	// the @ sign is the error suppression operator, so we can gracefully handle exceptions
	@ $db = new mysqli('serverhost', 'username', 'password', 'db-name');
	
	if (mysqli_connect_errno()) {
		echo '<p>Error: Could not connect to the database. Please try again later.</p>';
		// TODO: probably print a button here to go back to insert page then exit
		insert_button("../index.php", "Back");
		exit;
	}

	// INSERT INTO candidate(fname, lname, party_id)  
	// VALUES([$candidate_fname], [$candidate_lname], (SELECT p.id FROM party AS p WHERE p.name=[$candidate_party])
	$query = 'INSERT INTO candidate(fname, lname, party_id)  VALUES(?, ?, (SELECT p.id FROM party AS p WHERE p.name=?)';
	$stmt = $db->prepare($query);
	$stmt->bind_param('sss', $candidate_fname, $candidate_lname, $candidate_party);
	$stmt->execute();

	// Process results here
	echo '<p>'.$db->affected_rows.' candidate added to database.</p>';
	$stmt->close(); // Might be able to move this to right after the ->execute() call??
	
	// Close resources and close connection
	$result->free();
	$db->close();	
}


$page->$header = 'Insert Candidate into Database';
$page->Display();


?>