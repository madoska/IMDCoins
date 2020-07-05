<?php
include_once(__DIR__ . "/classes/Db.php");
include_once(__DIR__ . "/classes/User.php");

// if register form is submitted and not empty
if (!empty($_POST['register'])) {
    // check if email is filled out
    if (!empty($_POST['email'])) {
        // check if password is filled out
            $verifyEmail = new User();
            $email = $_POST['email'];
            $verifyEmail->setEmail($email);
            $verify = $verifyEmail->validateEmail($email);

            if($verify == 1){
                echo "oK";
            } else {
                echo "nope";
            }

        /*if (!empty($_POST['password']) && $_POST['password'] === $_POST['confirmPassword']) {
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
        } else {
            echo "Password too short.";
        }*/
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>

<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div>
            <label for="firstname">First name</label>
            <input type="text" name="firstname" id="firstname">
        </div>

        <div>
            <label for="lastname">Last name</label>
            <input type="text" name="lastname" id="lastname">
        </div>

        <div>
            <label for="email">Email</label>
            <input type="text" name="email" id="email">
        </div>

        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
        </div>

        <div>
            <label for="confirmPassword">Confirm password</label>
            <input type="password" name="confirmPassword" id="confirmPassword">
        </div>

        <div>
            <input type="submit" value="Sign up" name="register" id="register">
        </div>
    </form>
</body>

</html>