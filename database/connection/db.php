<?php

//Your Mysql Config
// $servername = "server10";
// $username = "atifkari_m";
// $password = "atifkarim123";
// $dbname = "atifkari_cse482_internship_db";

//Xampp SQL server
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jayga_db_1";


//Create New Database Connection
$conn = new mysqli($servername, $username, $password, $dbname);

//Check Connection
if($conn->connect_error) {
	die("Connection Failed: ". $conn->connect_error);
}