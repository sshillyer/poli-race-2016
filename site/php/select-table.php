<?php
ini_set('display_errors', 'On');

require_once('hepers.php');

function select($column, $table, $condition = null, $value = null) {
	// Add slashes if needed
	if (!get_magic_quotes_gpc()) {
		$column = addslashes($column);
		$table = addslashes($table);
		if ($condition != null) $condition = addslashes($condition);
		if ($value != null) $value = addslashes($value);
	}

	// Connect to DB
	if(($db = connect_to_db()) == null) {
		exit;
	}

	if ($condition == null && $value == null) {
		$query = 'SELECT ? FROM $';
		$stmt = $db->prepare($)
	}

	SELECT $column FROM $table

}

?>