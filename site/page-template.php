<?php
	require("sql/Page.php");

	$page = new Page();

	$page->content = '';

    $page->$header = 'Insert Records into Database';
    $page->Display();

?>