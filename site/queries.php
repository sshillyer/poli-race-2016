<?php
ini_set('display_errors', 'On');
require_once('php/helpers.php');
require_once('php/Page.php');

// Create new Page object and display top of page content
$page = new Page();
$page->header = 'Query the Database';
$page->DisplayTop();

insert_button("index.php", "Insert Records into Database");

// TODO: Make these links to individual php pages that process each kind of request for now. Could alternatively route them all into a single .php file that uses a switch case in the body to run the relevant queries??
echo <<<EOCONTENT
<div class="row">
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