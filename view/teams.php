<?php
session_start();
if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
    session_write_close();
} else {
    // since the username is not set in session, the user is not-logged-in
    // he is trying to access this page unauthorized
    // so let's clear all session variables and redirect him to index
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
<script src="../vendor/jquery.min.js" type="text/javascript"></script>
<script src="../vendor/teams.js"  type="text/javascript" ></script>
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
		
	
    <div class="topnav">
        <a class="active" href="teams.php" >Team </a>
        <a href="employee.php" >Employee </a>
        <a href="weeks.php" >Weeks </a>
        <a href="plan.php">Plan </a>
    </div>

  
    <p class="table-margin">
		<button name="team" class="items-title">New Team</button>
	</p>
	<p id="loading" style="display:none">
	Loading..............
	</p>
	
	<table border="1" cellpadding="5" cellspacing="0" class="table-margin">
		<thead>
			<tr>
				<td></td>
				<td><input type="text" name="name"></td>
				<td><input type="submit" id="save" class="items"></td>
			</tr>
			<tr>
				<th>No</th>
				<th>Team Name</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			
		</tbody>
	</table>

    </div>
   
</BODY>
</HTML>
