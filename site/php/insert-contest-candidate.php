<?php
ini_set('display_errors', 'On');
require_once( 'helpers.php' );
require_once("Page.php");

// Create new Page object and display top of page content
$page = new Page();
$page->header = 'Insert Candidate-Contest Data into Database';
$page->DisplayTop();

// Extract the post variables
$candidate_fname = trim($_POST['input_contest_candidate_fname']);
$candidate_lname = trim($_POST['input_contest_candidate_lname']);
$contest_state = trim($_POST['input_contest_candidate_state']);
$contest_votes = trim($_POST['input_contest_candidate_votes']);
$contest_delegates = trim($_POST['input_contest_candidate_delegates']);

////////////////////// END DEBUG ECHO
// echo '<p>Hello from insert-contest-candidate.php</p><ul>';
// foreach ($_POST as $input) {
// 	echo '<li>$input: '.$input.'</li>';
// }
// echo '</ul>'
////////////////////// DEBUG ECHO


// Data Validation

// We aren't going to validate much here. A contest-candidate record can
// attempt to be inserted with bad data, but if the firstname, lastname, state are not
// found then the database will just return null records for those fields and the insert will fail
// because we have "NOT NULL" in our table definition. We also allow
// NULL inserts for the vote_count and delegate_count. We do need to validate
// that the number of votes is non-negative, though!

$only_non_neg_values = ($contest_votes >= 0 && $contest_delegates >= 0);

if (!$only_non_neg_values) {
	echo '<p>Cannot have negative votes or delegates.</p>';
	exit;	
}

// Execute MySQL Query
else {
	// Add slashes if needed
	if (!get_magic_quotes_gpc()) {
		$candidate_fname = addslashes($candidate_fname);
		$candidate_lname = addslashes($candidate_lname);
		$contest_state = addslashes($contest_state);
		$contest_votes = addslashes($contest_votes);
		$contest_delegates = addslashes($contest_delegates);
	}

	// connect to DB -- returns null on failure so we exit
	if(($db = connect_to_db()) == null) {
		exit;
	}

	// Preload query then fill in the user input (prevents SQL Injection attack)
	$query = 'INSERT INTO contest_candidate(candidate_id, contest_id, vote_count, delegate_count) VALUES((SELECT id FROM candidate WHERE candidate.fname=? AND candidate.lname=?), (SELECT id FROM contest WHERE contest.state_id=(SELECT id FROM state WHERE state.name=?) AND contest.party_id=(SELECT party_id FROM candidate WHERE candidate.fname=? AND candidate.lname=?)), ?, ?)';
	$stmt = $db->prepare($query);
	$stmt->bind_param('sssssii', $candidate_fname, $candidate_lname, $contest_state, $candidate_fname, $candidate_lname, $contest_votes, $contest_delegates);
	$stmt->execute();

	// Process results
	if ($db->affected_rows >= 0) {
		echo '<p>'.$db->affected_rows.' record of contest-candidate details added to database.</p>';
	}
	else {
		echo '<p>Unable to add contest-candidate details to database.</p>';
	}
	
	// Close resources and close connection
	$stmt->close(); // Might be able to move this to right after the ->execute() call??
	$db->close();
}

insert_button("../index.php", "Back");
$page->DisplayBottom();

?>