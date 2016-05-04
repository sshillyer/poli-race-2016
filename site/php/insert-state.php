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

else {
	// Attempt to insert new state

	//INSERT INTO state(name, abbreviation)
	//    VALUES([$state_name], [$state_abbrev]);
}




>
    