<?php
require_once __DIR__ . '/../lib/DataSource.php';
require_once "../model/weeks.php";

$mode = $_REQUEST['mode'];

$objWeek = new Weeks();
$result = "";
if($mode=="loadAll"){
    $weeksData = $objWeek->getAll();
	$result.="<option value='-1'>";
	$result.="Select One";
	$result.="</option>";
	while($row = $weeksData->fetch_assoc()){
		$result.="<option value='".$row["id"]."'>";
		$result.=$row["name"];
		$result.="</option>";
	}
	echo $result;
    
}




