<!DOCTYPE html>
    <html>
        <head>
            <title> Client Side </title>
</head>
<body>
    <h1> POST METHOD EXERCISE </h1>

    <?php
    if(isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];   

        echo "<p>You have succesfully registered from us.</p>";
    } else {
        echo "<p>No data input found!</p>";
    }
    

    ?>
</body>
</html>