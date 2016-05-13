<?php
ini_set('display_errors', 'On');
require_once('helpers.php');
require_once("select-table.php");
require_once("Page.php");

// Create new Page object and display top of page content
$page = new Page();
$page->header = 'Display All States';
$page->DisplayTop();

build_table_from_query("SELECT name AS 'State', abbreviation AS 'Abbreviation' FROM `state` AS s ORDER BY 'State' ASC");

insert_button("../index.php", "Back");
$page->DisplayBottom();

?>