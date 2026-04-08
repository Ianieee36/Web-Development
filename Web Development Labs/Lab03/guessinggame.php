<?php
    session_start();
    if (!isset($_SESSION["randNum"])) {
        $_SESSION["randNum"] = rand(1, 100);
    }
    $randNum = $_SESSION["randNum"];
    $guessNum = isset($_POST["number"]) ? (int)$_POST["number"] : null;
?>

<html>
    <head>
        <title> Guessing Game </title>
</head>
<body>
    <h1>Guessing Game</h1>
    <h2>Enter a number between 1 and 100 <br> then press the Guess button</h2>

    <form method="post" action="">
        <input type="number" name="number" min="1" max="100" required>
        <input type="submit" value="Guess">
    </form>

    <?php
       if ($guessNum !== null) {
           if($guessNum == $randNum) {
                echo "<p>Congratulations! You guessed the hidden number.</p>";
           } else if($guessNum > $randNum) {
                echo "<p>Too High!</p>";
           } else if ($guessNum < $randNum) {
                echo "<p>Too Low!</p>";
           } else {
                echo "<p>Invalid Input!</p>";
           }
       }
    ?>

    <p><a href ="giveup.php">Give Up</a></p>
    <p><a href ="startover.php">Start Over</a></p>
</body>
</html>