<?php
require 'connection.php'; // Include the database connection

$rows_per_page = 10; // Number of rows per page
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1; // Get the current page from the client
$offset = ($page - 1) * $rows_per_page; // Calculate the offset for the SQL query

$input = isset($_POST['input']) ? $_POST['input'] : ''; // Get the search input

// Query to fetch matching records with the correct "Status" logic
$query = "
  SELECT
    *,
    IF(
      CAST(grade AS DECIMAL(3, 2)) <= 3, 'Passed', 'Unpassed'
    ) AS status
  FROM
    wholeChecklist
  WHERE
    course_code LIKE '%$input%' 
    OR course_title LIKE '%$input%' 
    OR grade LIKE '%$input%' 
    OR instructor_name LIKE '%$input%' 
    OR semester LIKE '%$input%' 
    OR year_level LIKE '%$input%'
  LIMIT $rows_per_page
  OFFSET $offset
";

$result = mysqli_query($connection, $query); // Execute the query

// Get total count of matching results for pagination
$count_query = "SELECT COUNT(*) AS total 
                FROM wholeChecklist 
                WHERE 
                  course_code LIKE '%$input%' 
                  OR course_title LIKE '%$input%' 
                      --   OR credit_unit_lecture LIKE '%$input%' 
    --   OR credit_unit_lab LIKE '%$input%' 
    --   OR contact_hours_lecture LIKE '%$input%' 
    --   OR contact_hours_lab LIKE '%$input%' 

                  OR grade LIKE '%$input%' 
                  OR instructor_name LIKE '%$input%' 
                  OR semester LIKE '%$input%' 
                  OR year_level LIKE '%$input%'";
$count_result = mysqli_query($connection, $count_query); // Execute the count query
$total_rows = mysqli_fetch_assoc($count_result)['total']; // Get the total count

$total_pages = ceil($total_rows / $rows_per_page); // Calculate total pages

// Display the table with the "Status" column
if (mysqli_num_rows($result) > 0) { // If there are results
    echo "<table>"; // Start the table
    echo "<tr>
        <th>Course Code</th>
        <th>Course Title</th>
        <th>Credit Unit<br>Lecture</th>
        <th>Credit Unit<br>Lab</th>
        <th>Contact Hours<br>Lecture</th>
        <th>Contact Hours<br>Lab</th>
        <th>Grade</th>
        <th>Instructor</th>
        <th>Semester</th>
        <th>Year Level</th>
        <th>Status</th> <!-- Add the 'Status' header -->
      </tr>"; // Table headers

    // Loop through the results
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
            <td>" . htmlspecialchars($row['course_code']) . "</td>
            <td>" . htmlspecialchars($row['course_title']) . "</td>
            <td>" . htmlspecialchars($row['credit_unit_lecture']) . "</td>
            <td>" . htmlspecialchars($row['credit_unit_lab']) . "</td>
            <td>" . htmlspecialchars($row['contact_hours_lecture']) . "</td>
            <td>" . htmlspecialchars($row['contact_hours_lab']) . "</td>
            <td>" . htmlspecialchars($row['grade'] ?? 'N/A') . "</td>
            <td>" . htmlspecialchars($row['instructor_name']) . "</td>
            <td>" . htmlspecialchars($row['semester']) . "</td>
            <td>" . htmlspecialchars($row['year_level']) . "</td>
            <td>" . htmlspecialchars($row['status']) . "</td> <!-- Add 'Status' to table rows -->
        </tr>";
    }

    echo "</table>"; // Close the table

    // Pagination controls
    if ($total_pages > 1) { // Only display pagination if more than one page
        echo "<div class='pagination'>";

        if ($page > 1) { // Previous link
            echo "<a href='#' onclick='handlePagination(" . ($page - 1) . ")'>Previous</a>"; 
        }

        for ($i = 1; $i <= $total_pages; $i++) { // Display page numbers
            if ($i == $page) { // Highlight current page
                echo "<strong>$i</strong>"; 
            } else { // Link to other pages
                echo "<a href='#' onclick='handlePagination($i)'>$i</a>"; 
            }
        }

        if ($page < $total_pages) { // Next link if not on the last page
            echo "<a href='#' onclick='handlePagination(" . ($page + 1) . ")'>Next</a>"; 
        }

        echo "</div>"; // Close the pagination div
    }
} else {
    echo "<h6>No matching records found.</h6>"; // If no results are found
}

mysqli_close($connection); // Close the database connection
?>
