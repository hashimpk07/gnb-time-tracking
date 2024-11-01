<?php
class Weeks{
    private $conn;
	private $table;

	public function __construct(){
		$db = new DataSource();
		$this->conn = $db->getConnection();
		$this->table = "weeks";
	}
	public function getAll(){
		return $this->conn->query("SELECT * from $this->table");
	}
	
	public function save($name,$fromDate,$toDate){
		$this->conn->query("INSERT into $this->table (`name` ,`from_date`,`to_date`) VALUES('$name','$fromDate','$toDate')");
	}

	public function getOne($id){
		return $this->conn->query("SELECT * from $this->table WHERE id='$id'");
	}
	
	public function update($id, $name,$fromDate,$toDate){
		$this->conn->query("UPDATE $this->table SET name='$name',from_date='$fromDate',to_date='$toDate' WHERE id='$id'");
	}

	public function delete($id){
		$this->conn->query("DELETE from $this->table WHERE id = '$id'");
	}
}
?>