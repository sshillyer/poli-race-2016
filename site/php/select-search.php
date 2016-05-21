<?php
ini_set('display_errors', 'On');
require_once('helpers.php');
require_once('Page.php');
require_once('select-table.php');

// Create new Page object and display top of page content
$page = new Page();
$page->header = 'Search by Candidate Last Name';
$page->DisplayTop();

// Extract the post variables
$lname = trim($_POST['input_search_name']);


if (!$lname) {
	echo '<p>Error with input. Try again.<p>';
	insert_button("../queries.php", "Select Different Query");
	insert_button("../index.php", "Insert More Data");
	exit;
}

// Execute MySQL Query
else {	
	// Add slashes if needed
	if (!get_magic_quotes_gpc()) {
		$lname = addslashes($lname);
	}

	$query = "SELECT CONCAT(c.`fname`, ' ', c.`lname`) AS 'Candidate', p.`name` AS 'Party' FROM `candidate` AS c INNER JOIN `party` AS p ON c.`party_id`=p.`id` WHERE c.`lname`='$lname' ORDER BY 'Candidate' ASC";
	
	build_table_from_query($query);

}

insert_button("../queries.php", "Select Different Query");
insert_button("../index.php", "Insert More Data");

?>