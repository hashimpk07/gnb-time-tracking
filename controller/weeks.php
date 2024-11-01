<?php
require_once __DIR__ . '/../lib/DataSource.php';
require_once "../model/weeks.php";

$mode = $_REQUEST['mode'];

$objWeek = new Weeks();

if($mode=="insert"){
	$name = $_REQUEST['name'];
    $fromData = $_REQUEST['fromData'];
    $toData = $_REQUEST['toData'];
	$objWeek->save($name,$fromData,$toData);
}else if($mode=="load"){
	$i=1;
	$result = "";
	$teams = $objWeek->getAll();
	while($row = $teams->fetch_assoc()){ 
	$result.="<tr>";
		$result.="<td>".$i++."</td>";
		$result.="<td>".$row["name"]."</td>";
        $result.="<td>".$row["from_date"]."</td>";
        $result.="<td>".$row["to_date"]."</td>";
		$result.="<td><a class='edit' href='#' data-id='".$row["id"]."'>Edit</a> | <a class='delete' href='#' data-id='".$row["id"]."'>Delete</a></td>";
	$result.="</tr>";
	};
	echo $result;
}else if($mode=="loadOne"){
	$id = $_REQUEST['id'];
	$result = $objWeek->getOne($id)->fetch_assoc();
	echo json_encode($result);
}else if($mode=="update"){
	$name = $_REQUEST['name'];
    $fromData = $_REQUEST['fromData'];
    $toData = $_REQUEST['toData'];
	$id = $_REQUEST['id'];
	$objWeek->update($id, $name,$fromData,$toData);
}else if($mode=="delete"){
	$id = $_REQUEST['id'];
	$objWeek->delete($id);
}
?>