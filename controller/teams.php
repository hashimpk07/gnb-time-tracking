<?php
require_once __DIR__ . '/../lib/DataSource.php';
require_once "../model/teams.php";

$mode = $_REQUEST['mode'];

$objTeams = new Teams();

if($mode=="insert"){
	$name = $_REQUEST['name'];
	$objTeams->save($name);

}else if($mode=="load"){
	$i=1;
	$result = "";
	$teams = $objTeams->getAll();
	while($row = $teams->fetch_assoc()){ 
	$result.="<tr>";
		$result.="<td>".$i++."</td>";
		$result.="<td>".$row["name"]."</td>";
		$result.="<td><a class='edit' href='#' data-id='".$row["id"]."'>Edit</a> | <a class='delete' href='#' data-id='".$row["id"]."'>Delete</a></td>";
	$result.="</tr>";
	};
	echo $result;
}else if($mode=="loadOne"){
	$id = $_REQUEST['id'];
	$result = $objTeams->getOne($id)->fetch_assoc();
	echo json_encode($result);
}else if($mode=="update"){
	$name = $_REQUEST['name'];
	$id = $_REQUEST['id'];
	$objTeams->update($id, $name);
}else if($mode=="delete"){
	$id = $_REQUEST['id'];
	$objTeams->delete($id);
}
?>