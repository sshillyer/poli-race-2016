<?php
ini_set('display_errors', 'On');

// Cite: Page 177 of "PHP and MYSQL Web Dev 4th Edition"
class Page {
	public $content;
	public $title = "Political Race 2016 - Database Admin Tool";
	public $header = "Default Header -- FIX ME!";

	// Public setter function -- much more generic than you'd see in C++/JAVA
	public function __set($name, $value) {
		$this->$name = $value;
	}

	public function Display() {
		// html, head, metadata, and opening body elements
		echo '<html lang="en">';
		echo '<head>';
			$this->DisplayMeta();
			$this->DisplayTitle();
			$this->DisplayStyles();
			$this->DisplayScripts();
		echo '</head>';
		echo '<body>';
			$this->DisplayHeader();

		// echo the contents of this specific page
		echo $this->content;
		
		// Print the footer and close tags out
		$this->DisplayFooter();
		echo '</body>';
		echo '</html>';
	}

	public function DisplayTop() {
		echo '<html lang="en">';
		echo '<head>';
		$this->DisplayMeta();
		$this->DisplayTitle();
		$this->DisplayStyles();
		$this->DisplayScripts();
		echo '</head>';
		echo '<body>';
		$this->DisplayHeader();
	}

	public function DisplayBottom() {
		// Print the footer and close tags out
		$this->DisplayFooter();
		echo '</body>';
		echo '</html>';
	}

	public function DisplayTitle() {
		echo '<title>'.$this->title.'</title>';
	}

	public function DisplayMeta() {
		echo '    <meta charset="utf-8">';
    	echo '    <meta name="viewport" content="width=device-width, initial-scale=1">';
	}

	public function DisplayStyles() {
		echo '    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">';

	}

	public function DisplayScripts() {
		echo '    <script src="//code.jquery.com/jquery-2.0.2.min.js"></script>';
		echo '    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>';
		echo '    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>';
	}

	public function DisplayHeader() {
		echo '    <div class="container">';
		echo '        <h1 class="page-header text-primary">'.$this->header.'</h1>';
	}

	// Rather than echo each line, you can close the php tag, place HTML, and
	// then reopen the PHP tag at end of function. Makes multiple lines of HTML easier
	// to edit or copy-paste into a function like this. Careful that syntax all HTML inside
	public function DisplayFooter() {
		?>
		        <!-- Footer -->
		        <div class="row">
		            <footer><p>Copyright 2016 - Shawn S Hillyer & Jason Goldfine-Middleton</p></footer>
		        </div> 
		    </div> <!-- END "container" DIV -->
	    <?php
	}
} // END Page class

?>