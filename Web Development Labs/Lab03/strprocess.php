<!DOCTYPE html>
<html>
<head>
    <meta charset= "UTF-8">
    <title> Using string functions </title>
</head>
<body>
    <h1>Web Development - Lab 3</h1>
    <?php
		if (isset($_POST["inputstr"])) {
			$str = $_POST["inputstr"];	// retrieve the input string
			$pattern = "/^[A-Za-z ]+$/"; // Allow only letters and spaces

			// Validate using regular expression
			if (preg_match($pattern, $str)) {
				$ans = "";							// Result String
				$len = strlen($str);				// Length of input string

				// Loop through each character
				for ($i = 0; $i < $len; $i++) {
					$letter = substr ($str, $i, 1); // Extract one character

					// Check if the character is not a vowel
					if (!is_numeric (strpos("AEIOUaeiou", $letter))) {
						$ans = $ans . $letter;
					}
				}

				// Output result
				echo "<p>The word with no vowels is ", $ans, ".</p>";
			} else {

				echo "<p>Please enter a string containing only letters or space.</p>";
			}
		} else {
			echo "<p>Please enter string from the input form.</p>";
		}
    ?>
</body>
</html>
