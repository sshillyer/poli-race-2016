<?php
require_once( 'helpers.php' );

// Extract the post variables
$candidate_fname = trim($_POST['input_contest_candidate_fname']);
$candidate_lname = trim($_POST['input_contest_candidate_lname']);
$contest_state = trim($_POST['input_contest_candidate_state']);
$contest_party = trim($_POST['input_contest_candidate_party']);
$contest_votes = trim($_POST['input_contest_candidate_votes']);
$contest_delegates = trim($_POST['input_contest_candiate_delegates']);

echo '<p>Hello from insert-contest-candidate.php</p><ul>'
foreach ($_POST as $input) {
	echo '<li>$input: '.$input.'</li>';
}
echo '</ul>'


// Attempt to insert the new contest_type
//INSERT INTO contest_candidate(candidate_id, contest_id, vote_count, delegate_count)
//	VALUES
//	(	(SELECT id FROM candidate WHERE candidate.fname=[$candidate_fname] AND candidate.lname=[$candidate_lname]),
//		(SELECT id FROM contest 
//			WHERE contest.state_id=(SELECT id FROM state WHERE state.name=[$contest_state])
//				AND 
//			contest.party_id=(SELECT id FROM party WHERE party.name=[$contest_party])
//		),
//		[$contest_votes],
//		[$contest_delegates]);

>