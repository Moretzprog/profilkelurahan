<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "db_profilkelurahan";

// Create connection
$koneksi = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$koneksi) {
    die("Connection failed: " . mysqli_connect_error());
}
