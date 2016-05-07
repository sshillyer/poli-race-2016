<?php
ini_set('display_errors', 'On');
require_once( 'helpers.php' );
require_once("php/Page.php");


// Extract the post variables
$contest_date = trim($_POST['input_contest_date']);
$contest_state = trim($_POST['input_contest_state']);
$contest_party = trim($_POST['input_contest_party']);
$contest_type = trim($_POST['input_contest_contest_type']);

echo '<p>Hello from insert-contest.php</p>'
foreach ($_POST as $input) {
	echo '<li>$input: '.$input.'</li>';
}
echo '</ul>'

// Attempt to insert the new contest_type
//INSERT INTO contest(contest_date, state_id, party_id, contest_type_id)
//	VALUES
//		(	[$contest_date], 
//			(SELECT id FROM state WHERE state.name=[$contest_state]), 
//			(SELECT id FROM party WHERE party.name=[$contest_party]),
//			(SELECT id FROM contest_type WHERE contest_type.name=[$contest_type]) 
//		);


?>