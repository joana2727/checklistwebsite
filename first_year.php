<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Checklist</title>
    <style>
        @import url('fonts.css');

        body {
            font-family: Content;
            margin: 0;
            padding: 0;
            background-color: #A8D38D; /* Light green background for the body */
        }
        .container {
            background-color: white; /* White background for the container */
            padding: 20px;
            border-radius: 50px; /* Rounded corners */
            max-width: 60%; /* Maximum width for responsiveness */
            margin: 20px auto; /* Centering the container */
            text-align: center; /* Center content within the container */
        }
        header {
            padding: 20px;
            line-height: 10px;
        }
        img {
            height: 100px; /* Adjust the logo image size */
        }
        h1 {
            font-size: 24px; /* Font size for headers */
            margin: 10px;
        }
        table {
            width: 100%; /* The table takes the full width of the container */
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2; /* Light gray for table headers */
        }
        tr:nth-child(even) {
            background-color: #f2f2f2; /* Alternating row colors */
        }
        .view-button {
            background-color: #4CAF50; /* Green background for the button */
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px; /* Rounded corners for the button */
            text-align: center;
            cursor: pointer;
            display: inline-block; /* To prevent full-width behavior */
            margin: 0 auto; /* Center the button */
        }
        .view-button:hover {
            background-color: green; /* Darker green on hover */
        }
    </style>
</head>
<body>
<div class="container"> <!-- Container to keep everything inside a box with rounded corners -->
    <header>
        <img src="logo.png" alt="School Logo"> <!-- School logo image -->
        <h1>CAVITE STATE UNIVERSITY</h1>
        <h3>Bacoor City Campus</h3><br>
        <h2>BACHELOR OF SCIENCE IN COMPUTER SCIENCE</h2>
        <h2>Checklist of Courses</h2> <!-- Checklist header -->
    </header>


<?php

// Database connection
require 'connection.php'; 

// Get student information
$student_sql = "SELECT * FROM student";
$student_result = mysqli_query($connection, $student_sql);

echo "<h3>Student Information</h3>";
if ($student_result && mysqli_num_rows($student_result) > 0) {
    echo "<table>";
    echo "<tr><th>Student Number</th><th>Student Name</th><th>Address</th><th>Contact Number</th><th>Adviser Name</th></tr>";
    while ($row = mysqli_fetch_assoc($student_result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["student_number"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["student_name"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["address"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["contact_number"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["adviser_name"]) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No student data available.";
}

// Get first-year table data
$first_year_sql = "SELECT * FROM joined_firstyear";
$first_year_result = mysqli_query($connection, $first_year_sql);

echo "<h3>First Year Courses</h3>";
if ($first_year_result && mysqli_num_rows($first_year_result) > 0) {
    echo "<table>";
    echo "<tr><th>Student Number</th><th>Course Code</th><th>Course Title</th><th>Credit Unit (Lecture)</th><th>Credit Unit (Lab)</th><th>Contact Hours (Lecture)</th><th>Contact Hours (Lab)</th><th>Grade</th><th>Instructor</th><th>Semester</th></tr>";
    while ($row = mysqli_fetch_assoc($first_year_result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["student_number"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["course_code"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["course_title"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["credit_unit_lecture"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["credit_unit_lab"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["contact_hours_lecture"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["contact_hours_lab"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["grade"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["instructor_name"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["semester"]) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No first-year course data available.";
}

// Close the database connection
mysqli_close($connection);

// Back button
echo "<a href='index.php' class='back-button'>Back to Main Page</a>";
?>

</body>
</html>
