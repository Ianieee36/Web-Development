<html>
<head></head>
</head>
<body>
<h1> Task 2: Using Expression </h1>     
<?php
$integer = isset($_GET['number']) ? intval($_GET['number']) : null;

(is_int($integer))
    ? $result = "has a value"
    : $result = "doesn't have a value";

    echo "<p> Variable ", $result,"</p>";

($integer % 2 == 0)
    ? $result = "is an even number"
    : $result = "is an odd number";

    echo "<p> Variable ", $result,"</p>";
?>

</body>
</html>