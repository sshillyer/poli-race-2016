<?php
ini_set('display_errors', 'On');
require_once('php/helpers.php');
require_once('php/Page.php');

// Create new Page object and display top of page content
$page = new Page();
$page->header = 'Query the Database';
$page->DisplayTop();

insert_button("index.php", "Back to Insert Page");

// TODO: Make these links to individual php pages that process each kind of request for now. Could alternatively route them all into a single .php file that uses a switch case in the body to run the relevant queries??
echo <<<EOCONTENT
<div class="row">
<p>This will be deprecated once dropdown and select-route.php done</p>
	<ul>Retrieve data from a table:
	<li><a href="php/select-states.php">List of States: Display state name and abbreviations</a></li>
	<li><a href="php/select-parties.php">List of Political Parties: Display names of political parties</a></li>
	<li><a href="php/select-contest-types.php">List of Contest Types: Display types of contests used in the election process</a></li>
	<li><a href="php/select-candidates.php">List of Candidates: Display a list of political candidates.</a></li>
	<li><a href="php/select-contests.php">List of Contests: Display the contests.</a></li>
	<li><a href="php/select-contest-candidate.php">List of Voting Details: Display voting results (Calculates SUM of votes for all events grouped by candidate).</a></li>
	</ul>
</div> <!-- End row -->

<div class="row">
	<p>Going to make an dropdown list of queries and a submit button that routes to select-route.php; this will pass in a variable that tells it which query to run and will render the page.</p>
	
	<form action="php/select-route.php" role="form" method="post">
	<div class="form-group">
		<fieldset>
			<legend class="bg-primary">Select Query to Run</legend>
			<label for="query_selection">Select a query</label>
			<select name="query_selection" class="form-control">
				<option value="all_states">Display States</option>
				<option value="all_parties">Display Political Parties</option>
				<option value="all_contest_types">Display Types of Contests</option>
				<option value="all_candidates">Display Political Candidates</option>
				<option value="all_contests">Display Contest Events</option>
				<option value="all_contest_candidates">Display Voting Details</option>
				<option value="">PLACEHOLDER</option>
				<option value="">PLACEHOLDER</option>
				<option value="">PLACEHOLDER</option>
			</select>
			<input type="submit" class="btn-default" value="Run Query" class="form-control">
		</fieldset>
	</div> <!-- End form-group -->
	</form>
</div> <!-- End row -->
EOCONTENT;

$page->DisplayBottom();

// States:








?>