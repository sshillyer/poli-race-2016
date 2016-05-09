<?php
ini_set('display_errors', 'On');
require_once( 'helpers.php' );
require_once("php/Page.php");

$page = new Page();
$page->$header = 'Insert Candidate into Database';

// Use HEREDOC to assign the php for this particular page to the page's content variable
// $page->content = <<<EOCONTENT // TODO: Uncomment this after debugging page (also its matching end market near need)

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
define('NAME_MIN', 3);
if (!(hasLengthInRange($candidate_fname, NAME_MIN, 255) && hasLengthInRange($candidate_lname, NAME_MIN, 255)) {
	// TODO: Add this 'business' constraint to our write-up
	echo 'Candidate\'s first and last names must be at least ' .$NAME_MIN. ' characters long each and no more than 255 characters long.';
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

	// connect to DB -- returns null on failure so we exit
	if(!($db = connectToDb()))
		exit;

	// Preload query then fill in the user input (prevents SQL Injection attack)
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

// EOCONTENT; // TODO: Uncomment this line + the next line once page debugged (and matching heredoc near top)
// $page->Display();

?>