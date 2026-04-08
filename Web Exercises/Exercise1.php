<!DOCTYPE html>
<html>
    <head>
        <title> Using variables, arrays and operators </title>
    </head>
    <body>
        <h1> Web Development </h1>
        <h2> Average Mark </h2>
    <?php
        $marks = array(75,90,95);
        $marks[1] = 90;
        $ave = ( $marks[0] + $marks[1] + $marks[2] ) / 3;

        ($ave >= 50)
            ? $status = "PASSED"
            : $status = "FAILED";

        echo "<p>The average score is $ave. You $status</p>";
    ?>
    </body>
    </html>



