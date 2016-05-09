<?php
ini_set('display_errors', 'On');
// Include any external libraries here using require_once('file.php')
// (The idea is we would use this as a single master header file and include only the one we need across all our files)


// @param {string} url : Link for href attribute
// @param {string} lable : Text on the button
// @param {sring} style : suffix for the bootstrap btn- styles: default | primary | success |  info | warning | etc.
function insert_button($url, $label, $style='default') {
	echo '<p><a href="'.$url.'" class="'.$style.'">'.$label.'</a></p>';
}		

// @param {string} str : String to validate length of
// @param {int} min : Minimum length of string (inclusive)
// @param {int} max : Maximum length of string (inclusive)
function hasLengthInRange($str, $min, $max) {
	$length = strlen($str);
	if ($length >= $min && $length <= $max)
		return true;
	else return false;
}


?>