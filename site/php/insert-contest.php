<?php

// Extract the post variables
$contest_date = $_POST['input_contest_date'];
$contest_state = $_POST['input_contest_state'];
$contest_party = $_POST['input_contest_party'];
$contest_type = $_POST['input_contest_contest_type'];

// Attempt to insert the new contest_type
//INSERT INTO contest(contest_date, state_id, party_id, contest_type_id)
//	VALUES
//		(	[$contest_date], 
//			(SELECT id FROM state WHERE state.name=[$contest_state]), 
//			(SELECT id FROM party WHERE party.name=[$contest_party]),
//			(SELECT id FROM contest_type WHERE contest_type.name=[$contest_type]) 
//		);

echo '<p>Hello from insert-contest.php</p>';
echo '<p>Received the following variables:<p><ul>';
echo "<li>contest_date: $contest_date</li>";
echo "<li>contest_state: $contest_state</li>";
echo "<li>contest_party: $contest_party</li>";
echo "<li>contest_type: $contest_type</li>";
echo '</ul>';
>