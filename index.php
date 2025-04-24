<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Checklist</title>
    <style>
        @import url('fonts.css');

        body {
            font-family: 'Content'; /* Font family */
            font-size: 80%; /* Base font size */
            margin: 0;
            padding: 0;
            min-height: 100vh; /* Ensure full viewport height */
            display: flex; /* Enable flexbox */
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
            background: linear-gradient(to bottom, #A8D38D, #A8D38D,#A8D38D, #4CAF50); /* Gradient background */
            overflow: hidden; /* Prevent scrollbars */
        }

        .container {
            background-color: white; /* White background for the container */
            padding: 20px; /* Padding inside the container */
            border-radius: 50px; /* Rounded corners */
            box-shadow: 0 10px 10px rgba(0, 0, 0, 0.30); /* Subtle shadow */
            text-align: center; /* Center content within the container */
        }

        header {
            padding: 20px; /* Padding for the header */
            line-height: 10px;
            text-align: center; /* Center header content */
        }

        img {
            height: 100px; /* Adjust the logo image size */
        }

        table {
            width: 100%; /* Full-width table */
            border-collapse: collapse; /* Avoid double borders */
        }

        table, th, td {
            border: 1px solid black; /* Borders for table elements */
            padding: 8px; /* Padding for table cells */
            text-align: center; /* Center text in the table */
        }

        th {
            background-color: #f2f2f2; /* Light gray for table headers */
        }

        tr:nth-child(odd) {
            background-color: #f2f2f2; /* Alternating row colors */
        }

        .view-button {
            background-color: #4CAF50; /* Green background for the button */
            color: white;
            padding: 10px 20px; /* Padding for the button */
            text-decoration: none; 
            border-radius: 5px; /* Rounded corners */
            text-align: center; /* Center text within the button */
            cursor: pointer;
            display: inline-block; /* Prevent full-width behavior */
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.30); /* Subtle shadow for depth */
            margin: 10px auto; /* Center the button */
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
        <h2>CAVITE STATE UNIVERSITY</h2>
        <h3>Bacoor City Campus</h3><br>
        <h1>BACHELOR OF SCIENCE IN COMPUTER SCIENCE</h1>
        <h1>Checklist of Courses</h1> <!-- Checklist header -->
    </header>

    <?php
    // Database connection
    require 'connection.php';

    // Get student information
    $student_sql = "SELECT * FROM student";
    $student_result = mysqli_query($connection, $student_sql);

    // Output the student information table within the container
    echo "<h2>Student Information</h2>"; 
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
        echo "</table>"; // End of the table
    } else {
        echo "No student data available."; // If no student data is found
    }

    // Centered "View Checklist" button
    echo "<div>"; // No specific class needed
    echo "<br>";
    echo "<a href='wholeChecklist.php' class='view-button'>View Checklist</a>"; // Centered button
    echo "</div>"; 

    // Close the database connection
    mysqli_close($connection);
    ?>

</div> <!-- Close the container div -->
</body>
</html>
