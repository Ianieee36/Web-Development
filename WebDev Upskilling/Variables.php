<html>
<head>
</head>
<body>

<h1>Variables</h1>
<?php

if (isset($_POST['age'])) {
    $age = intval($_POST['age']);
    echo "<p>My age is $age</p>";
}
    
?>

</body>
</html>