<?php

	$servername = $_POST['servername'];
	$username = $_POST['dbusername'];
	$password = $_POST['dbpassword'];
	$dbname = $_POST['dbname'];

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}

	// sql to create table
	$sql = "CREATE TABLE QuoteScrap (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	quote VARCHAR(30) NOT NULL,
	tags VARCHAR(30) NOT NULL,
	page_no VARCHAR(50)
	)";

	if ($conn->query($sql) === TRUE) {
	    echo "Table QuoteScrap created successfully";
	} else {
	    echo "Error creating table: " . $conn->error;
	}

	$conn->close();


	// Require Files

	require_once '../lib/vendor/autoload.php';

	use Sunra\PhpSimple\HtmlDomParser;

	// Create DOM from URL or file
	$html = HtmlDomParser::file_get_html('http://quotes.toscrape.com');


	$quotes = $html->find(".quote");

	foreach ($quotes as $element) {
		$element = strip_tags($element);
		$element = preg_match('/\“.+(?=\()/', $element, $matches);
		$string = array_shift($matches);
		echo $string.'<br>';

		"INSERT INTO QuoteScrap (quote) VALUES ({$string})";
	}

	for ($i=2; $i < 12; $i++) { 
		// Create DOM from URL or file
		$html = HtmlDomParser::file_get_html('http://quotes.toscrape.com/page/'.$i);


		$quotes = $html->find(".quote");

		foreach ($quotes as $element) {
			$element = strip_tags($element);
			$element = preg_match('/\“.+(?=\()/', $element, $matches);
			$string = array_shift($matches);
			echo $string.'<br>';

			"INSERT INTO QuoteScrap (quote) VALUES ({$string})";
		}
	}