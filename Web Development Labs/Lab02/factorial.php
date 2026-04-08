<html>
<head>

<body>
<h1>Task 3: Conditional Statements</h1>
<?php
include 'mathfunctions.php';
if (isset($_POST['number'])) {
    $num = intval($_POST['number']);
    echo "<p>Factorial of $num is: ", factorial($num), "</p>";
}
?>
</body>
</head>
</html>
