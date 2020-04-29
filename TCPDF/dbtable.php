<?php

    class Book 
    {
        protected  $id;
        protected  $int_id;
        protected  $transaction_date;
        protected  $client_id;
        protected  $amount;
        protected  $transaction_type;
        protected  $transaction_id;
        private $tableName = 'account_transaction';
        protected $dbconn;

        function setId($id) { $this -> id = $id; }
        function getId(){  return $this -> id; }
        function setIntId($int_id) { $this -> int_id = $int_id; }
        function getIntId(){  return $this -> int_id; }
        function setTransactionD($transaction_date) { $this -> transaction_date = $transaction_date; }
        function getTransactionD(){  return $this -> transaction_date; }
        function setClient($client_id) { $this -> client_id = $client_id; }
        function getClient(){  return $this -> client_id; }
        function setAmount($amount) { $this -> amount = $amount; }
        function getAmount(){  return $this -> amount; }
        function setTransactionT($transaction_type) { $this -> transaction_type = $transaction_type; }
        function getTransactionT(){  return $this -> transaction_type; }
        function setTransactionI($transaction_id) { $this -> transaction_id = $transaction_id; }
        function getTransactionI(){  return $this -> transaction_id; }

   
    public function __construct() {
        require_once('DBconnect.php');
        $db = new DBconnect();
        $this ->dbconn = $db ->connect();
    }
    public function gettransaction() {
        if(isset($_GET["echa"])) {
            $id = $_GET["echa"];}
        $stmt = $this->dbconn->prepare("SELECT * FROM account_transaction");
        $stmt -> execute();
        $books = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        return $books;
    }
}
?>