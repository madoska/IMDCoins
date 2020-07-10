<?php
include_once(__DIR__ . "/classes/Db.php");
include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/Transaction.php");
session_start();
session_destroy();

// if register form is submitted and not empty
if (!empty($_POST['register'])) {
    // check if email is filled out
    if (!empty($_POST['email'])) {
        // check for thomas more email
        $verifyEmail = new User();
        $email = $_POST['email'];
        $verifyEmail->setEmail($email);
        $resultEmail = $verifyEmail->validateEmail($email);

        // if thomas more email = ok
        if ($resultEmail == 1) {
            // check if email is not taken
            $emailAvailable = new User();
            $emailAvailable->setEmail($email);
            $available = $emailAvailable->emailAvailable($email);
            if ($available == 1) {
                // check if password and verifypassword are the same
                if (!empty($_POST['password']) && $_POST['password'] === $_POST['confirmPassword']) {
                    //check if password length is ok
                    $verifyPassword = new User();
                    $password = $_POST['password'];
                    $verifyPassword->setPassword($password);
                    $resultPassword = $verifyPassword->validatePassword($password);

                    if ($resultPassword == 1) {
                        // register the user
                        $user = new User();
                        $firstname = $_POST['firstname'];
                        $lastname = $_POST['lastname'];
                        $email = $_POST['email'];
                        $password = $_POST['password'];
                        $user->setFirstname($firstname);
                        $user->setLastname($lastname);
                        $user->setEmail($email);
                        $user->setPassword($password);
                        $register = $user->register($email, $password, $firstname, $lastname);

                        // start a session for the currently logged in user
                        session_start();
                        $userID = $user->userID($email);
                        $_SESSION['user'] = $userID;
                        $tokens = new Transaction();
                        $tokens->setUserID($userID);
                        $activationTokens = $tokens->activationTokens($userID);
                        echo "Tokens sent.";
                        header("Location: index.php");
                    } else {
                        echo "Password too short.";
                    }
                } else {
                    echo "Password doesn't match.";
                }
            } else {
                echo "Email taken.";
            }
        } else {
            echo "Only Thomas More emails please.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="css/register.css">
    <title>Register</title>
</head>

<body>
    <div class="d-md-flex h-md-100 align-items-center">
        <div class="col-md-6 p-0 h-md-100 brandingarea">
            <div class="text-white d-md-flex align-items-center h-100 p-5 text-center justify-content-center">
                <img class="logo" src="images/logo_white.svg" alt="">
            </div>
        </div>

        <div class="col-md-6 p-0 bg-white h-md-100 signuparea">
            <div class="d-md-flex align-items-center h-md-100 p-5 justify-content-center">
                <div class="flex-box">
                    <h1 class="title">Register</h1>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="flex">
                            <input type="text" name="firstname" id="firstname" placeholder="First name">
                        </div>

                        <div class="flex">
                            <input type="text" name="lastname" id="lastname" placeholder="Last name">
                        </div class="flex">

                        <div class="flex">
                            <input type="text" name="email" id="email" placeholder="Email">
                        </div>

                        <div class="flex">
                            <input type="password" name="password" id="password" placeholder="Password">
                        </div>

                        <div class="flex">
                            <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm password">
                        </div>

                        <div class="flex">
                            <input type="submit" class="shadow cta" value="Sign up" name="register" id="register">
                        </div>

                        <div class="flex-tiny">
                            <p class="tiny">Have an account?</p><a href="login.php" class="login">Sign in</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>