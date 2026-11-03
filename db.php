<?php
$conn = mysqli_connect("localhost", "root", "", "employee_db");

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

echo "";
?>