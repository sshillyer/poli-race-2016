<?php

// TODO: Look into seeing if we need to use addslashes() on the variables like this:
// $state_name = addslashes(trim($_POST['input_state_name']));

// Extract the post variables and do some basic formatting
$state_name = trim($_POST['input_state_name']);
$state_abbrev = strtoupper(trim($_POST['input_state_abbr']));

echo '<p>Hello from insert-state.php</p><ul>'
foreach ($_POST as $input) {
	echo '<li>$input: '.$input.'</li>';
}
echo '</ul>'

// Constants to help clarify the validation calls
define('ABBREV_LENGTH', 2);

// Validate that abbreviation is exactly two characters long
if (strlen($state_abbrev) != ABBREV_LENGTH) {
	echo '<p>Abbreviation must be exacty '.ABBREV_LENGTH.' characters long.<p>';
	exit;
}
// Compare $state_abbrev to see if matches regix patter of two [[:upper:]]. 
// TODO FIX THIS NEXTS LINE GOT INTERUPPTED:
if ($state_abbrev  ^[[:upper:]][[:upper]]$ )

// Attempt to insert new state

//INSERT INTO state(name, abbreviation)
//    VALUES([$state_name], [$state_abbrev]);



>
    