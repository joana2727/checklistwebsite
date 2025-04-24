<?php
require 'connection.php'; // Database connection

// SQL query to fetch First Year data with a "Status" column
$sql = "
  SELECT
    *,
    IF(
      CAST(grade AS DECIMAL(3, 2)) <= 3, 'Passed', 'Unpassed'
    ) AS status
  FROM
    wholeChecklist
  WHERE
    year_level = 'First Year'
";

$result = $connection->query($sql); // Execute the query

// Check if the query execution was successful
if ($result === false) {
    echo "Error fetching First Year data: " . $connection->error;
    exit; // Stop execution if there's an error
}

?>
    <style>
        @import url('fonts.css');

        body {
            font-family: Content;
            margin: 0;
            padding: 0;
            background-color: #A8D38D; /* Light green background for the body */
            font-size: 80%;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 50px;
            max-width: 90%;
            margin: 20px auto;
            text-align: center;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.30);
        }
        .greeting {
            display: flex;
            align-items: center;
            padding: 20px;
            font-family: Header;
            text-align: left;
        }
        
        .greeting h1 {
            margin: 0;
            font-size: 1.5em;
            margin-left: 1.5%;
        }
        
        .greeting img {
            margin-left: 20px;
            height: 5rem;
            border-radius: 50%;
        }

        .search-bar-container {
            display: flex;
            justify-content: space-between; /* Aligns filter left and search right */
            align-items: center; /* Ensures items are vertically centered */
            padding: 10px 0;
        }

        .filter-dropdown {
            padding: 5px;
            border-radius: 50px;
            border: 1px solid #ccc;
            background-color: white;
            font-family: Content;
        }

        .search-bar {
            padding: 8px;
            border-radius: 50px;
            border: 1px solid #ccc;
            width: 200px;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
            font-family: Content;
        }
        
        .filter {
            align-items: center; /* Align items vertically */
            padding: 10px 0;
        }
        
table {
    width: 100%;
    border-collapse: collapse; /* Ensures there are no extra gaps between table cells */
    font-size: 11px; /* Consistent font size */
}

table, th, td {
    border: 1px solid black; /* Uniform border */
    padding: 8px; /* Consistent padding */
    text-align: center; /* Centered text */
}

th {
    background-color: #f2f2f2; /* Consistent background color for headers */
}

tr:nth-child(odd) {
    background-color: #f2f2f2; /* Alternating row colors */
}
        
        .pagination {
            text-align: center;
            margin-top: 20px;
        }
        
        .pagination a {
            color: gray;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin: 0 5px;
            min-width: 30px;
            display: inline-block;
        }
        
        .pagination a:hover {
            color: green;
            font-weight: bold;
        }
        
        .pagination strong {
            font-weight: bold;
            color: green;
            padding: 10px 20px;
            text-decoration: none;
            min-width: 30px;
            border-radius: 5px;
        }
        
        .back-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            display: inline-block;
            margin: 0 auto;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.30);
            margin-top: 1%;
        }

        .back-button:hover {
            background-color: green;
        }

        #first-year-checklist{
            font-size: 90%;
        }
    </style>
