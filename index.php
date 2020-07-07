<?php
include_once(__DIR__ . "/inc/session.inc.php");
include_once(__DIR__ . "/classes/Transaction.php");

$getName = new User();
$userID = $_SESSION['user'];
$getName->setUserID($userID);
$name = $getName->retrieveName($userID);

$saldo = new Transaction();
$saldo->setUserID($userID);
$sum = $saldo->saldo($userID);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMDCurrency</title>
</head>

<body>
    <h1>Welcome <?php echo $name['firstname'] . " " . $name['lastname']; ?></h1>
    <h4>Your saldo is <?php echo $sum; ?></h4>
    <div>
        <input type="text" name="recipient" onKeyPress="searchResult()" id="recipient" placeholder="find a user">
    </div>
    <div>
    </div>
    <div>
        <a href="logout.php">Logout</a>
    </div>

    <script>
        function searchResult() {
            setTimeout(function() { // timeout functie zorgt ervoor dat er geen delay is tussen keypress en wat er geprint w in console
                var recipient = document.getElementById('recipient');
                var searchUser = recipient.value;

                console.log(searchUser);

                const formData = new FormData();

                formData.append('searchUser', 'searchUser');

                fetch('https://example.com/profile/avatar', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(result => {
                        console.log('Success:', result);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            })
        }
    </script>
</body>

</html>