<?php
ini_set('display_errors', 'On');
require_once('helpers.php');
require_once("Page.php");

// Create new Page object and display top of page content
$page = new Page();
$page->header = 'Query the Database';
$page->DisplayTop();

insert_button("index.php", "Insert Links");

// TODO: Make these links to individual php pages that process each kind of request for now. Could alternatively route them all into a single .php file that uses a switch case in the body to run the relevant queries??
echo <<<EOCONTENT
	Retrieve data from a table:
	List of States: Display state name and abbreviations
	List of Political Parties: Display names of political parties
	List of Contest Types: Display types of contests used in the election process
	List of Candidates: Display a list of political candidates.
	List of Contests: Display the contests.
	List of Voting Details: Display voting results in variosu formats.
EOCONTENT;

$page->DisplayBottom();

// States:








?>