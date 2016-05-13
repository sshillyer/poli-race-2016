<?php
ini_set('display_errors', 'On');
require_once('helpers.php');
require_once("select-table.php");
require_once("Page.php");

// Create new Page object and display top of page content
$page = new Page();
$page->header = 'Display All Parties';
$page->DisplayTop();

// Extract the query type. 
$query_type = ($_POST['query_selection']);


switch ($query_type) {
	// Display States
	case "all_states":
		$query = "SELECT name AS 'State', abbreviation AS 'Abbreviation' FROM `state` AS s ORDER BY 'State' ASC";

		break;


	// Display Political Parties
	case "all_parties":
		$query = "SELECT name as 'Party' FROM `party` AS p ORDER BY 'Party' ASC";

		break;


	// Display Types of Contests
	case "all_contest_types":
		$query = "SELECT name AS 'Contest Type' FROM `contest_type` AS ct ORDER BY 'Contest Type' ASC";

		break;


	// Display Political Candidates
	case "all_candidates":
		$query = "SELECT 
			CONCAT(c.`fname`, ' ', c.`lname`) AS 'Candidate',
			p.`name` AS 'Party'
		FROM
			`candidate` AS c
		INNER JOIN
			`party` AS p ON c.`party_id`=p.`id`
		ORDER BY
			'Candidate' ASC";

		break;

	// Display Contest Events 
	case "all_contests":
		$query = "SELECT
			DATE(`contest`.`contest_date`) as `Date`,
			`state`.`name` as `State`,
			`party`.`name` as `Party`,
			`type`.`name` as `Contest Type`
		FROM
		  	`contest`
		INNER JOIN
			`state` ON `state`.`id`=`contest`.`state_id`
		INNER JOIN
			`party` ON `party`.`id`=`contest`.`party_id`
		INNER JOIN
			`contest_type` AS `type` ON `type`.`id`=`contest`.`contest_type_id`";

		break;


	// Display Contest Events
	case "all_contest_candidates":
		$query = "SELECT
			CONCAT(c.`fname`, ' ', c.`lname`) AS `Candidate`,
			p.`name` AS 'Party',
			SUM(`details`.`vote_count`) AS `Total Votes`,
			SUM(`details`.`delegate_count`) AS `Total Delegates`
		FROM 
			`candidate` as c
		INNER JOIN
			`party` AS p
			ON p.`id`=c.`party_id`
		INNER JOIN
			`contest_candidate` AS `details`
			ON `details`.`candidate_id`=c.`id`
		GROUP BY
			`details`.`candidate_id`";

		break;

	// Additional query routes can be below here :)
}


build_table_from_query($query);

insert_button("../queries.php", "Select Different Query");
insert_button("../index.php", "Insert More Data");
// $page->DisplayBottom();

?>