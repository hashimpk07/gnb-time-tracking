<?php

require_once __DIR__ . '/../lib/DataSource.php';
require_once "../model/weeks.php";
require_once "../model/employee.php";
session_start();
$objEmp     = new Employee();
$objsWeekd  = new Weeks();
if (!isset($_SESSION['hoursData'])) {
    $_SESSION['hoursData'] = [];
    $_SESSION['table'] = [];
}
if (isset($_POST['week_id'])) {
    $week_id = $_POST['week_id'];
	$weeksResult = $objsWeekd->getOne($week_id)->fetch_assoc();

    if(!empty($weeksResult)){
        $result = "";
        $fromDate   = new DateTime($weeksResult['from_date']);
        $toDate     = new DateTime($weeksResult['to_date']);

        $toDate->modify('+1 day');
        $interval = new DateInterval("P1D");
        $period = new DatePeriod($fromDate, $interval, $toDate);
        $datesBetween = [];

        foreach ($period as $date) {
            $datesBetween[] = $date->format("l d M");
        }
      
        $employee = $objEmp->getAll();
        while($row = $employee->fetch_assoc()){ 
            $team = $row['teamName']; 
            $name = $row['name']; 
            if (!isset($results[$team])) {
                $results[$team] = [];
            }
            $results[$team][] = $name;
        }

        $hoursData = [];
        foreach ($results as $teamName => $employees) {
            foreach ($employees as $employee) {
                foreach ($datesBetween as $date) {  
                    $hoursData[$teamName][$employee][$date] = generateRandomTime();
                }
            }
        }
   
        $_SESSION['hoursData'] = $hoursData; 
        $table = [];
        $totalPerDate = array_fill(0, count($datesBetween), 0);
        
        function convertToMinutes($time) {
            list($hours, $minutes) = explode(":", $time);
            return $hours * 60 + $minutes;
        }
        
        function convertToHours($minutes) {
            $hours = floor($minutes / 60);
            $minutes = $minutes % 60;
            return sprintf("%02d:%02d", $hours, $minutes);
        }
        
        foreach ($results as $teamName => $employees) {
            $teamRow = ["name" => $teamName, "data" => array_fill(0, count($datesBetween), "00:00"), "total" => "00:00"];
            $table[] = $teamRow;
        
            foreach ($employees as $employee) {
                $employeeRow = ["name" => $employee, "data" => [], "total" => 0];
                $employeeTotal = 0;

                foreach ($datesBetween as $index => $date) {
                    $hours = $hoursData[$teamName][$employee][$date] ?? "00:00";
                    $employeeRow['data'][$index] = $hours;
                    $minutes = convertToMinutes($hours);
                    $employeeTotal += $minutes;
                    $totalPerDate[$index] += $minutes;
                }
    
                $employeeRow['total'] = convertToHours($employeeTotal);
                $table[] = $employeeRow;
            }
        }
        $_SESSION['table'] = $table;

        $totalRow = ["name" => "Total", "data" => [], "total" => 0];
        $totalMinutes = array_sum($totalPerDate);
        foreach ($totalPerDate as $minutes) {
            $totalRow["data"][] = convertToHours($minutes);
        }
        $totalRow["total"] = convertToHours($totalMinutes);
        $_SESSION['totalRow'] = $totalRow;
        
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>#</th>";
        
        foreach ($datesBetween as $date) {
            echo "<th>$date</th>";
        }
        echo "<th>Total</th></tr>";
    
        foreach ($table as $row) {
            echo "<tr>";
            echo "<td>{$row['name']}</td>";
        
            foreach ($row['data'] as $index => $hours) {
                if($hours =='00:00'){
                    echo "<td>$hours</td>";
                }else{
                    echo "<td><input type='text' value='$hours' onchange='updateTotals(this)' data-index='$index' 
           data-employee='{$row['name']}' 
           data-team='$teamName' 
           data-date='$date'></td>";
                }  
            }
            echo "<td class='row-total' data-name='{$row['name']}'>{$row['total']}</td>";
            echo "</tr>";
        }

        echo "<tr><td>Total</td>";
        foreach ($totalRow['data'] as $index => $hours) {
            echo "<td class='column-total' data-index='$index'>$hours</td>";
        }
        echo "<td id='grand-total'>{$totalRow['total']}</td></tr>";
        echo "</table>";
    }
  
}
function generateRandomTime() {
    $hours = str_pad(rand(0, 11), 2, "0", STR_PAD_LEFT); 
    $minutes = str_pad(rand(0, 59), 2, "0", STR_PAD_LEFT);
    return "$hours:$minutes";
}
?>