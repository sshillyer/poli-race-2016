<?php
ini_set('display_errors', 'On');
require_once( 'helpers.php' );
require_once("php/Page.php");


$page = new Page();

// If embedding any 'quotes' then \'escape them\' !!!!
$page->content = ''; // I think need to embed everything from here to END_EMBED comment

// Extract the post variables
$contest_type = trim($_POST['input_contest_type']);

echo '<p>Hello from insert-contest-type.php</p><ul>'
foreach ($_POST as $input) {
	echo '<li>$input: '.$input.'</li>';
}
echo '</ul>';

// Validate the input (make sure it's at least, say, 3 characters for first and last name)
if (false) {
	// change false to whatever validation we wanted to look for
}

else {
	// Add slashes if needed
	if (!get_magic_quotes_gpc(oid)) {
		$contest_type = addslashes($contest_type);
	}

	// the @ sign is the error suppressino operator, so we can gracefully handle exceptions
	@ $db = new mysqli('serverhost', 'username', 'password', 'db-name');
	
	if (mysqli_connect_errno()) {
		echo '<p>Error: Could not connect to the database. Please try again later.</p>';
		// TODO: probably print a button here to go back to insert page then exit
		insert_button("../index.html", "Back");
		exit;
	}

	$query = 'INSERT INTO contest_type(name) VALUES(?)';
	$stmt = $db->prepare($query);
	$stmt->bind_param('s', $contest_type);
	$stmt->execute();

	// Process resuls shere
	echo '<p>'.$db->affected_rows.' candidate added to database.</p>';
	$stmt->close(); // Might be able to move this to right after the ->execute() call??
	
	// Close resources and close connection
	$result->free();
	$db->close();	
}


$page->$header = 'Insert Candidate into Database';
$page->Display();


// Attempt to insert the new contest_type
//INSERT INTO contest_type(name) VALUES([$contest_type]);


?>