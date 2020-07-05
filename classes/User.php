<?php
include_once(__DIR__ . "/Db.php");

class User
{
    private $userID;
    private $email;
    private $password;
    private $firstname;
    private $lastname;

    public function register($email, $password, $firstname, $lastname)
    {
        $pdo = Db::connect();
        $stmt = $pdo->prepare("INSERT INTO users (firstname, lastname, email, password) VALUES (:firstname, :lastname, :email, :password)");
        $password = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $result = $stmt->execute();
        return $result;
    }

    public function validateEmail($email)
    {
        // Remove all illegal characters from email
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        // Validate e-mail + check for Thomas More email address
        if (filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('|@student.thomasmore.be$|', $email)) {
            return true;
        } else {
            echo false;
        }
    }

    public function retrieveName($userID){
        $pdo = Db::connect();
        $stmt = $pdo->prepare("SELECT firstname, lastname FROM users WHERE userID = :userID");
        $stmt->bindParam(':userID', $userID);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function userID($email){
        $pdo = Db::connect();
        $stmt = $pdo->prepare("SELECT userID FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        return $result;
    }

    public function emailAvailable($email){
        $pdo = Db::connect();
        $stmt = $pdo->prepare("SELECT COUNT(userID) FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = implode($result);

        if($count > 0){
            return false;
        } else {
            return true;
        }
    }

    public function validatePassword($password){
        $length = strlen($password);

        if($length < 5){
            return false;
        } else {
            return true;
        }
    }

    public function getUserID()
    {
        return $this->userID;
    }

    public function setUserID($userID)
    {
        $this->userID = $userID;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }
}
