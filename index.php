<?php
include_once(__DIR__ . "/inc/session.inc.php");
include_once(__DIR__ . "/classes/Transaction.php");

$getName = new User();
$getName->setUserID($userID);
$name = $getName->retrieveName($userID);

$saldo = new Transaction();
$saldo->setUserID($userID);
$sum = $saldo->saldo($userID);

$sums = new Transaction();
$sums->setUserID($userID);
$gains = $sums->gains($userID);
$losses = $sums->losses($userID);

$allUsers = new Transaction();
$allUsers->setUserID($userID);
$users = $allUsers->allUsers($userID);

$history = new Transaction();
$history->setUserID($userID);
$transactions = $history->history($userID);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <title>Coins</title>
</head>

<body>
    <div class="d-md-flex h-md-100">
        <div class="col-md-8 p-0 h-md-100">
            <div class="text-black h-100 p-5">
                <div class="header">
                    <h1>Hi, <?php echo $name['firstname']; ?>!</h1>
                    <button type="button" class="btn btn-default btn-sm"><a class="logout-btn" href="logout.php"> Log out</a></button>
                </div>
                <h4 id="saldo">Your saldo is <?php echo $gains - $losses; ?> tokens</h4>
                <input type="hidden" id="hidden" name="hidden" value="<?php echo $userID; ?>">
                <div>
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <input type="text" class="search" name="recipient" oninput=searchName(this.value) id="recipient" placeholder="Search user">
                    </form>
                </div>
                <div>
                    <div>
                        <ul id="results" class="listitems">
                            <?php foreach ($users as $user) : ?>
                                <li><a href="transaction.php?id=<?php echo $user['userID']; ?>"><?php echo $user['firstname'] . " " . $user['lastname']; ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 p-0 bg-white h-md-100">
            <div class="h-md-100 p-5 brandingarea">
                <h2 class="history">History</h2>
                <ul class="listitems" id="listitems">
                    <?php
                    foreach ($transactions as $trans) : ?>
                        <?php
                        if ($trans['recipientID'] == $userID) { ?>
                            <li class="transItems"><a class="transLink" href="details.php?id=<?php echo $trans['transID']; ?>"><?php echo  $trans['sender_firstname'] . " sent you " . $trans['amount'] . " tokens"; ?></a></li>
                        <?php } else { ?>
                            <li class="transItems"><a class="transLink" href="details.php?id=<?php echo $trans['transID']; ?>"><?php echo "You sent " . $trans['recipient_firstname'] . " " . $trans['amount'] . " tokens"; ?></a></li>
                        <?php } ?>
                    <?php endforeach; ?>
                </ul>
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
                let a = document.createElement("a");
                let li = document.createElement("li");
                let href = "transaction.php?id=" + result[i].userID;
                let name = result[i].firstname + " " + result[i].lastname;

                a.textContent = name;
                a.setAttribute('href', href);
                li.appendChild(a);
                results.appendChild(li);
            }
        }

        const saldo = document.getElementById('saldo');

        window.onload = timer;

        function timer() {
            setInterval(() => {
                update()
            }, 3000);

            setInterval(() => {
                updateHistory()
            }, 3000);
        }

        const userID = document.getElementById("hidden").value;
        console.log(userID);

        function update() {
            let formData = new FormData();
            formData.append('userID', userID);

            fetch('ajax/updateSaldo.php', {
                    method: 'POST',
                    body: formData
                })

                .then(response => response.json())
                .then(result => {
                    console.log(result);
                    saldo.innerHTML = "Your saldo is " + result + " tokens"
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function updateHistory() {
            let formData = new FormData();
            formData.append('userID', userID);

            fetch('ajax/fetchHistory.php', {
                    method: 'POST',
                    body: formData
                })

                .then(response => response.json())
                .then(result => viewHistory(result))
                .catch(error => {
                    console.log('Error: ', error);
                });
        }

        function viewHistory(result) {
            const history = document.getElementById("listitems");
            history.innerHTML = "";

            for (let i = 0; i < result.length; i++) {
                if (result[i].senderID == userID) {
                    let a = document.createElement("a");
                    let li = document.createElement("li");
                    let href = "details.php?id=" + result[i].transID;
                    let title = "You sent " + result[i].recipient_firstname + " " + result[i].amount + " tokens.";

                    li.classList.add("transItems");
                    a.classList.add("transLink");

                    a.textContent = title;
                    a.setAttribute('href', href);
                    li.appendChild(a);
                    history.appendChild(li);

                    console.log("history items updated");
                } else {
                    let a = document.createElement("a");
                    let li = document.createElement("li");
                    let href = "details.php?id=" + result[i].transID;
                    let title = result[i].sender_firstname + " sent you " + result[i].amount + " tokens.";

                    li.classList.add("transItems");
                    a.classList.add("transLink");

                    a.textContent = title;
                    a.setAttribute('href', href);
                    li.appendChild(a);
                    history.appendChild(li);

                    console.log("history items updated");
                }
            }
        }
    </script>
</body>

</html>