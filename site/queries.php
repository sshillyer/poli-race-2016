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
	<ul>Retrieve data from a table:
	<li><a href="php/select-states.php">List of States: Display state name and abbreviations</a></li>
	<li><a href="php/select-parties.php">List of Political Parties: Display names of political parties</a></li>
	<li><a href="php/select-contest-types.php">List of Contest Types: Display types of contests used in the election process</a></li>
	<li><a href="php/select-candidates.php">List of Candidates: Display a list of political candidates.</a></li>
	<li><a href="php/select-contests.php">List of Contests: Display the contests.</a></li>
	<li><a href="php/select-contest-candidate.php">List of Voting Details: Display voting results in variosu formats.</a></li>
	</ul>
EOCONTENT;

$page->DisplayBottom();

// States:








?>