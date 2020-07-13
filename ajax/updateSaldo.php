<?php
include_once(__DIR__."/../classes/Transaction.php");
include_once(__DIR__."/../inc/session.inc.php");

$userID = $_POST['userID'];
$update = new Transaction();
$gains = $update->gains($userID);
$losses = $update->losses($userID);

$results = $gains-$losses;

echo json_encode($results);