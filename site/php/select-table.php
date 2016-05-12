<?php
ini_set('display_errors', 'On');

require_once('hepers.php');


// @param {string} $table_name : name of table to select from
// @param {string} $attribute : the column to select to retreive a label from
function build_dropdown_menu($table_name, $attribute) {
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
	$query = "SELECT id, ? FROM ?"; 
	$stmt = $db->prepare($query);
	$stmt->bind_param('ss', $attribute, $table_name);
	$stmt->bind_result($r_id, $r_label);
	$stmt->execute();

	// Process results
	$num_rows = $stmt->affectected_rows();
	echo '<select name="'.$table_name.'-'.'id'.'">';
	for ($i = 0; i < $num_rows; i++) {
		$stmt->fetch(); // Get next row of data
		echo '<option value="'.$r_id.'">'.$r_label.'</option>';
	}
	echo '</select>';

	// Close resources and close connection
	$stmt->close();
	$db->close();

	return $results;
}



function build_table_from_array($data) {
	return;
}

function build_dropdown_from_data($data) {
	return;
}

// function build_state_dropdown_menu() {
// 	$states = get_ids_with_label_from_table('state', 'name', 'State');
// 	build_dropdown_from_data($states);
// }
?>