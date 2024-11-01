<?php
class Employee{
    private $conn;
	private $table;

	public function __construct(){
		$db = new DataSource();
		$this->conn = $db->getConnection();
		$this->table = "employee";
	}
	public function getAll(){
		return $this->conn->query("SELECT employee.name as name,employee.id as id,employee.teams_id as teams_id ,teams.name as teamName from $this->table Left JOIN teams on $this->table.teams_id=teams.id");
	}
	
	public function save($name,$teamsId){
		$this->conn->query("INSERT into $this->table (`name`,`teams_id`) VALUES('$name' ,'$teamsId')");
	}

	public function getOne($id){
		return $this->conn->query("SELECT * from $this->table WHERE id='$id'");
	}
	
	public function update($id, $name,$teamsId){
		$this->conn->query("UPDATE $this->table SET name='$name',teams_id='$teamsId' WHERE id='$id'");
	}

	public function delete($id){
		$this->conn->query("DELETE from $this->table WHERE id = '$id'");
	}
}
?>