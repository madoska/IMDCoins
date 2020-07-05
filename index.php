<?php
include_once(__DIR__ . "/inc/session.inc.php");

$getName = new User();
$userID = $_SESSION['user'];
$getName->setUserID($userID);
$name = $getName->retrieveName($userID);
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
    <div>
    <a href="logout.php">Logout</a></div>
</body>

</html>