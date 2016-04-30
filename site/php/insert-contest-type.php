<?php

// Extract the post variables
$contest_type = trim($_POST['input_contest_type']);

echo '<p>Hello from insert-contest-type.php</p>'
foreach ($_POST as $input) {
	echo '<li>$input: '.$input.'</li>';
}
echo '</ul>'

// Attempt to insert the new contest_type
//INSERT INTO contest_type(name)
//    VALUES([$contest_type]);


>
    