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
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>IMDCurrency</title>
</head>

<body>
    <h1>Welcome <?php echo $name['firstname'] . " " . $name['lastname']; ?></h1>
    <h4>Your saldo is <?php echo $sum; ?></h4>
    <div>
        <form action="ajax/searchName.php" method="POST">
            <input type="text" name="recipient" oninput=searchName(this.value) id="recipient" placeholder="find a user">
        </form>
    </div>
    <div>
        Results found:
        <div>
            <ul id="results"></ul>
        </div>
    </div>
    <div>
        <a href="logout.php">Logout</a>
    </div>

    <script>
        function searchName(searchName) {
            console.log(searchName);

            fetchSearchName(searchName);
        }

        function fetchSearchName(searchName) {
            fetch('ajax/searchUser.php', {
                    method: 'POST',
                    body: new URLSearchParams('searchName=' + searchName)
                })
                .then(result => result.json())
                .then(result => viewResults(result))
                .catch(error => console.error('Error: ' + error))
        }

        function viewResults(result) {
            const results = document.getElementById("results");
            results.innerHTML = "";

            for (let i = 0; i < result.length; i++) {
                let href = "transaction.php?id=" + result[i].userID;
                let name = result[i].firstname + " " + result[i].lastname;

                link = document.createElement('a');
                link.innerHTML = name;
                link.setAttribute('title', name);
                link.setAttribute('href', href);
                results.appendChild(link);
            }
        }
    </script>
</body>

</html>