<?php
ini_set('display_errors', 'On');

require_once('helpers.php');


// @param {string} $table_name : name of table to select from
// @param {string} $attribute : the column to select to retreive a label from
$table_name = 'state';
$attribute = 'name';

	if (!get_magic_quotes_gpc()) {
		if ($table_name != null) $table_name = addslashes($table_name);
		if ($attribute != null) $attribute = addslashes($attribute);
		// if ($label != null) $label = addslashes($label);
	}

	// Connect to DB
	if(($db = connect_to_db()) == null) {
		return;
	}

	// Preload query - select id from $table_name
	$query = 'SELECT id,'.$attribute.' FROM '.$table_name;

	if ($stmt = $db->prepare($query)) {
		// $stmt->bind_param($attribute, $table_name);
		$stmt->execute();
		$stmt->bind_result($r_id, $r_label);

		// Build the dropdown box
		echo '<select name="'.$table_name.'_'.'id'.'">';
		while ($stmt->fetch()) {
			echo '<option value="'.$r_id.'">'.$r_label.'</option>';
		}
		echo '</select>';

		$stmt->close();
	}

	$db->close();
?>