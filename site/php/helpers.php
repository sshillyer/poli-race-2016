<?php
ini_set('display_errors', 'On');

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
function has_length_in_range($str, $min, $max) {
	$length = strlen($str);
	if ($length >= $min && $length <= $max)
		return true;
	else return false;
}

// @return {mysql db connection} $dbConnection: Returns a connection using mysqli
// Separated out so we can centralize the variables used to connect in a single
// function and change all connections using one file, error handling, etc.
// Citation: http://www.pontikis.net/blog/how-to-use-php-improved-mysqli-extension-and-why-you-should
function connect_to_db() {
	ini_set('display_errors', 'On');

	$DBServer = 'oniddb.cws.oregonstate.edu';
	$DBUser = 'hillyers-db';
	$DBPass = '44OmOgdJsLfo4lNB'; // TODO: Make this come from a file in non-public directory a couple levels down and add define as a constant?
	$DBName = 'hillyers-db';

	@ $dbConnection =  new mysqli($DBServer, $DBUser, $DBPass, $DBName);

	if (mysqli_connect_errno()) {
	    printf("Connect failed: %s\n", mysqli_connect_error());
		insert_button("../index.php", "Back");
		return NULL;
	}

	else
		return $dbConnection;
}

?>