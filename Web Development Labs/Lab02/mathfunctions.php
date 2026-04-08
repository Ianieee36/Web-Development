<?php
    function factorial($number) {
        $result = 1;
        $factor = $number;
        while($factor > 1) {
            $result *= $factor;
            $factor--;
        }
        return $result;
    }
 

?>
