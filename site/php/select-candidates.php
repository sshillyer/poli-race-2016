<?php
ini_set('display_errors', 'On');
require_once('helpers.php');
require_once("select-table.php");
require_once("Page.php");

// Create new Page object and display top of page content
$page = new Page();
$page->header = 'Display All Candidates';
$page->DisplayTop();

build_table_from_query("SELECT 
	CONCAT(c.`fname`, ' ', c.`lname`) AS 'Candidate',
	p.`name` AS 'Party'
FROM
	`candidate` AS c
INNER JOIN
	`party` AS p ON c.`party_id`=p.`id`
ORDER BY
	'Candidate' ASC");

insert_button("../queries.php", "Select Different Query");
insert_button("../index.php", "Insert More Data");
// $page->DisplayBottom();

?>