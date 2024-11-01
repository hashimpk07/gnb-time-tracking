<?php
require_once __DIR__ . '/../lib/DataSource.php';
require_once "../model/teams.php";
require_once "../model/employee.php";

$mode = $_REQUEST['mode'];

$objTeams = new Teams();
$result = "";
if($mode == "loadAll"){
	$teamsCategories = $objTeams->getAll();
	$result.="<option value='-1'>";
	$result.="Select One";
	$result.="</option>";
	while($row = $teamsCategories->fetch_assoc()){
		$result.="<option value='".$row["id"]."'>";
		$result.=$row["name"];
		$result.="</option>";
	}
	echo $result;
}else if($mode == "loadOne"){
	$objTeam = new Employee();
	$teams = $objTeam->getOne($_REQUEST['id'])->fetch_assoc();
	$teamsCategories = $objTeams->getAll();
	$result.="<option value='-1'>";
	$result.="Select One";
	$result.="</option>";
	while($row = $teamsCategories->fetch_assoc()){
		$result.="<option value='".$row["id"]."'";
		if($row["id"]==$teams['teams_id']) $result.= " selected";
		$result.=">";
		$result.=$row["name"];
		$result.="</option>";
	}
	echo $result;
}
?>