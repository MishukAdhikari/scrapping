<?php

// Require Files

require_once 'lib/vendor/autoload.php';

use Sunra\PhpSimple\HtmlDomParser;

// Create DOM from URL or file
$html = HtmlDomParser::file_get_html('http://quotes.toscrape.com');


$quotes = $html->find(".quote");

foreach ($quotes as $element) {
	$element = strip_tags($element);
	$element = preg_match('/\“.+(?=\()/', $element, $matches);
	$string = array_shift($matches);
	echo $string.'<br>';
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
	}
}