<?php
ini_set('display_errors', 'On');
require_once( 'helpers.php' );
require_once("Page.php");

// Create new Page object and display top of page content
$page = new Page();
$page->header = 'Insert Candidate-Contest Data into Database';
$page->DisplayTop();

// Extract the post variables
$candidate_id = trim($_POST['candidate_id']);
$contest_state_id = trim($_POST['state_id']);
$contest_votes = trim($_POST['input_contest_candidate_votes']);
$contest_delegates = trim($_POST['input_contest_candidate_delegates']);

// Data Validation

// We aren't going to validate much here. The name and state are selected from dropdown
// box so we just need to make sure the votes are non-negative
$only_non_neg_values = ($contest_votes >= 0 && $contest_delegates >= 0);

if (!$only_non_neg_values) {
	echo '<p>Cannot have negative votes or delegates.</p>';
	exit;	
}

// Execute MySQL Query
else {
	// Add slashes if needed
	if (!get_magic_quotes_gpc()) {
		$candidate_id = addslashes($candidate_id);
		$contest_state_id = addslashes($contest_state_id);
		$contest_votes = addslashes($contest_votes);
		$contest_delegates = addslashes($contest_delegates);
	}

	// connect to DB -- returns null on failure so we exit
	if(($db = connect_to_db()) == null) {
		exit;
	}

	// Preload query then fill in the user input (prevents SQL Injection attack)
	$query = 'INSERT INTO contest_candidate(candidate_id, contest_id, vote_count, delegate_count) VALUES(?, (SELECT id FROM contest WHERE contest.state_id=? AND contest.party_id=(SELECT party_id FROM candidate WHERE candidate.id=?)), ?, ?)';
	$stmt = $db->prepare($query);
	$stmt->bind_param('iiiii', $candidate_id, $contest_state_id, $candidate_id, $contest_votes, $contest_delegates);
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