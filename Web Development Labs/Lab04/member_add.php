
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>MySQL Database Functions</title>
</head>
<body>
    <h1>Added Member</h1>

    <?php
    require_once ("../../files/settings.php");

    $dbconn = @mysqli_connect($host, $user, $pswd, $dbnm);

    if(!$dbconn) {
        die("Connection failed: ". mysqli_connect_error());
    } else {

        $fname = $_POST["fname"];
        $lname= $_POST["lname"];
        $gender = $_POST["gender"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];

        $query = "INSERT INTO vipmember (fname, lname, gender, email, phone)
                  VALUES ('$fname','$lname','$gender','$email','$phone')";
                  
        $result = mysqli_query($dbconn, $query);

        if($result) {
            echo "<p>Member added successfully!</p>";
            echo "<p>You are a member now</p>";
        echo "<p>$fname $lname ($gender)</p>";
        echo "<p>Email: $email</p>";
        echo "<p>Phone: $phone</p>";
        } else {
            echo "<p>Error adding member: " . mysqli_error($dbconn) . "</p>";
            
        }
        
    
    }
?>

    <p>
    <button onclick="window.location.href='vip_member.php'">
        VIP Member Page
    </button>
    </p>

</body>
</html>