<?php

// Extract the post variables
$state_name = $_POST['input_state_name'];
$state_abbrev = $_POST['input_state_abbr'];

// Validate that abbreviation is exactly two characters long

// Attempt to insert new state

//INSERT INTO state(name, abbreviation)
//    VALUES([$state_name], [$state_abbrev]);

echo '<p>Hello from insert-state.php</p>';
echo '<p>Received the following variables:<p><ul>';
echo "<li>state_name: $state_name</li>";
echo "<li>state_abbrev: $state_abbrev</li>";
echo '</ul>';
>
    