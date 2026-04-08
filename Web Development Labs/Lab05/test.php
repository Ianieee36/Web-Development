<?php

session_start();

$newitem = isset($_GET["book"]) ? $_GET["book"] : "";
$action = isset($_GET["action"]) ? $_GET["action"] : "";

if(!isset($_SESSION["Cart"])) {
    $_SESSION["Cart"] = [];
}

$cart = $_SESSION["Cart"];

if($action == "Add") {
    if(isset($cart[$newitem])) {
        $cart[$newitem] += 1;
    } else {
        $cart[$newitem] = 1;
    }
}
else if ($action == "Remove") {
    unset($cart[$newitem]);
}

$_SESSION["Cart"] = $cart;

echo json_encode($cart);

		// echo json_encode($cart, JSON_PRETTY_PRINT);
		
?>
