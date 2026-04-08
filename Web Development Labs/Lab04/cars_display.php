<html>
    <head>
        <meta charset="utf-8"/>
        <title>MySQL Database Functions</title>
</head>
<body>
    <h1>Web Development - Lab05</h1>
    <?php
    require_once ("../../files/settings.php");

    $dbconn = @mysqli_connect($host, $user, $pswd, $dbnm);

    if(!$dbconn) {
        die("Connection failed: ". mysqli_connect_error());
    } else {

        $query = "SELECT car_id, make, model, price FROM cars";

        $result = mysqli_query($dbconn, $query);

    if(!$result) {
        echo "<p>Something went wrong with the query.</p>";
    } else {

        echo "<table border = '1'>";
        echo "<tr><th>Car ID</th><th>Make</th><th>Model</th><th>Price</th></tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['car_id']}</td>";
            echo "<td>{$row['make']}</td>";
            echo "<td>{$row['model']}</td>";
            echo "<td>{$row['price']}</td>";
            echo "</tr>";
            
        }

        echo "</table>";
    }

    mysqli_close($conn);
}
?>

</body>
</html>