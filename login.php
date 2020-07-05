<?php
include_once(__DIR__ . "/classes/Db.php");
include_once(__DIR__ . "/classes/User.php");

if(!empty($_POST['login'])){
    $validateLogin = new User();
    $email = $_POST['email'];
    $password = $_POST['password'];
    $validateLogin->setEmail($email);
    $validateLogin->setPassword($password);
    $result = $validateLogin->validateLogin($email, $password);

    if($result == 1){
        session_start();
        $userID = $validateLogin->userID($email);
        $_SESSION['user'] = $userID;
        header("Location: index.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div>
            <label for="email">Email</label>
            <input type="text" name="email" id="email">
        </div>

        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
        </div>

        <div>
            <input type="submit" value="Sign in" name="login" id="login">
        </div>
    </form>
</body>

</html>