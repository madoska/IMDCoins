<?php
include_once(__DIR__."/../classes/Transaction.php");

$userID = $_POST['userID'];
$history = new Transaction();
$results = $history->history($userID);

echo json_encode($results);