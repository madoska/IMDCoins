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

    public function searchName($searchName)
    {
        $pdo = Db::connect();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE firstname LIKE :searchName OR lastname LIKE :searchName");
        $stmt->execute(['searchName' => $searchName . '%']);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
