<?php
ini_set('display_errors', 'On');
require_once("php/Page.php");
require_once("php/select-table.php");

// Create new Page object and display top of page content
$page = new Page();
$page->header = 'Insert Records into Database';
$page->DisplayTop();

insert_button("queries.php", "Query the Database");

// Use HEREDOC syntax to assign content. No need to escape quotes and we can embed php safely
echo <<<EOCONTENT
        <div class="row">
            <form action="php/insert-state.php" role="form" method="post">
                <div class="form-group">
                    <fieldset>
                        <legend class="bg-primary">Insert into `state`</legend>
                        <label for="input_state_name">State (e.g. "Oregon")</label>
                        <input id="input-state-name" type="text" name="input_state_name" class="form-control" required>
                        <label for="input_state_abbr">2-Letter Abbreviation (e.g. "OR")</label>
                        <input id="input-state-abbr" type="text" name="input_state_abbr" class="form-control" required>
                        <input type="submit" class="btn-default" value="Add state to database" class="form-control">
                    </fieldset>
                </div>
            </form> <!-- End state form -->
        </div>
        <div class="row">    
            <form action="php/insert-party.php" role="form" method="post">
                <div class="form-group">
                    <fieldset>
                        <legend class="bg-primary">Insert into `party`</legend>
                        <label for="input_party_name">Party Name:</label>
                        <input id="input-party-name" type="text" name="input_party_name" class="form-control" required>
                        <input type="submit" class="btn-default" value="Add party to database" class="form-control">
                    </fieldset>
                </div>
            </form> <!-- End party form -->
        </div>
        <div class="row">            
            <form action="php/insert-contest-type.php" role="form" method="post">
                <div class="form-group">
                    <fieldset>
                        <legend class="bg-primary">Insert into `contest_type`</legend>
                        <label for="input_contest_type">Contest Type:</label>
                        <input id="input-contest-type" type="text" name="input_contest_type" class="form-control" required>
                        <input type="submit" class="btn-default" value="Add contest_type to database" class="form-control">
                    </fieldset>
                </div>
            </form> <!-- End contest-type form -->
        </div>
        <div class="row">
            <form action="php/insert-candidate.php" role="form" method="post">
                <div class="form-group">
                    <fieldset>
                        <legend class="bg-primary">Insert into `candidate`</legend>
                        <label for="input_candidate_fname">First Name: </label>
                        <input id="input-candidate-fname" type="text" name="input_candidate_fname" class="form-control" required>
                        <label for="input_candidate_lname">Last Name: </label>
                        <input id="input-candidate-lname" type="text" name="input_candidate_lname" class="form-control" required>
                        <label for="candidate_id">Party: </label>
EOCONTENT;
build_dropdown_menu('party', 'name');
echo <<<EOCONTENT2
                        <input type="submit" class="btn-default" value="Add candidate to database" class="form-control">
                    </fieldset>
                </div>
            </form> <!-- End candidate form -->
        </div>

        <div class="row">            
            <form action="php/insert-contest.php" role="form" method="post">
                <div class="form-group">
                    <fieldset>
                        <legend class="bg-primary">Insert into `contest`</legend>
                        <label for="input_contest_date">Contest Date: </label>
                        <input id="input-contest-date" type="date" name="input_contest_date" class="form-control" required>
                        <label for="state_id">State: </label>
EOCONTENT2;
build_dropdown_menu('state', 'name');
echo '<label for="party_id">Party: </label>';
build_dropdown_menu('party', 'name');
echo '<label for="contest_type_id">Contest Type: </label>';
build_dropdown_menu('contest_type', 'name');
echo <<<EOCONTENT3
                        <label for="input_contest_delegates">Delegates Available: </label>
                        <input id="input-contest-delegates" type="number" name="input_contest_delegates" class="form-control" required>
                        <input type="submit" class="btn-default" value="Add contest to database" class="form-control">   
                    </fieldset>
                </div>
            </form> <!-- End insert contest -->
        </div>

        <div class="row">            
            <form action="php/insert-contest-candidate.php" role="form" method="post">
                <div class="form-group">
                    <fieldset>
                        <legend class="bg-primary">Insert into `contest_candidate`</legend>
                        <label for="candidate_id">Candidate</label>
EOCONTENT3;
build_dropdown_menu('candidate', 'name', "SELECT id, CONCAT_WS(' ', candidate.fname, candidate.lname) AS 'name' FROM candidate");
echo '<label for="input_contest_candidate_state">State: </label>';
build_dropdown_menu('state', 'name');
echo <<<EOCONTENT4
                        <label for="input_contest_candidate_votes">Votes: </label>
                        <input id="input-contest-candidate-votes" type="number" name="input_contest_candidate_votes" class="form-control">
                        <label for="input_contest_candidate_delegates">Delegates: </label>
                        <input id="input-contest-candidate-delegates" type="number" name="input_contest_candidate_delegates" class="form-control" required>
                        <input type="submit" class="btn-default" value="Add Voting Details" class="form-control">
                    </fieldset>
                </div>
            </form> <!-- End insert contest_candidate -->
    </div>
EOCONTENT4;

$page->DisplayBottom();

?>