</head>
<body>
<div class="container"> <!-- Container with rounded corners -->
    <div class="greeting">
        <img src="Student Profile.png" alt="Student Profile"> <!-- Student's photo -->
        <?php
        require 'connection.php'; // Database connection
        
        $student_sql = "SELECT student_name FROM student WHERE student_number = '202211758'"; 
        $student_result = $connection->query($student_sql);

        if ($student_result->num_rows > 0) {
            $student_name = $student_result->fetch_assoc()["student_name"];
            echo "<h1>Hello, $student_name!</h1>";
        } else {
            echo "<h1>Hello, Student!</h1>";
        }
      ?>
    </div>
    
    <h2>First Year Checklist of Courses</h2>
    <div class="search-bar-container"> <!-- Align filter left, search right -->
        <div class="filter">
            <label for="filter-dropdown">Select Year:</label>
            <select id="filter-dropdown" class="filter-dropdown" onchange="redirectToYear(this.value)">
                <option value="">Select</option>
                <option value="firstYear.php">First Year</option>
                <option value="secondYear.php">Second Year</option>
                <option value="thirdYear.php">Third Year</option>
                <option value="fourthYear.php">Fourth Year</option>
            </select>
        </div>
        
        <input type="text" id="search-bar" placeholder="Search..." class = "search-bar" onkeyup="applySearch()" />
    </div> <!-- End search section -->    <script>
    function redirectToYear(page) {
        if (page) {
            window.location.href = page; // Redirect to the selected page
        }
    }
    </script>
    <div id="first-year-checklist">
        <?php if ($result->num_rows > 0): ?> 
            <table> 
                <tr>
                    <th>Student Number</th>
                    <th>Course Code</th>
                    <th>Course Title</th>
                    <th>Credit Unit<br>Lecture</th>
                    <th>Credit Unit<br>Lab</th>
                    <th>Contact Hours<br>Lecture</th>
                    <th>Contact Hours<br>Lab</th>
                    <th>Grade</th>
                    <th>Instructor Name</th>
                    <th>Semester</th>
                    <th>Status</th> 
                </tr> 
                
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row["student_number"]) ?></td>
                        <td><?= htmlspecialchars($row["course_code"]) ?></td>
                        <td><?= htmlspecialchars($row["course_title"]) ?></td>
                        <td><?= htmlspecialchars($row["credit_unit_lecture"]) ?></td>
                        <td><?= htmlspecialchars($row["credit_unit_lab"]) ?></td>
                        <td><?= htmlspecialchars($row["contact_hours_lecture"]) ?></td>
                        <td><?= htmlspecialchars($row["contact_hours_lab"]) ?></td>
                        <td><?= htmlspecialchars($row["grade"] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($row["instructor_name"]) ?></td>
                        <td><?= htmlspecialchars($row["semester"]) ?></td>
                        <td><?= htmlspecialchars($row["status"]) ?></td> 
                    </tr> 
                <?php endwhile; ?>
                <!-- Include the summary row -->
                <?php include 'summary.php'; // Include the summary row ?>
            
            </table>
        <?php else: ?>
            <p><b>No matching first year records found.</p>
        <?php endif; ?>
    </div>
    
    <script>
function applySearch() {
    var query = document.getElementById("search-bar").value.toLowerCase(); // Get the search query
    var rows = document.querySelectorAll("#first-year-checklist table tr"); // Get all rows

    if (query === "") { // If the search bar is empty, reload the original table
        location.reload(); // Reload the entire page
        return; // Exit the function early
    }

    var visibleCount = 0;
    var totalCourses = 0;
    var totalCreditLecture = 0;
    var totalCreditLab = 0;
    var totalContactLecture = 0;
    var totalContactLab = 0;
    var totalGrades = 0;
    var gradeCount = 0;

    rows.forEach((row, index) => {
        if (index === 0) return; // Skip the header row

        var cells = row.querySelectorAll("td");
        var matches = false;

        cells.forEach(cell => {
            if ((cell.textContent || cell.innerText).toLowerCase().includes(query)) {
                matches = true;
            }
        });

        if (matches) {
            row.style.display = ""; // Show if there's a match
            visibleCount++; // Count visible rows

            // Update summary values
            totalCourses++;
            totalCreditLecture += parseFloat(cells[3].textContent); // Credit Unit Lecture
            totalCreditLab += parseFloat(cells[4].textContent); // Credit Unit Lab
            totalContactLecture += parseFloat(cells[5].textContent); // Contact Hours Lecture
            totalContactLab += parseFloat(cells[6].textContent); // Contact Hours Lab
            var grade = parseFloat(cells[7].textContent);
            if (!isNaN(grade)) {
                totalGrades += grade;
                gradeCount++;
            }
        } else {
            row.style.display = "none"; // Hide if no match
        }
    });

    var firstYearChecklist = document.getElementById("first-year-checklist");

    if (visibleCount === 0) {
        // If no rows are visible, replace the content with a message
        firstYearChecklist.innerHTML = "<p><b>No matching first-year records found.</b></p>";
    } else {
        // Create and append the summary row based on visible results
        var averageGrade = gradeCount > 0 ? (totalGrades / gradeCount).toFixed(2) : 'N/A';

        var summaryRow = `
            <tr>
                <td colspan="2"><b>Summary</b></td>
                <td><b>${totalCourses}</b></td>
                <td><b>${totalCreditLecture.toFixed(2)}</b></td>
                <td><b>${totalCreditLab.toFixed(2)}</b></td>
                <td><b>${totalContactLecture.toFixed(2)}</b></td>
                <td><b>${totalContactLab.toFixed(2)}</b></td>
                <td><b>${averageGrade}</b></td>
                <td colspan="3"></td>
            </tr>
        `;

        firstYearChecklist.querySelector("table").innerHTML += summaryRow; // Append the summary row
    }
}


    </script> <!-- JavaScript code for search -->
    
    <a href="wholeChecklist.php" class="back-button">Back to Checklist</a>
    <a href="index.php" class="back-button">Back to Home</a>
</div> <!-- Close the container -->
</body>
</html>

<?php $connection->close(); // Close the database connection ?>
