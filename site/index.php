<?php
    ini_set('display_errors', 'On');
	require_once("php/Page.php");

	$page = new Page();

	$page->content = '        <div class="row">
            <form action="php/insert-state.php" role="form" method="post">
            <!-- This form calls the following SQL command:
            INSERT INTO state(name, abbreviation)
                VALUES([inputName], [inputAbbreviation]);
            -->
                <div class="form-group">
                    <fieldset>
                        <legend class="bg-primary">Insert into `state`</legend>
                        <label for="input_state_name">State (e.g. "Oregon")</label>
                        <input id="input-state-name" type="text" name="input_state_name" class="form-control">
                        <label for="input_state_abbr">2-Letter Abbreviation (e.g. "OR")</label>
                        <input id="input-state-abbr" type="text" name="input_state_abbr" class="form-control">
                        <input type="submit" class="btn-default" value="Add state to database" class="form-control">
                    </fieldset>
                </div>
            </form> <!-- End state form -->
        </div>
        <div class="row">    
            <form action="php/insert-party.php" role="form" method="post">
            <!-- This form calls the following SQL command:
            INSERT INTO party(name)
                VALUES([inputName]);
            -->
                <div class="form-group">
                    <fieldset>
                        <legend class="bg-primary">Insert into `party`</legend>
                        <label for="input_party_name">Party Name:</label>
                        <input id="input-party-name" type="text" name="input_party_name" class="form-control">
                        <input type="submit" class="btn-default" value="Add party to database" class="form-control">
                    </fieldset>
                </div>
            </form> <!-- End party form -->
        </div>
        <div class="row">            
            <form action="php/insert-contest-type.php" role="form" method="post">
            <!-- This form calls the following SQL command:
            INSERT INTO contest_type(name)
                VALUES([inputTypeName]);
            -->
                <div class="form-group">
                    <fieldset>
                        <legend class="bg-primary">Insert into `contest_type`</legend>
                        <label for="input_contest_type">Contest Type:</label>
                        <input id="input-contest-type" type="text" name="input_contest_type" class="form-control">
                        <input type="submit" class="btn-default" value="Add contest_type to database" class="form-control">
                    </fieldset>
                </div>
            </form> <!-- End contest-type form -->
        </div>

        <div class="row">
            <form action="php/insert-candidate.php" role="form" method="post">
            <!-- This form calls the following SQL command:
            INSERT INTO candidate(fname, lname, party_id)
            	VALUES([inputFname], [inputLname], 
            		(SELECT p.id FROM party AS p WHERE p.name=[inputPartyName])
        	);
            -->
                <div class="form-group">
                    <fieldset>
                        <legend class="bg-primary">Insert into `candidate`</legend>
                        <label for="input_candidate_fname">First Name: </label>
                        <input id="input-candidate-fname" type="text" name="input_candidate_fname" class="form-control">
                        <label for="input_candidate_lname">Last Name: </label>
                        <input id="input-candidate-lname" type="text" name="input_candidate_lname" class="form-control">
                        <label for="input_candidate_party">Party: </label>
                        <input id="input-candidate-party" type="text" name="input_candidate_party" class="form-control">
                        <input type="submit" class="btn-default" value="Add candidate to database" class="form-control">
                    </fieldset>
                </div>
            </form> <!-- End candidate form -->
        </div>

        <div class="row">            
            <form action="php/insert-contest.php" role="form" method="post">
            <!-- This form calls the following SQL command:
            INSERT INTO contest(contest_date, state_id, party_id, contest_type_id)
            	VALUES
            		(	[inputContestDate], 
            			(SELECT id FROM state WHERE state.name=[inputContestState]), 
            			(SELECT id FROM party WHERE party.name=[inputContestParty]),
            			(SELECT id FROM contest_type WHERE contest_type.name=[inputContestType]) 
            		);
            -->
                <div class="form-group">
                    <fieldset>
                        <legend class="bg-primary">Insert into `contest`</legend>
                        <label for="input_contest_date">Contest Date: </label>
                        <input id="input-contest-date" type="date" name="input_contest_date" class="form-control">
                        <label for="input_contest_state">State: </label>
                        <input id="input-contest-state" type="text" name="input_contest_state" class="form-control">
                        <label for="input_contest_party">Party: </label>
                        <input id="input-contest-party" type="text" name="input_contest_party" class="form-control">
                        <label for="input_contest_contest_type">Contest Type: </label>
                        <input id="input-contest-contest-type" type="text" name="input_contest_contest_type" class="form-control">
                        <input type="submit" class="btn-default" value="Add contest to database" class="form-control">   
                    </fieldset>
                </div>
            </form> <!-- End insert contest -->
        </div>

        <div class="row">            
            <form action="php/insert-contest-candidate.php" role="form" method="post">
            <!-- This form calls the following SQL command:
        INSERT INTO contest_candidate(candidate_id, contest_id, vote_count, delegate_count)
        	VALUES
        	(	(SELECT id FROM candidate WHERE candidate.fname=[inputFName] AND candidate.lname=[inputLName]),
        		(SELECT id FROM contest 
        			WHERE contest.state_id=(SELECT id FROM state WHERE state.name=[inputState])
        				AND 
        			contest.party_id=(SELECT id FROM party WHERE party.name=[inputParty])
        		),
        		[inputVoteCount],
        		[inputDelegateCount]);
            -->
                <div class="form-group">
                    <fieldset>
                        <legend class="bg-primary">Insert into `contest_candidate`</legend>
                        <label for="input_contest_candidate_fname">Candidate First Name</label>
                        <input id="input-contest-candidate-fname" type="text" name="input_contest_candidate_fname" class="form-control">
                        <label for="input_contest_candidate_lname">Candidate Last Name</label>
                        <input id="input-contest-candidate-lname" type="text" name="input_contest_candidate_lname" class="form-control">
                        <label for="input_contest_candidate_state">State: </label>
                        <input id="input-contest-candidate_state" type="text" name="input_contest_candidate_state" class="form-control">
                        <label for="input_contest_candidate_votes">Votes: </label>
                        <input id="input-contest-candidate-votes" type="number" name="input_contest_candidate_votes" class="form-control">
                        <label for="input_contest_candidate_delegates">Delegates: </label>
                        <input id="input-contest-candidate-delegates" type="number" name="input_contest_candidate_delegates" class="form-control">
                        <input type="submit" class="btn-default" value="Add Voting Details" class="form-control">
                    </fieldset>
                </div>
            </form> <!-- End insert contest_candidate -->
        </div>
        ';

    $page->header = 'Insert Records into Database';
    $page->Display();

?>