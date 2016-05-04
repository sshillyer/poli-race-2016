// helper functions we can re-use
<?php
	// Include any external libraries here using require_once('file.php')
	// (The idea is we would use this as a single master header file and include only the one we need across all our files)


// @param {string} url : Link for href attribute
// @param {string} lable : Text on the button
// @param {sring} style : suffix for the bootstrap btn- styles: default | primary | success |  info | warning | etc.
function insert_button($url, $label, $style='default') {
	echo '<p><a href="'.$url.'" class="'.$style.'">'.$description.'</a></p>'
}		




>