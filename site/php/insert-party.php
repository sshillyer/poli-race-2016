<?php

// Extract the post variables
$party_name = $_POST['input_party_name'];

// Attempt to insert the new party
//INSERT INTO party(name)
//    VALUES([$party_name]);

echo '<p>Hello from insert-party.php</p>';
echo '<p>Received the following variables:<p><ul>';
echo "<li>party_name: $party_name</li>";
echo '</ul>';
>
    