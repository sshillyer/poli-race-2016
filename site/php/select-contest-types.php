<?php
ini_set('display_errors', 'On');
require_once('helpers.php');
require_once("select-table.php");
require_once("Page.php");

// Create new Page object and display top of page content
$page = new Page();
$page->header = 'Display All Contest Types';
$page->DisplayTop();

build_table_from_query("SELECT name AS 'Contest Type' FROM `contest_type` AS ct ORDER BY 'Contest Type' ASC");

insert_button("../queries.php", "Select Different Query");
insert_button("../index.php", "Insert More Data");
// $page->DisplayBottom();

?>