<?php
session_start(); 


function timeToMinutes($time) {
    list($hours, $minutes) = explode(":", $time);
    return $hours * 60 + $minutes;
}

function minutesToTime($minutes) {
    $hours = floor($minutes / 60);
    $minutes = $minutes % 60;
    return sprintf("%02d:%02d", $hours, $minutes);
}

$teamName = $_POST['team_name'] ?? null;
$employee = $_POST['employee'] ?? null;
$date = $_POST['date'] ?? null;
$hours = $_POST['hours'] ?? "00:00";

if (isset($_SESSION['hoursData'][$teamName][$employee][$date])) {
    
    $_SESSION['hoursData'][$teamName][$employee][$date] = $hours;

    $employeeTotalMinutes = 0;
    foreach ($_SESSION['hoursData'][$teamName][$employee] as $time) {
        $employeeTotalMinutes += timeToMinutes($time);
    }
    $rowTotal = minutesToTime($employeeTotalMinutes);

    $columnTotalMinutes = 0;
    foreach ($_SESSION['hoursData'] as $teamData) {
        foreach ($teamData as $employeeData) {
            $columnTotalMinutes += timeToMinutes($employeeData[$date] ?? '00:00');
        }
    }
    $columnTotal = minutesToTime($columnTotalMinutes);

    $grandTotalMinutes = 0;
    foreach ($_SESSION['hoursData'] as $teamData) {
        foreach ($teamData as $employeeData) {
            foreach ($employeeData as $time) {
                $grandTotalMinutes += timeToMinutes($time);
            }
        }
    }
    $grandTotal = minutesToTime($grandTotalMinutes);

    echo json_encode([
        'rowTotal' => $rowTotal,
        'columnTotal' => $columnTotal,
        'grandTotal' => $grandTotal
    ]);
} else {
    echo json_encode(['error' => 'Invalid data']);
}

