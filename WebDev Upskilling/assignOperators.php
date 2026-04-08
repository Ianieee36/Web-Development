<html>
    <head>
        <title> Operators </title>
    </head>
<body>
    <h1> Assignment Operators</h1>

    <?php

    $firstName = "Christian"; // declare a variable and initialize string value 
    $lastName = "Cantos";     // using = to assign value
    $firstName .= " " . $lastName; // concatenate with space using .= (string)
    
    $num1 = 10;
    $num2 = 5;
    $num1 += $num2;
    

    echo "<p>10 + 5 is: $num1</p>";
    echo "<p>My name is: $firstName </p>";
    echo gettype($num1); 


    ?>
</body>
</html>
