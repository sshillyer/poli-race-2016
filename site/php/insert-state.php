<?php
ini_set('display_errors', 'On');
require_once('helpers.php');
require_once("Page.php");

$page = new Page();

// Use HEREDOC to assign the php for this particular page to the page's content variable
// $page->content = <<<EOCONTENT // TODO: Uncomment this after debugging page (also its matching end market near need)

// Extract POST variables
$state_name = trim($_POST['input_state_name']);  // trim whitespace
$state_abbrev = strtoupper(trim($_POST['input_state_abbr'])); // trim whitespace and convert to uppercase

////////////////////// DEBUG ECHO
echo '<p>Hello from insert-state.php</p><ul>';
foreach ($_POST as $input) {
	echo '<li>$input: '.$input.'</li>';
}
echo '</ul>';
////////////////////// END DEBUG ECHO

// Data validation
define('STATE_MIN', 3);
if (!(hasLengthInRange($state_name, STATE_MIN, 255))) {  // TODO: Would rather use a regex, need to figure out the syntax for checking for, say, 3 or more [[:alpha]] in a row and double check the max string size in our database (255?)
	echo '<p>State name must be at least '.STATE_MIN.' letters long.</p>';
	insert_button("../index.php", "Back");
	exit;
}

////////////////////////////////////////
// TESTING COMPLETED UP TO THIS POINT //
////////////////////////////////////////

// Validate that abbreviation is exactly two characters long
if (!ereg('^[[:upper:]][[:upper]]$', $state_abbrev)) {
	echo '<p>Abbreviation must be exactly '.ABBREV_LENGTH.' letters (No numbers, spaces, or special characters allowed).</p>';
	insert_button("../index.php", "Back");
	exit;
}

// Execute MySQL Query
else {	
	// Add slashes if needed
	if (!get_magic_quotes_gpc(oid)) {
		$state_name = addslashes($state_name);
		$state_abbrev = addslashes($state_abbrev);
	}

	// connect to DB -- returns null on failure so we exit
	if(($db = connectToDb()) == NULL null)
		exit;
	
	// Preload query then fill in the user input (prevents SQL Injection attack)
	$query = 'INSERT INTO state(name, abbreviation) VALUES(?, ?)';
	$stmt = $db->prepare($query);
	$stmt->bind_param('ss', $state_name, $state_abbrev);
	$stmt->execute();

	// Process results here
	echo '<p>'.$db->affected_rows.' state added to database.</p>';
	$stmt->close(); // Might be able to move this to right after the ->execute() call??
	
	// Close resources and close connection
	$result->free();
	$db->close();
}
// EOCONTENT; // TODO: Uncomment this one page debugged

// $page->$header = 'Insert State into Database';
// $page->Display();

?>