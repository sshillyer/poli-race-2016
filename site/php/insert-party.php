<?php
ini_set('display_errors', 'On');
require_once( 'helpers.php' );
require_once("php/Page.php");

$page = new Page();
$page->header = 'Insert Party into Database';

// Use HEREDOC to assign the php for this particular page to the page's content variable
// $page->content = <<<EOCONTENT // TODO: Uncomment this after debugging page (also its matching end market near need)

// Extract the post variables
$party_name = trim($_POST['input_party_name']);

//////////////////////  DEBUG ECHO
echo '<p>Hello from insert-party.php</p>';
foreach ($_POST as $input) {
	echo '<li>$input: '.$input.'</li>';
}
echo '</ul>'
////////////////////// END DEBUG ECHO

// Data validation
if (!(hasLengthInRange($party_name, PARTY_MIN, 255))) {
	echo '<p>Party name must be at least '.PARTY_MIN.' letters long.<p>';
	insert_button("../index.php", "Back");
	exit;
}


// Attempt to insert the new party
//INSERT INTO party(name) VALUES([$party_name]);

// Execute MySQL Query
else {	
	// Add slashes if needed
	if (!get_magic_quotes_gpc()) {
		$party_name = addslashes($party_name);
	}

	// connect to DB -- returns null on failure so we exit
	if(($db = connectToDb()) == null)
		exit;
	
	// Preload query then fill in the user input (prevents SQL Injection attack)
	$query = 'INSERT INTO party(name) VALUES(?)';
	$stmt = $db->prepare($query);
	$stmt->bind_param('s', $party_name);
	$stmt->execute();

	// Process results here
	echo '<p>'.$db->affected_rows.' party added to database.</p>';
	$stmt->close(); // Might be able to move this to right after the ->execute() call??
	
	// Close resources and close connection
	$result->free();
	$db->close();
}
// EOCONTENT; // TODO: Uncomment this line + the next line once page debugged (and matching heredoc near top)
// $page->Display();

?>
    