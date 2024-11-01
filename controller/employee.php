<?php
require_once __DIR__ . '/../lib/DataSource.php';
require_once "../model/employee.php";

$mode = $_REQUEST['mode'];

$objEmp = new Employee();

if($mode=="insert"){
	$name  = $_REQUEST['name'];
    $teams = $_REQUEST['teams_id'];
	$objEmp->save($name,$teams);

}else if($mode=="load"){
	$i=1;
	$result = "";
	$employee = $objEmp->getAll();
	while($row = $employee->fetch_assoc()){ 
	$result.="<tr>";
		$result.="<td>".$i++."</td>";
		$result.="<td>".$row["name"]."</td>";
        $result.="<td>".$row["teamName"]."</td>";
		$result.="<td><a class='edit' href='#' data-id='".$row["id"]."'>Edit</a> | <a class='delete' href='#' data-id='".$row["id"]."'>Delete</a></td>";
	$result.="</tr>";
	};
	echo $result;
}else if($mode=="loadOne"){
	$id = $_REQUEST['id'];
	$result = $objEmp->getOne($id)->fetch_assoc();
	echo json_encode($result);
}else if($mode=="update"){
	$employee = $_REQUEST['name'];
	$id = $_REQUEST['id'];
    $teams = $_REQUEST['teams_id'];
	$objEmp->update($id, $employee,$teams);
}else if($mode=="delete"){
	$id = $_REQUEST['id'];
	$objEmp->delete($id);
}
?>