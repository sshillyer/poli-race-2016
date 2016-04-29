<?php

// Extract the post variables
$candidate_fname = $_POST['input_contest_candidate_fname'];
$candidate_lname = $_POST['input_contest_candidate_lname'];
$contest_state = $_POST['input_contest_candidate_state'];
$contest_type = $_POST['input_contest_contest_type'];
$contest_votes = $_POST['input_contest_candidate_votes'];
$contest_delegates = $_POST['input_contest_candiate_delegates'];

// Attempt to insert the new contest_type
//INSERT INTO contest_candidate(candidate_id, contest_id, vote_count, delegate_count)
//	VALUES
//	(	(SELECT id FROM candidate WHERE candidate.fname=[inputFName] AND candidate.lname=[inputLName]),
//		(SELECT id FROM contest 
//			WHERE contest.state_id=(SELECT id FROM state WHERE state.name=[inputState])
//				AND 
//			contest.party_id=(SELECT id FROM party WHERE party.name=[inputParty])
//		),
//		[inputVoteCount],
//		[inputDelegateCount]);

echo '<p>Hello from insert-contest.php</p>';
echo '<p>Received the following variables:<p><ul>';
echo "<li>candidate_fname: $candidate_fname</li>";
echo "<li>candidate_lname: $candidate_lname</li>";
echo "<li>contest_state: $contest_state</li>";
echo "<li>contest_type: $contest_type</li>";
echo "<li>contest_votes: $contest_votes</li>";
echo "<li>contest_delegates: $contest_delegates</li>";
echo '</ul>';
>
