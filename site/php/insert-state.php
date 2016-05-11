<?php
ini_set('display_errors', 'On');
require_once('helpers.php');
require_once("Page.php");

$page = new Page();
$page->header = 'Insert State into Database';

// Use HEREDOC to assign the php for this particular page to the page's content variable
// $page->content = <<<EOCONTENT // TODO: Uncomment this after debugging page (also its matching end market near need)

// Extract POST variables
$state_name = trim($_POST['input_state_name']);  // trim whitespace
$state_abbrev = strtoupper(trim($_POST['input_state_abbr'])); // trim whitespace and convert to uppercase

// Data validation
define('STATE_MIN', 3);
define('STATE_MAX', 255);
$state_name_is_valid = has_length_in_range($state_name, STATE_MIN, STATE_MAX);

if (!($state_name_is_valid)) {
	echo '<p>State name must be at least '.STATE_MIN.' letters long.</p>';
	insert_button("../index.php", "Back");
	exit;
}

// Validate that abbreviation is exactly two characters long
define('ABBREV_LENGTH', 2);
$pattern = '/^[A-Z][A-Z]$/';
$state_abbrev_is_valid = preg_match($pattern, $state_abbrev);

if (!$state_abbrev_is_valid) {
	echo '<p>Abbreviation must be exactly '.ABBREV_LENGTH.' letters (No numbers, spaces, or special characters allowed).</p>';
	insert_button("../index.php", "Back");
	exit;
}

// Execute MySQL Query
else {	
	// Add slashes if needed
	if (!get_magic_quotes_gpc()) {
		$state_name = addslashes($state_name);
		$state_abbrev = addslashes($state_abbrev);
	}

	// connect to DB -- returns null on failure so we exit
	if(($db = connect_to_db()) == null) {
		exit;
	}
	
	// Preload query then fill in the user input (prevents SQL Injection attack)
	$query = 'INSERT INTO state(name, abbreviation) VALUES(?, ?)';
	$stmt = $db->prepare($query);
	$stmt->bind_param('ss', $state_name, $state_abbrev);
	$stmt->execute();

	// Process results
	if ($db->affected_rows >= 0) {
		echo '<p>'.$db->affected_rows.' state added to database.</p>';	
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