<?php
ini_set('display_errors', 'On');

require_once('helpers.php');


// @param {string} $table_name : name of table to select from
// @param {string} $attribute : the column to select to retreive a label from
function build_dropdown_menu($table_name, $attribute, $alt_query=null) {
	if (!get_magic_quotes_gpc()) {
		if ($table_name != null) $table_name = addslashes($table_name);
		if ($attribute != null) $attribute = addslashes($attribute);
	}

	// Connect to DB
	if(($db = connect_to_db()) == null) {
		return;
	}

	// Preload query - select id from $table_name
	// NOTE: You cannot use the ? syntax for DDL things like tables, attributes, etc., only for DML. This means we need to manually build
	// the string. This would be a point of vulnerability if we allowed a user to use this code... might still be a risk but no other
	// modular option I can see. --SSH
	// Source for this point of interest: http://php.net/manual/en/mysqli.prepare.php
	if ($alt_query) {
		$query = $alt_query;
	} else {
		$query = 'SELECT id,'.$attribute.' FROM '.$table_name.' ORDER BY '.$attribute;
	}


	if ($stmt = $db->prepare($query)) {
		$stmt->execute();
		$stmt->bind_result($r_id, $r_label);

		// Build the dropdown box
		echo '<select name="'.$table_name.'_'.'id'.'"class="form-control">';
		while ($stmt->fetch()) {
			echo '<option value="'.$r_id.'">'.$r_label.'</option>';
		}
		echo '</select>';

		$stmt->close();
	}

	$db->close();
}

?>