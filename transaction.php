<?php
include_once(__DIR__ . "/inc/session.inc.php");
include_once(__DIR__ . "/classes/Transaction.php");

if(isset($_GET['id'])){
    $recipientID = $_GET['id'];
    $recipient = new Transaction();
    $result = $recipient->searchRecipient($recipientID);

    print_r($result);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make a transaction</title>
</head>
<body>
    <h1>Send tokens to <?php echo $result['firstname']; ?></h1>
</body>
</html>