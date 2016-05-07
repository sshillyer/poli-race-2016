<?php
require("sql/Page.php");

$page = new Page();
// If embedding any 'quotes' then \'escape them\' !!!!
$page->content = '';

$page->$header = 'Insert Records into Database';
$page->Display();

?>