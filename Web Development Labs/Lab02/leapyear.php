<?php

function is_leap_year($year) {      
    if ($year % 4 != 0) {
        return false;
    } elseif ($year % 100 != 0) {
        return true;
    } elseif ($year % 400 != 0) {
        return false;
    } else {
        return true;
    }
}     

if(isset($_POST['year'])) {
    $year = intval($_POST['year']);
    if (is_leap_year($year)) {
        echo "The year you entered $year is a leap year.";
    } else {
        echo "The year you entered $year is a standard year.";
    }
}

?>