<?php
require_once( 'helpers.php' );

// Extract the post variables
$party_name = trim($_POST['input_party_name']);

echo '<p>Hello from insert-party.php</p>'
foreach ($_POST as $input) {
	echo '<li>$input: '.$input.'</li>';
}
echo '</ul>'

// Attempt to insert the new party
//INSERT INTO party(name)
//    VALUES([$party_name]);



?>
    