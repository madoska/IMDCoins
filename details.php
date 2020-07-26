<?php
include_once(__DIR__ . "/inc/session.inc.php");
include_once(__DIR__ . "/classes/Transaction.php");

$transID = $_GET['id'];

$history = new Transaction();
$history->setUserID($userID);
$transactions = $history->history($userID);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="d-md-flex h-md-100">
        <div class="col-md-8 p-0 h-md-100">
            <div class="text-black h-100 p-5">
                <div class="rows">
                    <h1><a href="index.php" class="return">< Receipt</a></h1>
                </div>
                <div class="columns">
                    <ul class="labels">
                        <li class="label">Transaction date</li>
                        <li class="label">Sender</li>
                        <li class="label">Recipient</li>
                        <li class="label">Amount</li>
                        <li class="label">Message</li>
                    </ul>
                    <ul class="variables">
                        <?php foreach ($transactions as $trans) : ?>
                            <?php if ($trans['transID'] == $transID) { ?>
                                <li class="var"><?php echo $trans['time']; ?></li>
                                <li class="var"><?php echo $trans['sender_firstname'] . " " . $trans['sender_lastname']; ?></li>
                                <li class="var"><?php echo $trans['recipient_firstname'] . " " . $trans['recipient_lastname']; ?></li>
                                <li class="var"><?php echo $trans['amount'] . " tokens"; ?></li>
                                <li class="var"><?php echo $trans['message']; ?></li>
                        <?php }
                        endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-4 p-0 bg-white h-md-100">
            <div class="h-md-100 p-5 brandingarea">
                <h2 class="history">History</h2>
                <input type="hidden" id="hidden" name="hidden" value="<?php echo $userID; ?>">
                <ul id="listitems" class="listitems">
                    <?php
                    foreach ($transactions as $trans) : ?>
                        <?php
                        if ($trans['recipientID'] == $userID) { ?>
                            <li class="transItems"><a class="transLink <?php if ($transID == $trans['transID']) {echo "selected";} else {}; ?>" href="details.php?id=<?php echo $trans['transID']; ?>"><?php echo  $trans['sender_firstname'] . " sent you " . $trans['amount'] . " tokens"; ?></a></li>
                        <?php } else { ?>
                            <li class="transItems"><a class="transLink <?php if ($transID == $trans['transID']) {echo "selected";} else {}; ?>" href="details.php?id=<?php echo $trans['transID']; ?>"><?php echo "You sent " . $trans['recipient_firstname'] . " " . $trans['amount'] . " tokens"; ?></a></li>
                        <?php }

                        if($transID == $trans['transID']){
                            echo '<input type="hidden" id="transHidden" name="hidden" value ="' . $trans['transID'] . '">';
                        } else {}   
                    endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <script>
        window.onload = timer;

        function timer(){
            setInterval(() => {
                updateHistory()
            }, 3000);
        }
        
        const userID = document.getElementById("hidden").value;
        console.log(userID);

        const transID = document.getElementById("transHidden").value;
        console.log(transID);

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