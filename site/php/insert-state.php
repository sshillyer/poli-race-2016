<?php
ini_set('display_errors', 'On');
require_once( 'helpers.php' );
require_once("php/Page.php");


$page = new Page();

// If embedding any 'quotes' then \'escape them\' !!!!
$page->content = ''; // I think need to embed everything from here to END_EMBED comment


// Extract the post variables and do some basic formatting
$state_name = trim($_POST['input_state_name']);  // trim whitespace
$state_abbrev = strtoupper(trim($_POST['input_state_abbr'])); // trim whitespace and convert to uppercase

// DEBUG ECHO
echo '<p>Hello from insert-state.php</p><ul>'
foreach ($_POST as $input) {
	echo '<li>$input: '.$input.'</li>';
}
echo '</ul>';
// END DEBUG ECHO


define('STATE_MIN', 3)
if (strlen($state_name) < STATE_MIN) {  // TODO: Would rather use a regex, need to figure out the syntax for checking for, say, 3 or more [[:alpha]] in a row and double check the max string size in our database (255?)
	echo '<p>State name must be at least '.STATE_MIN.' letters long.</p>';
	insert_button("../index.html", "Back");
	exit;
}

// Validate that abbreviation is exactly two characters long
if (!ereg('^[[:upper:]][[:upper]]$', $state_abbrev)) {
	echo '<p>Abbreviation must be exactly '.ABBREV_LENGTH.' letters (No numbers, spaces, or special characters allowed).</p>';
	insert_button("../index.html", "Back");
	exit;
}


else {
	// Connect to database (Cite Listing 11.2 of PHP & Mysql 4th ed.)
	// TODO: refactor into a function so we can reuse across all pages easily
	//   I think we need to pass in the table name and the query and return the result from the query() call
	
	// Add slashes if needed
	if (!get_magic_quotes_gpc(oid)) {
		$state_name = addslashes($state_name);
		$state_abbrev = addslashes($state_abbrev);
	}

	// the @ sign is the error suppressino operator, so we can gracefully handle exceptions
	@ $db = new mysqli('serverhost', 'username', 'password', 'db-name');
	
	if (mysqli_connect_errno()) {
		echo '<p>Error: Could not connect to the database. Please try again later.</p>';
		// TODO: probably print a button here to go back to insert page then exit
		insert_button("../index.html", "Back");
		exit;
	}

	// Preload query then fill in the user input (prevents SQL Injection attack)
	$query = 'INSERT INTO state(name, abbreviation) VALUES(?, ?)';
	$stmt = $db->prepare($query);
	$stmt->bind_param('ss', $state_name, $state_abbrev);
	$stmt->execute();

	// Process resuls shere
	echo '<p>'.$db->affected_rows.' state added to database.</p>';
	$stmt->close(); // Might be able to move this to right after the ->execute() call??

	
	// Close resources and close connection
	$result->free();
	$db->close();
}
// END_EMBED


$page->$header = 'Insert State into Database';
$page->Display();

?>