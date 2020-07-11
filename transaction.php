<?php
include_once(__DIR__ . "/inc/session.inc.php");
include_once(__DIR__ . "/classes/Transaction.php");

if (isset($_GET['id'])) {
    $recipientID = $_GET['id'];
    $recipient = new Transaction();
    $result = $recipient->searchRecipient($recipientID);
}

$history = new Transaction();
$history->setUserID($userID);
$transactions = $history->history($userID);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make a transaction</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="d-md-flex h-md-100">
        <div class="col-md-8 p-0 h-md-100">
            <div class="text-black h-100 p-5">
                <div class="rows">
                    <h1><a href="index.php" class="return">< Transaction</a></h1>
                    <div class="columns">
                        <form action="" method="post" class="transaction-form">
                            <div><input type="number" name="amount" id="amount" placeholder="Choose an amount"></div>
                            <div><textarea name="message" id="message" placeholder="Let them know you appreciate them :)" cols="48" rows="10"></textarea></div>
                            <div><input type="submit" value="Submit" class="cta shadow"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 p-0 bg-white h-md-100">
            <div class="h-md-100 p-5 brandingarea">
                <h2 class="history">History</h2>
                <ul class="listitems">
                    <?php
                    foreach ($transactions as $trans) : ?>
                        <?php
                        if ($trans['recipientID'] == $userID) { ?>
                            <li class="transItems"><a class="transLink <?php if ($transID == $trans['transID']) {
                                                                            echo "selected";
                                                                        } else {
                                                                        }; ?>" href="details.php?id=<?php echo $trans['transID']; ?>"><?php echo  $trans['sender_firstname'] . " sent you " . $trans['amount'] . " tokens"; ?></a><a class="transMore <?php if ($transID == $trans['transID']) {
                                                                                                                                                                                                                                                            echo "selected";
                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                        }; ?>" href="details.php?id=<?php echo $trans['transID']; ?>">></a></li>
                        <?php } else { ?>
                            <li class="transItems"><a class="transLink <?php if ($transID == $trans['transID']) {
                                                                            echo "selected";
                                                                        } else {
                                                                        }; ?>" href="details.php?id=<?php echo $trans['transID']; ?>"><?php echo "You sent " . $trans['recipient_firstname'] . " " . $trans['amount'] . " tokens"; ?></a><a class="transMore <?php if ($transID == $trans['transID']) {
                                                                                                                                                                                                                                                                    echo "selected";
                                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                                }; ?>" href="details.php?id=<?php echo $trans['transID']; ?>">></a></li>
                        <?php } ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</body>

</html>