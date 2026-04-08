<?php
    session_start();
    $hidNum = $_SESSION["randNum"];
?>

<html>
    <head>
        <title> Guessing Game </title>
</head>
<body>
    <h1>Guessing Game</h1>
    <?php
    echo "<p>The hidden number was $hidNum.</p>";
    ?>
    <p><a href ="startover.php">Start Over</a></p>
</body>
</html>