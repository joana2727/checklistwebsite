<?php
// Database connection
require 'connection.php';

// Query to fetch data for the summary
$sql_first_year = "SELECT * FROM wholeChecklist WHERE year_level = 'First Year'";
$sql_second_year = "SELECT * FROM wholeChecklist WHERE year_level = 'Second Year'";
$result = $connection->query($sql);

// Check for query errors
if ($result === false) {
    echo "Error fetching First Year data: " . $connection->error;
    exit; // Stop execution on error
}

// Variables to calculate summary
$total_courses = 0;
$total_credit_lecture = 0;
$total_credit_lab = 0;
$total_contact_lecture = 0;
$total_contact_lab = 0;
$total_grades = 0;
$grade_count = 0;

// Loop through the results and calculate the summary values
while ($row = $result->fetch_assoc()) {
    $total_courses++;
    $total_credit_lecture += $row["credit_unit_lecture"];
    $total_credit_lab += $row["credit_unit_lab"];
    $total_contact_lecture += $row["contact_hours_lecture"];
    $total_contact_lab += $row["contact_hours_lab"];
    if (is_numeric($row["grade"])) {
        $total_grades += $row["grade"];
        $grade_count++;
    }
}

// Generate the summary row
$summary_row = "
<tr>
    <td colspan='2'><b>Summary</td>
    <td><b>{$total_courses}</td>
    <td><b>{$total_credit_lecture}</td>
    <td><b>{$total_credit_lab}</td>
    <td><b>{$total_contact_lecture}</td>
    <td><b>{$total_contact_lab}</td>
    <td><b>" . ($grade_count > 0 ? number_format($total_grades / $grade_count, 2) : 'N/A') . "</td>
    <td colspan='3'></td>
</tr>
";

// Return the summary row for inclusion in other files
echo $summary_row; // Output the summary row
