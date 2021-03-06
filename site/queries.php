<?php
ini_set('display_errors', 'On');
require_once('php/helpers.php');
require_once('php/Page.php');

// Create new Page object and display top of page content
$page = new Page();
$page->header = 'Query the Database';
$page->DisplayTop();

insert_button("index.php", "Insert Records into Database");

// Dropdown form to route people using select-route.php, and a simple search form for a standlone search feature.
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
				<option value="all_contest_delegates">Display Number of Delegates Available per Contest</option>
				<option value="most_recent_wins">Display Candidates' Most Recent Wins</option>
			</select>
			<input type="submit" class="btn-default" value="Run Query" class="form-control">
		</fieldset>
	</div> <!-- End form-group -->
	</form>

	<form action="php/select-search.php" role="form" method="post">
	<div class="form-group">
		<fieldset>
			<legend class="bg-primary">Select Query to Run</legend>
			<label for="input_search_name">Search for a candidate by last name:</label>
			<input id="input-search-name" type="text" name="input_search_name" class="form-control" required>
			<input type="submit" class="btn-default" value="Search by last name" class="form-control">
		</fieldset>
	</div> <!-- End form-group -->
	</form>
</div> <!-- End row -->
EOCONTENT;

$page->DisplayBottom();

?>