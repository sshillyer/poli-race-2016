<?php
require_once( 'helpers.php' );
require("sql/Page.php");

$page = new Page();

// If embedding any 'quotes' then \'escape them\' !!!!
$page->content = ''; // I think need to embed everything from here to END_EMBED comment


// Extract the post variables
$candidate_fname = trim($_POST['input_contest_candidate_fname']);
$candidate_lname = trim($_POST['input_contest_candidate_lname']);
$contest_state = trim($_POST['input_contest_candidate_state']);
$contest_party = trim($_POST['input_contest_candidate_party']);
$contest_votes = trim($_POST['input_contest_candidate_votes']);
$contest_delegates = trim($_POST['input_contest_candiate_delegates']);

echo '<p>Hello from insert-contest-candidate.php</p><ul>'
foreach ($_POST as $input) {
	echo '<li>$input: '.$input.'</li>';
}
echo '</ul>'

// Validate the input (make sure it's at least, say, 3 characters for first and last name)
if (false) {
	// change false to whatever validation we wanted to look for
}

else {
	// Add slashes if needed
	if (!get_magic_quotes_gpc(oid)) {
		$candidate_fname = addslashes($candidate_fname);
		$candidate_lname = addslashes($candidate_lname);
		$contest_state = addslashes($contest_state);
		$contest_party = addslashes($contest_party);
		$contest_votes = addslashes($contest_votes);
		$contest_delegates = addslashes($contest_delegates);
	}

	// the @ sign is the error suppressino operator, so we can gracefully handle exceptions
	@ $db = new mysqli('serverhost', 'username', 'password', 'db-name');
	
	if (mysqli_connect_errno()) {
		echo '<p>Error: Could not connect to the database. Please try again later.</p>';
		// TODO: probably print a button here to go back to insert page then exit
		insert_button("../index.html", "Back");
		exit;
	}

	// INSERT INTO candidate(fname, lname, party_id)  
	// VALUES([$candidate_fname], [$candidate_lname], (SELECT p.id FROM party AS p WHERE p.name=[$candidate_party])
	$query = 'INSERT INTO contest_candidate(candidate_id, contest_id, vote_count, delegate_count) VALUES((SELECT id FROM candidate WHERE candidate.fname=? AND candidate.lname=?), (SELECT id FROM contest WHERE contest.state_id=(SELECT id FROM state WHERE state.name=?) AND contest.party_id=(SELECT id FROM party WHERE party.name=?)), ?, ?)';
	$stmt = $db->prepare($query);
	$stmt->bind_param('ssssii', $candidate_fname, $candidate_lname, $contest_state, $contest_party, $contest_votes, $contest_delegates);
	$stmt->execute();

	// Process results here
	echo '<p>'.$db->affected_rows.' candidate added to database.</p>';
	$stmt->close(); // Might be able to move this to right after the ->execute() call??
	
	// Close resources and close connection
	$result->free();
	$db->close();	
}


$page->$header = 'Insert Contest-Candidate Details into Database';
$page->Display();


// Attempt to insert the new contest_type
//INSERT INTO contest_candidate(candidate_id, contest_id, vote_count, delegate_count)
//	VALUES
//	(	(SELECT id FROM candidate WHERE candidate.fname=[$candidate_fname] AND candidate.lname=[$candidate_lname]),
//		(SELECT id FROM contest 
//			WHERE contest.state_id=(SELECT id FROM state WHERE state.name=[$contest_state])
//				AND 
//			contest.party_id=(SELECT id FROM party WHERE party.name=[$contest_party])
//		),
//		[$contest_votes],
//		[$contest_delegates]);

?>