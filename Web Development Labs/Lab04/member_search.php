<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<html>
<head>
    <meta charset="utf-8"/>
    <title>MySQL Database Functions</title>
</head>
<body>
<h1>Search Member</h1>

<form action="member_search.php" method="post">
    <p>
        <label for="lname">Enter Last Name:</label>
        <input type="text" name="lname" id="lname" required />
        <input type="submit" value="Search" />
    </p>
</form>

<?php
// Only run search AFTER form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    require_once("../../files/settings.php");

    // 1. Connect to database
    $dbconn = @mysqli_connect($host, $user, $pswd, $dbnm);

    if (!$dbconn) {
        die("<p>Connection failed: " . mysqli_connect_error() . "</p>");
    }

    // 2. Get the last name from the form
    $lname = $_POST["lname"];

    // 3. Create the query (search by last name)
    $query = "SELECT member_id, fname, lname, email 
              FROM vipmember 
              WHERE lname LIKE '%$lname%'";

    // 4. Execute the query
    $result = mysqli_query($dbconn, $query);

    if (!$result) {
        echo "<p>Something went wrong with the query.</p>";
    } else {

        // 5. Display results
        echo "<h2>Search Results</h2>";

        echo "<table border='1'>";
        echo "<tr><th>Member ID</th><th>First Name</th><th>Last Name</th><th>Email</th></tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['member_id']}</td>";
            echo "<td>{$row['fname']}</td>";
            echo "<td>{$row['lname']}</td>";
            echo "<td>{$row['email']}</td>";
            echo "</tr>";
        }

        echo "</table>";
        
    }

    mysqli_close($dbconn);
}
?>

    <p>
    <button onclick="window.location.href='vip_member.php'">
        VIP Member Page
    </button>
    </p>

</body>
</html>
