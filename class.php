<?php


session_start();

class Profile{
	function __construct(){
		if(array_key_exists('endofday', $_POST)){$this->endofday();}
       else if(array_key_exists('transaction', $_POST)){$this->transaction();}
		return;
	}

	function endofday(){
		global $connection;

		$closedby= $_POST['closedby'];

		$isactive = $_POST['isactive'];

		$isopened = $_POST['isopened'];
        
        if ($closedby==''||$isactive==''||$isopened==''){
        	$_SESSION['error']= 'A field is required';
        }
	
	    else {
		$sql =$connection->query("INSERT INTO endofday_tb (closedby,isactive,isopened) VALUES ('$closedby','$isactive','$isopened')")or die('Cannot Connect To Server');
          
          if ($sql) {
          	$_SESSION['success'] = $closedby." report submitted successfully";
          }

      }

      else if ($isopened){
      		global $connection;

		$openedby= $_POST['openedby'];

		$dateclosed = $_POST['dateclosed'];
        
        if ($openedby==''||$dateclosed==''){
        	$_SESSION['error']= 'A field is required';
        }
	
	    else {
		$sql =$connectin->query("INSERT INTO isopened_tb (openedby,dateclosed,) VALUES ('$openedby','$dateclosed')")or die('Cannot Connect To Server');

      }

         
		
		return;
	}

		function transaction(){
		global $connection;

		$id= $_POST['id'];
	
	    else {
		$sql =$connection->query("INSERT INTO endofdaytransaction_tb (id) VALUES ('$id')")or die('Cannot Connect To Server');

          
          if ($sql) {
          	$_SESSION['success'] = $closedby." report submitted successfully";
          }

      }

      else if ($isopened){
      		global $connection;

		$openedby= $_POST['openedby'];

		$dateclosed = $_POST['dateclosed'];
        
        if ($openedby==''||$dateclosed==''){
        	$_SESSION['error']= 'A field is required';
        }
	
	    else {
		$sql =$connection->query("INSERT INTO isopened_tb (openedby,dateclosed,) VALUES ('$openedby','$dateclosed')")or die('Cannot Connect To Server');

      }

         
		
		return;
	}


 
}

$tra = new Profile;
?>