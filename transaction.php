<?php
include_once(__DIR__ . "/inc/session.inc.php");
include_once(__DIR__ . "/classes/Transaction.php");

if (isset($_GET['id'])) {
    $recipientID = $_GET['id'];
    $recipient = new Transaction();
    $result = $recipient->searchRecipient($recipientID);
}

$sums = new Transaction();
$sums->setUserID($userID);
$gains = $sums->gains($userID);
$losses = $sums->losses($userID);
$saldo = $gains-$losses;

$history = new Transaction();
$history->setUserID($userID);
$transactions = $history->history($userID);

$alert = 0;

if(!empty($_POST['submit'])){
    $newTransaction = new Transaction();
    $amount = $_POST['amount'];
    $message = $_POST['message'];
    
    if($saldo < $amount){
        $alert = 1;
    } else if ($amount < 1){
        $alert = 2;
    } else {
        $transaction = $newTransaction->makeTransfer($userID, $recipientID, $amount, $message);
        $alert = 3;
    }
}
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
                    <h1><a href="index.php" class="return">< Transaction</a> </h1>
                    <h4 id="saldo">Your saldo is <?php echo $gains-$losses; ?> tokens</h4>
                    <input type="hidden" id="hidden" name="hidden" value="<?php echo $userID; ?>">
                        <div class="columns">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="transaction-form">
                                <div><div class='alert alert-danger' <?php if($alert != 1){ echo "style='display:none'"; } else {} ?>><strong>Error!</strong> You don't have enough tokens to complete this transfer 😔</div></div>
                                <div class=""><div class='alert alert-danger' <?php if($alert != 2){ echo "style='display:none'"; } else {} ?>><strong>Error!</strong> Amount too low; must be at least 1 token.</div></div>
                                <div><div class='alert alert-success' <?php if($alert != 3){ echo "style='display:none'"; } else {} ?>><strong>Success!</strong> Transfer complete 🤑</div></div>
                                <div><input type="number" name="amount" id="amount" placeholder="Choose an amount"></div>
                                <div><textarea name="message" id="message" placeholder="Let them know you appreciate them :)" cols="48" rows="10"></textarea></div>
                                <div><input type="submit" value="Submit" class="cta shadow" id="submit" name="submit"></div>
                            </form>
                        </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 p-0 bg-white h-md-100">
            <div class="h-md-100 p-5 brandingarea">
                <h2 class="history">History</h2>
                <ul id="listitems">
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
        const saldo = document.getElementById('saldo');

        window.onload = timer;

        function timer(){
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

        function updateHistory(){
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

        function viewHistory(result){
            const history = document.getElementById("listitems");
            history.innerHTML = "";

            for(let i = 0; i < result.length; i++){
                if(result[i].senderID == userID){
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