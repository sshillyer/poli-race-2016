<?php

// Extract the post variables
$contest_type = $_POST['input_contest_type'];

// Attempt to insert the new contest_type
//INSERT INTO contest_type(name)
//    VALUES([$contest_type]);

echo '<p>Hello from insert-contest-type.php</p>';
echo '<p>Received the following variables:<p><ul>';
echo "<li>contest_type: $contest_type </li>";
echo '</ul>';
>
    