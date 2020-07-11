<?php
include_once(__DIR__ . "/Db.php");

class Transaction
{
    private $userID;
    private $sum;
    private $msg;
    private $recipient;
    private $searchName;

    public function activationTokens($userID)
    {
        $pdo = Db::connect();
        $stmt = $pdo->prepare("INSERT INTO transactions (senderID, recipientID, amount, message) VALUES (1, :recipientID, 10, 'A little token of gratitude for joining us! :)')");
        $stmt->bindParam(':recipientID', $userID);
        $result = $stmt->execute();
        return $result;
    }

    public function saldo($userID)
    {
        $pdo = Db::connect();
        $stmt = $pdo->prepare("SELECT SUM(amount) FROM transactions WHERE recipientID = :recipientID");
        $stmt->bindParam(':recipientID', $userID);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        return $result;
    }

    public function allUsers($userID)
    {
        $pdo = Db::connect();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE userID != :userID");
        $stmt->bindParam(':userID', $userID);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function searchName($searchName)
    {
        $pdo = Db::connect();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE firstname LIKE :searchName OR lastname LIKE :searchName");
        $stmt->execute(['searchName' => $searchName . '%']);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function searchRecipient($recipient)
    {
        $pdo = Db::connect();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE userID = :userID");
        $stmt->bindParam(':userID', $recipient);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function history($userID)
    {
        $pdo = Db::connect();
        // use aliases to join user table multiple times
        $stmt = $pdo->prepare("SELECT transactions.*, sender.firstname AS sender_firstname, sender.lastname AS sender_lastname, recipient.firstname AS recipient_firstname, recipient.lastname AS recipient_lastname FROM transactions INNER JOIN users as sender ON transactions.senderID = sender.userID INNER JOIN users as recipient ON transactions.recipientID = recipient.userID WHERE senderID = :userID OR recipientID = :userID ORDER BY transID DESC");
        $stmt->bindParam(':userID', $userID);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function makeTransfer($userID, $recipient, $sum, $msg)
    {
        $pdo = Db::connect();
        $stmt = $pdo->prepare("INSERT INTO transactions (senderID, recipientID, amount, message) VALUES (:senderID, :recipientID, :amount, :message)");
        $stmt->bindParam(':senderID', $userID);
        $stmt->bindParam(':recipientID', $recipient);
        $stmt->bindParam(':amount', $sum);
        $stmt->bindParam(':message', $msg);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
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

    public function getSum()
    {
        return $this->sum;
    }

    public function setSum($sum)
    {
        $this->sum = $sum;

        return $this;
    }

    public function getMsg()
    {
        return $this->msg;
    }

    public function setMsg($msg)
    {
        $this->msg = $msg;

        return $this;
    }

    public function getRecipient()
    {
        return $this->recipient;
    }

    public function setRecipient($recipient)
    {
        $this->recipient = $recipient;

        return $this;
    }

    public function getsearchName()
    {
        return $this->searchName;
    }

    public function setsearchName($searchName)
    {
        $this->searchName = $searchName;

        return $this;
    }
}
