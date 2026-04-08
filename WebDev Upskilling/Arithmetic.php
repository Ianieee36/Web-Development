<html>
    <head>
        <title> PHP Upskilling </title>
        <h1> Arithmetic Operators </h1>
</head>
<body>

<?php

$firstNumber = 10;
$secondNumber = 15;
$additionResult = $firstNumber + $secondNumber;
$subtractResult = $firstNumber - $secondNumber;
$multiplyResult = $firstNumber * $secondNumber;
$divisionResult  = $firstNumber / $secondNumber;



function gcd($a, $b) { // Euclidian Algorithm getting GCD
    $large = $a > $b ? $a: $b;
    $small = $a > $b ? $b: $a;
    $remainder = $large % $small;
    return 0 == $remainder ? $small: gcd($small, $remainder);
}

echo "<p>$firstNumber + $secondNumber is: $additionResult</p>";
echo "<p>$firstNumber - $secondNumber is: $subtractResult</p>";
echo "<p>$firstNumber * $secondNumber is: $multiplyResult</p>";
echo "<p>$firstNumber / $secondNumber is: $divisionResult</p>";

echo "<p>The GCD of $firstNumber and $secondNumber is: ", gcd($firstNumber, $secondNumber),"</p>";

?>


</body>
</html>
