##  GNB-TECH Time Tracking System  (GNB-TECH SOFTWARE SOLUTIONS PVT LTD  )

<h3> Project Overview </h3>
<p> The GNB-TECH Time Tracking System is designed to manage and track employee work hours on a weekly basis. The system dynamically generates weekly schedules, calculates individual and team totals, and allows users to adjust hours with automatic recalculations of totals </p>

<h3> Project Structure </h3>
<ul>
  <li> assets: Contains CSS files for styling.</li>
  <li> controller: Contains PHP files for handling logic, AJAX requests, and data updates.</li>
  <li >model: Contains model classes (Weeks and Employee) for database operations.</li>
  <li>vendor: Contains third-party libraries, including jQuery and Ajax.</li>
  <li>View : Html file</li>
</ul>

<h3> Project Requirements </h3>
<ul>
  <li> PHP Version: 7.2 or above.</li>
  <li> Apache Server </li>
  <li> MySQL: Version 5 or above </li>
</ul>

<h3> Setup Guide </h3>  
<ul>
  <li> Clone the Project Repository : https://github.com/hashimpk07/gnb-time-tracking.git </li>
  <li> Download and Extract the Project Files into the Apache server’s root directory (e.g., htdocs for XAMPP or www for WAMP).</li>
  <p>Database Configuration:</p>
  <li>  Create a MySQL database for the project.</li>
  <p>Import the provided SQL file (if available) or create tables as outlined in the Database Structure section below.
    Configure database connection settings in lib/DataSource.php</p>  
  <p> private $host = 'localhost';  </p>   
  <p> private $dbName = 'your_database';   </p>    
  <p> private $username = 'your_username';  </p>   
  <p> private $password = 'your_password';  </p>   
 <li> Run the browser  : localhost/gnb-time-tracking</li>
 <li>UserName  :  Hashim</li>
  <li>Password  :  12345678</li>
</ul>

