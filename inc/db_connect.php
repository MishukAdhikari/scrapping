<?php











/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = mysqli_connect("localhost", "root", "", "demo");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
// Attempt insert query execution
$sql = "INSERT INTO persons (first_name, last_name, email) VALUES
            ('John', 'Rambo', 'johnrambo@mail.com'),
            ('Clark', 'Kent', 'clarkkent@mail.com'),
            ('John', 'Carter', 'johncarter@mail.com'),
            ('Harry', 'Potter', 'harrypotter@mail.com')";
if(mysqli_query($link, $sql)){
    echo "Records added successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
 
// Close connection
mysqli_close($link);



















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
	$sql = "CREATE TABLE IF NOT EXISTS QuoteScrap (
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

		//$string = mysql_real_escape_string($string);

		mysqli_query($conn, "INSERT INTO QuoteScrap (id, quote, tags, page_no) VALUES ({$string})");

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

			//$string = mysql_real_escape_string($string);

			mysqli_query($conn, "INSERT INTO QuoteScrap (id, quote, tags, page_no) VALUES ({$string})");
		}
	}