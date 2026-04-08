<!DOCTYPE html>
<html>
    <head>
        <title> Trying Arrays </title>
</head>
<body>
    <h1> Arrays</h1>
    <?php

        // Multi-Dimensional Arrays
        // $cars = array 
        // (
        //     array("Volvo", 22, 18),
        //     array("BMW", 15, 13),
        //     array("Saab", 5, 2),
        //     array("Land Rover", 17, 15)
        // );

        // Associative Arrays
        // $age1 = array("Peter"=>"35", "Ben"=>"37","Joe"=>"43");
        // $age2 = array("Chris"=>"25", "Jel"=>"23","Rob"=>"25"); 
        // foreach($age as $x => $x_value) {
        //     echo "Key=", $x,", Value=", $x_value;
        //     echo "<br>";
        // }

        // echo "<p>Car: ",$cars[0][0], "</p>";
        // echo "<p>Stock: ", $cars[0][1], "</p>";
        // echo "<p>Sold: ", $cars[0][2], "</p>";

        $food = array
        (
            "Pizza",
            "Chicken",
            "Burger",
            "Fries",
            "Pierre Sushi"

        );

        $restaurant = array
        (
            "Dominos",
            "KFC",
            "BurgerFuel",
            "Maccas",
            "Pierre Sushi"
        );

        // $menu = array_merge($food, $restaurant);
        // print_r($menu[1]);

        // $menu = array_merge($food, $restaurant);
        // print_r($menu);

        // $ageArray = array_merge($age1, $age2);
        // print_r($ageArray);
        
        $menu1 = array_diff($food, $restaurant); // Find Differences
        print_r($menu1);

        $menu2 = array_intersect($food, $restaurant); // Find Similarities
        print_r($menu2);

    ?>
    </body>
    </html>
