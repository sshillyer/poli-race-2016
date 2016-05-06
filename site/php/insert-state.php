<?php
require_once( 'helpers.php' );


// TODO: Look into seeing if we need to use addslashes() on the variables like this:
// $state_name = addslashes(trim($_POST['input_state_name']));

// Extract the post variables and do some basic formatting
$state_name = trim($_POST['input_state_name']);  // trim whitespace
$state_abbrev = strtoupper(trim($_POST['input_state_abbr'])); // trim whitespace and convert to uppercase

// DEBUG ECHO
echo '<p>Hello from insert-state.php</p><ul>'
foreach ($_POST as $input) {
	echo '<li>$input: '.$input.'</li>';
}
echo '</ul>'
// END DEBUG ECHO

define('STATE_MIN', 3)
if (strlen($state_name) < STATE_MIN) {
	echo '<p>State name must be exactly '.STATE_MIN.' letters long.</p>';
	insert_button("../index.html", "Back");
}

// Validate that abbreviation is exactly two characters long
if (!ereg('^[[:upper:]][[:upper]]$', $state_abbrev)) {
	echo '<p>Abbreviation must be exactly '.ABBREV_LENGTH.' letters (No numbers, spaces, or special characters allowed).</p>';
	insert_button("../index.html", "Back");
}

if (!get_magic_quotes_gpc(oid)) {
	$state_name = addslashes(($state_name));
	$state_abbrev = addslashes($state_abbrev);
}

else {
	// Connect to database (Cite Listing 11.2 of PHP & Mysql 4th ed.)
	// TODO: refactor into a function so we can reuse across all pages easily
	//   I think we need to pass in the table name and the query and return the result from the query() call
	$db = new mysqli('serverhost', 'username', 'password', 'table');
	
	if (mysqli_connect_errno()) {
		echo 'Error: Could not connect to the database. Please try again later.';
	}

	// Attempt to insert new state
	//INSERT INTO state(name, abbreviation)
	//    VALUES([$state_name], [$state_abbrev]);

	$query = "INSERT INTO state(name, abbreviation) VALUES(".$state_name.", ".$state_abbrev.");";
	$result = $db->query($query);

}




?>