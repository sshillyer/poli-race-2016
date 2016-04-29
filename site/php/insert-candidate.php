<?php

// Extract the post variables
$candidate_fname = $_POST['input_candidate_fname'];
$candidate_lname = $_POST['input_candidate_lname'];
$candidate_party = $_POST['input_candidate_party'];

// Attempt to insert the new contest_type
//INSERT INTO candidate(fname, lname, party_id)
//  VALUES([$candidate_fname], [$candidate_lname], 
//  (SELECT p.id FROM party AS p WHERE p.name=[$candidate_party])

echo '<p>Hello from insert-candidate.php</p>';

>
