<?php
ini_set('display_errors', 'On');
require_once('helpers.php');
require_once("select-table.php");
require_once("Page.php");

// Create new Page object and display top of page content
$page = new Page();
$page->header = 'Display All Contests';
$page->DisplayTop();

build_table_from_query("SELECT
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
	`contest_type` AS `type` ON `type`.`id`=`contest`.`contest_type_id`
");

insert_button("../queries.php", "Select Different Query");
insert_button("../index.php", "Insert More Data");
// $page->DisplayBottom();

?>