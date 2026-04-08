<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();


$app->get('/', function (Request $request, Response $response, $args) {
 	
	$response->getBody()->write('
	<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en" >
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <title>Demo: Restful Web Services using SLIM Framework</title>
  <link rel="stylesheet" href="php_styles.css" type="text/css" /> 
</head>
<body>
<h1>Demo: Restful Web Services using SLIM Framework</h1>
<h2>Car Inventory Management</h2>

<p><a href="display">Display Cars Example </a> <br /> - Display all cars</p>
<p><a href="insertform.html">Add Cars Example </a> <br /> - HTML Add form and Insert</p>
<p><a href="search_form">Search Cars Example </a> <br /> - Search Cars Form and Display</p>
</body>
</html>
	');
    return $response;
});

$app->get('/display', function (Request $request, Response $response, $args) {
 	
	$a = displayCars();
	$response->getBody()->write($a);
    return $response;
});

$app->get('/search/{make}', function (Request $request, Response $response, $args) {
 	
	$make = $args['make'];
	// echo $make;
	$a = displayCars();
	$response->getBody()->write($a);
    return $response;
});

// for insert, use the url: http://localhost:8081/insert?id=00003&make=bmw&model=1series&price=30000
$app->get('/insert', function (Request $request, Response $response, $args) {
 	
	$params = $request->getQueryParams();
	echo print_r($params);
	$a = insertCars($params);
	$response->getBody()->write($a);
    return $response;
});

$app->post('/insertpost', function (Request $request, Response $response, $args) {
 	
	$params = $request->getParsedBody();
	echo print_r($params);
	$a = insertCars($params);
	$response->getBody()->write($a);
    return $response;
});



$app->get('/test', function (Request $request, Response $response, $args) {
    $a = testFunction();
	$response->getBody()->write($a);
    return $response;
});



function testFunction() {
  return "test function return successfully!";
}

function displayCars(){
	
	$sql_host="localhost";
	$sql_user="root";
	$sql_pass="";
	$sql_db="jiyu";
	$sql_tble="car";
	
	$conn = @mysqli_connect($sql_host,
		$sql_user,
		$sql_pass,
		$sql_db
	);
  
	// Checks if connection is successful
	if (!$conn) {
		// Displays an error message, avoid using die() or exit() as this terminates the execution
		// of the PHP script
		echo "<p>Database connection failure</p>";
	} else {
		// Upon successful connection
		
		// Set up the SQL command to add the data into the table
		$query = "select * from $sql_tble";
		// echo $query;	
		// executes the query and store result into the result pointer
		$result = mysqli_query($conn, $query);
		
		// checks if the execuion was successful
		if(!$result) {
			echo "<p>Something is wrong with ",	$query, "</p>";
		} else {
			// Display the retrieved records
			echo "<table border=\"1\">";
			echo "<tr>\n"
				 ."<th scope=\"col\">ID</th>\n"
			     ."<th scope=\"col\">Make</th>\n"
				 ."<th scope=\"col\">Model</th>\n"
				 ."<th scope=\"col\">Price</th>\n"
				 ."</tr>\n";
			// retrieve current record pointed by the result pointer
			// Note the = is used to assign the record value to variable $row, this is not an error
			// the ($row = mysqli_fetch_assoc($result)) operation results to false if no record was retrieved
			// _assoc is used instead of _row, so field name can be used
			while ($row = mysqli_fetch_assoc($result)){
				echo "<tr>";
				echo "<td>",$row["ID"],"</td>";
				echo "<td>",$row["Make"],"</td>";
				echo "<td>",$row["Model"],"</td>";
				echo "<td>",$row["Price"],"</td>";
				echo "</tr>";
			}
			echo "</table>";
			// Frees up the memory, after using the result pointer
			mysqli_free_result($result);
		} // if successful query operation
		
		// close the database connection
		mysqli_close($conn);
	} // if successful database connection

	return "";
}

function searchCars($make){
	
	$sql_host="localhost";
	$sql_user="root";
	$sql_pass="";
	$sql_db="jiyu";
	$sql_tble="car";
	
	$conn = @mysqli_connect($sql_host,
		$sql_user,
		$sql_pass,
		$sql_db
	);
  
	// Checks if connection is successful
	if (!$conn) {
		// Displays an error message, avoid using die() or exit() as this terminates the execution
		// of the PHP script
		echo "<p>Database connection failure</p>";
	} else {
		// Upon successful connection
		
		// Get data from the form
		// $make=$_POST["make"];
	
		// Set up the SQL command to retrieve the data from the table
		// % symbol represent a wildcard to match any characters
		// like is a compairson operator
		$query = "select * from $sql_tble where make like '$make%'";
		
		// executes the query and store result into the result pointer
		$result = mysqli_query($conn, $query);
		// checks if the execuion was successful
		if(!$result) {
			echo "<p>Something is wrong with ",	$query, "</p>";
		} else {
			// Display the retrieved records
			echo "<table border=\"1\">";
			echo "<tr>\n"
				 ."<th scope=\"col\">ID</th>\n"
			     ."<th scope=\"col\">Make</th>\n"
				 ."<th scope=\"col\">Model</th>\n"
				 ."<th scope=\"col\">Price</th>\n"
				 ."</tr>\n";
			// retrieve current record pointed by the result pointer
			// Note the = is used to assign the record value to variable $row, this is not an error
			// the ($row = mysqli_fetch_assoc($result)) operation results to false if no record was retrieved
			// _assoc is used instead of _row, so field name can be used
			while ($row = mysqli_fetch_assoc($result)){
				echo "<tr>";
				echo "<td>",$row["ID"],"</td>";
				echo "<td>",$row["Make"],"</td>";
				echo "<td>",$row["Model"],"</td>";
				echo "<td>",$row["Price"],"</td>";
				echo "</tr>";
			}
			echo "</table>";
			// Frees up the memory, after using the result pointer
			mysqli_free_result($result);
		} // if successful query operation
		
		// close the database connection
		mysqli_close($conn);
	} // if successful database connection

	return "";
}


function insertCars($params){
	
	$sql_host="localhost";
	$sql_user="root";
	$sql_pass="";
	$sql_db="jiyu";
	$sql_tble="car";

	$conn = @mysqli_connect($sql_host,
		$sql_user,
		$sql_pass,
		$sql_db
	);
	
	// Checks if connection is successful
	if (!$conn) {
		// Displays an error message, avoid using die() or exit() as this terminates the execution
		// of the PHP script
		echo "<p>Database connection failure</p>";
	} else {
		// Upon successful connection
		
		// Get data from the form
		$id1    = $params["id"];
        $make	= $params["make"];
		$model	= $params["model"];
		$price	= $params["price"];
		

		// Set up the SQL command to add the data into the table
		$query = "insert into $sql_tble"
						."(id, make, model, price)"
					. "values"
						."('$id1','$make','$model', $price)";
echo $query;
		// executes the query
		$result = mysqli_query($conn, $query);
		// checks if the execution was successful
		if(!$result) {
			echo "<p>Something is wrong with ",	$query, "</p>";
		} else {
			// display an operation successful message
			echo "<p>Success</p>";
		} // if successful query operation

		// close the database connection
		mysqli_close($conn);
	}
		
	return "";
}



$app->run();


