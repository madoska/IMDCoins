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
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <title>IMDCurrency</title>
</head>

<body>
    <div class="d-md-flex h-md-100">
        <div class="col-md-8 p-0 h-md-100">
            <div class="text-black h-100 p-5">
                <h1>Hi, <?php echo $name['firstname']; ?>!</h1>
                <h4>Your saldo is <?php echo $sum; ?> tokens</h4>
                <div>
                    <form action="ajax/searchName.php" method="POST">
                        <input type="text" name="recipient" oninput=searchName(this.value) id="recipient" placeholder="Search user">
                    </form>
                </div>
                <div>
                    Results found:
                    <div>
                        <ul id="results"></ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 p-0 bg-white h-md-100">
            <div class="d-md-flex h-md-100 p-5 brandingarea">
                <h2 class="history">History</h2>
                <div>
                </div>
            </div>
        </div>
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