<?php
ini_set('display_errors', 'On');
// Include any external libraries here using require_once('file.php')
// (The idea is we would use this as a single master header file and include only the one we need across all our files)


// @param {string} $url : Link for href attribute
// @param {string} $lable : Text on the button
// @param {sring} $style : suffix for the bootstrap btn- styles: default | primary | success |  info | warning | etc.
// @ret {void} : Side-effects only
function insert_button($url, $label, $style='default') {
	echo '<p><a href="'.$url.'" class="'.$style.'">'.$label.'</a></p>';
}		

// @param {string} $str : String to validate length of
// @param {int} $min : Minimum length of string (inclusive)
// @param {int} $max : Maximum length of string (inclusive)
// @return {bool} : true if strlen(str) in range [min..max] inclusive, false otherwise
function hasLengthInRange($str, $min, $max) {
	$length = strlen($str);
	if ($length >= $min && $length <= $max)
		return true;
	else return false;
}

// @return {mysql db connection} $dbConnection: Returns a connection using mysqli
// Separated out so we can centralize the variables used to connect in a single
// function and change all connections using one file, error handling, etc.
function connectToDb() {
	@ $dbConnection =  new mysqli('serverhost', 'username', 'password', 'db-name');
	if (mysqli_connect_errno()) {
		echo '<p>Error: Could not connect to the database. Please try again later.</p>';
		// TODO: probably print a button here to go back to insert page then exit
		insert_button("../index.php", "Back");
		return NULL;
	}
	else
		return dbConnection;
}

?>