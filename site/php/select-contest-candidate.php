<?php
ini_set('display_errors', 'On');
require_once('helpers.php');
require_once("select-table.php");
require_once("Page.php");

// Create new Page object and display top of page content
$page = new Page();
$page->header = 'Display All Voting Details';
$page->DisplayTop();

build_table_from_query("SELECT
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
	`details`.`candidate_id`  -- Where clause might need to be before the group by clause??
;
");

insert_button("../queries.php", "Select Different Query");
insert_button("../index.php", "Insert More Data");
// $page->DisplayBottom();

?>