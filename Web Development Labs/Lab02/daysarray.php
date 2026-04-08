<html>
<head></head>
<body>
<h1>Task 1: Arrays</h1>
<?php
$days_english = array("Sunday", 
                       "Monday", 
                       "Tuesday", 
                       "Wednesday", 
                       "Thursday", 
                       "Friday", 
                       "Saturday");
$days_french = array("Dimanche",
                      "Lundi",
                      "Mardi",
                      "Mercredi",
                      "Jeudi",
                      "Vendredi",
                      "Samedi");
?>
<?php echo "<p>The Days of the week in English are:\n"; 
      echo "<p>$days_english[0], $days_english[1], $days_english[2], $days_english[3], $days_english[4], $days_english[5], $days_english[6].</p>";?>

<?php echo "<p>The Days of the week in French are:\n"; 
      echo "<p>$days_french[0], $days_french[1], $days_french[2], $days_french[3], $days_french[4], $days_french[5], $days_french[6].</p>";?>
</body>
</html>