<?php
class DBController {
	private $connection;
	
	function __construct() {
		$this->connection = $this->connectDB();
	}
	
	function connectDB() {
		include('../../functions/connect.php');
		return $connection;
	}
	
	function runQuery($query) {
		$result = mysqli_query($this->connection,$query);
		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;
	}
	
	function numRows($query) {
		$result  = mysqli_query($this->connection,$query);
		$rowcount = mysqli_num_rows($result);
		return $rowcount;	
	}
}
?>