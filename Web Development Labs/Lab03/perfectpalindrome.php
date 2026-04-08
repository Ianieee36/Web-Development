<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title> Using string functions </title>
	</head>
<body>
	<h1> Web Development - Lab 3 </h1>
<?php
	
	if(isset($_POST["inputstr"])) {
		$str = $_POST["inputstr"];
		$lower = strtolower($str);
		$rev = strrev($lower);

		if(strcmp($lower, $rev) == 0) {
			echo "<p>The word ",$str, " is a palindrome.</p>";
		} else {
			echo "<p>The word ",$str, " is not a palindrome.</p>";
		}
	}
?>

</body>
</html>