<?php
session_start();
if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
    session_write_close();
} else {
 
    session_unset();
    session_write_close();
    $url = "../index.php";
    header("Location: $url");
}

?>
<HTML>
<HEAD>
<TITLE>Welcome</TITLE>
<link href="../assets/css/phppot-style.css" type="text/css" rel="stylesheet" />
<link href="../assets/css/user-registration.css" type="text/css" rel="stylesheet" />
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f7f7f7;
}

.container {
    width: 80%;
    margin: 20px auto;
    padding: 20px;
    background-color: #ffffff;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

h2 {
    text-align: center;
    color: #333;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table, th, td {
    border: 1px solid #dddddd;
}

th, td {
    padding: 10px;
    text-align: center;
}

#consolidated {
    margin-top: 20px;
    font-size: 1.1em;
    color: #333;
}

input.hoursInput {
    width: 80px;
    padding: 5px;
    text-align: center;
}


</style>
<script src="../vendor/jquery.min.js" type="text/javascript"></script>
<script src="../vendor/plan.js"  type="text/javascript" ></script>
<style type="text/css">
	table img{
		width: 200px;
	}
</style>

</HEAD>
<BODY>
	<div class="phppot-container">
        <div class="jumbotron">
    		<h1>GNB-TECH SOFTWARE SOLUTIONS PVT LTD</h1>      
        </div>
        
		<div class="page-header">
			  <div lass="page-content" style="margin-top: 15px;margin-left: 15px;">Welcome <?php echo $username;?>
                <span class="login-signup" ><a href="logout.php">Logout</a></span>
            </div>
		</div>
		
	
    <div class="topnav" style="margin-bottom: 30px;">
        <a href="teams.php" >Team </a>
        <a href="employee.php" >Employee </a>
        <a href="weeks.php" >Weeks </a>
        <a class="active" href="plan.php">Plan </a>
    </div>

    <select id="weeks" name="weeks">
        <option value="">--Select Week--</option>
       
    </select>

    <table id="scheduleTable">
        <thead>
         
        </thead>
        <tbody>
            <!-- Rows will be populated through AJAX -->
        </tbody>
    </table>

    

    </div>
    <script>

$(document).ready(function() {
    $('#weeks').change(function() {
        const weekId = $(this).val();
        if (weekId) {
            $.ajax({
                url: "../controller/weekPlan.php",
                type: 'POST',
                data: { week_id: weekId },
                success: function(response) {
                    $('#scheduleTable').html(response); 
              
                }
            });
        } else {
            $('#scheduleTable tbody').empty();
            $('#teamTotal').text(0);
            $('#overallTotal').text(0);
        }
    });

    $(document).on('input', '.hoursInput', function() {
     
    });
});

function updateTotals(input) {
    const teamName = input.getAttribute('data-team'); 
    const employee = input.getAttribute('data-employee'); 
    const date = input.getAttribute('data-date'); 
    const hours = input.value;
 

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "../controller/updatePlanTotal.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.error) {
                console.error(response.error);
            } else {
                document.querySelector(`.row-total[data-employee='${employee}']`).innerText = response.rowTotal;
                document.querySelector(`.column-total[data-date='${date}']`).innerText = response.columnTotal;
                document.getElementById('grand-total').innerText = response.grandTotal;
            }
        }
    };
    xhr.send(`team_name=${encodeURIComponent(teamName)}&employee=${encodeURIComponent(employee)}&date=${encodeURIComponent(date)}&hours=${encodeURIComponent(hours)}`); 
}

</script>

</BODY>
</HTML>
