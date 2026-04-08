<html>
    <head>
        <meta charset="utf-8"/>
        <title>MySQL Database Functions</title>
</head>
<body>
    <h1>Display All Members</h1>
    <?php
    require_once ("../../files/settings.php");

    $dbconn = @mysqli_connect($host, $user, $pswd, $dbnm);

    if(!$dbconn) {
        die("Connection failed: ". mysqli_connect_error());
    } 

        $query = "SELECT member_id, fname, lname FROM vipmember";
                  
        $result = mysqli_query($dbconn, $query);

        if(!$result) {
            echo "<p>Something is wrong with the query</p>";
        } else {
            
            echo "<table border='1'>";
            echo "<tr><th>Member ID</th><th>First Name</th><th>Last Name</th></tr>";

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>{$row['member_id']}</td>";
                echo "<td>{$row['fname']}</td>";
                echo "<td>{$row['lname']}</td>";
                echo "</tr>";
            }

            echo "</table>";
            
        }
    mysqli_close($dbconn);
    
?>

    <p>
    <button onclick="window.location.href='vip_member.php'">
        VIP Member Page
    </button>
    </p>

</body>
</html>