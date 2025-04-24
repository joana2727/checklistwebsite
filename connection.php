<?php
$connection = mysqli_connect("localhost", "root", "password", "student_checklist");

if (!$connection) {
    die("Connection error: " . mysqli_connect_error());
}

?>