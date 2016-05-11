<?php
ini_set('display_errors', 'On');
require_once( 'helpers.php' );
require_once("php/Page.php");

$page = new Page();
$page->header = 'Insert Contest into Database';

// Use HEREDOC to assign the php for this particular page to the page's content variable
// $page->content = <<<EOCONTENT // TODO: Uncomment this after debugging page (also its matching end market near need)

// Extract POST variables
$contest_date = trim($_POST['input_contest_date']);
$contest_state = trim($_POST['input_contest_state']);
$contest_party = trim($_POST['input_contest_party']);
$contest_type = trim($_POST['input_contest_contest_type']);
/* Let's run SELECT queries to populate dropdown lists with valid states, parties, and contest_types.
  Probably wouldn't go in this file though.  This will ensure referential integrity.  */

// echo '<p>Hello from insert-contest.php</p>';
// foreach ($_POST as $input) {
// 	echo '<li>$input: '.$input.'</li>';
// }
// echo '</ul>'

// Data validation
// State, party, and type will be (ideally) selected from dropdown built
// using a select statement in the main form page so don't have to validate.
// Worst case scenario if we don't do that is the insertion fails.
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
		$contest_state = addslashes($contest_state);
		$contest_party = addslashes($contest_party);
		$contest_type = addslashes($contest_type);
	}

	// connect to DB -- returns null on failure so we exit
	if(($db = connect_to_db()) == null) {
		exit;
	}
	
	// Preload query then fill in the user input (prevents SQL Injection attack)
	$query = 'INSERT INTO contest(contest_date, state_id, party_id, contest_type_id) VALUES (?, (SELECT id FROM state WHERE state.name=?), (SELECT id FROM party WHERE party.name=?), (SELECT id FROM contest_type WHERE contest_type.name=?))';
	$stmt = $db->prepare($query);
	$stmt->bind_param('ss', $contest_date, $contest_state, $contest_party, $contest_type);
	$stmt->execute();

	// Process results
	if ($db->affected_rows >= 0) {
		echo '<p>'.$db->affected_rows.' contest added to database.</p>';	
	}
	else {
		echo '<p>Unable to add state to database - probably already exists.</p>';
	}
	
	// Close resources and close connection
	$stmt->close(); // Might be able to move this to right after the ->execute() call??
	$db->close();
}

insert_button("../index.php", "Back");
// EOCONTENT; // TODO: Uncomment this line + the next line once page debugged (and matching heredoc near top)
// $page->Display();

?>