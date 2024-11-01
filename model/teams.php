<?php
class Teams{
    private $conn;
	private $table;

	public function __construct(){
		$db = new DataSource();
		$this->conn = $db->getConnection();
		$this->table = "teams";
	}
	public function getAll(){
		return $this->conn->query("SELECT * from $this->table");
	}
	
	public function save($name){
		$this->conn->query("INSERT into $this->table (`name`) VALUES('$name')");
	}

	public function getOne($id){
		return $this->conn->query("SELECT * from $this->table WHERE id='$id'");
	}
	
	public function update($id, $name){
		$this->conn->query("UPDATE $this->table SET name='$name' WHERE id='$id'");
	}

	public function delete($id){
		$this->conn->query("DELETE from $this->table WHERE id = '$id'");
	}
}
?>