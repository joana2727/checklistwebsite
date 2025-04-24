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
            background-color: #A8D38D;
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
        
        .filter-dropdown {
    padding: 5px; /* Padding for the dropdown */
    border-radius: 50px; /* Rounded corners */
    border: 1px solid #ccc; /* Light gray border */
    box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1); /* Inner shadow */
    background-color: white; /* Background color */
    font-family: Content; /* Consistent font */
}

.filter {
    display: flex;
    justify-content: space-between; /* Aligns items at the edges */
    align-items: center; /* Center vertically */
    padding: 10px 0; /* Padding around the filter */
}

        
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        
        th {
            background-color: #f2f2f2;
        }
        
        tr:nth-child(even) {
            background-color: #f2f2f2;
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
        }

        .back-button:hover {
            background-color: green;
        }
        
        .search-bar {
            padding: 8px;
            border-radius: 50px;
            border: 1px solid #ccc;
            width: 200px;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1); /* Inner shadow */
            font-family: Content;
        }
        
    </style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>

        
        var searchTimeout; 

        function handleSearch() {
            clearTimeout(searchTimeout); 
            searchTimeout = setTimeout(function() {
                var query = document.getElementById("search-input").value; // Get the search query
                if (query) { 
                    $.post("search.php", { input: query }, function(data) { 
                        document.getElementById("search-results").innerHTML = data;
                    });
                } else { // If empty, show original content
                    location.reload();
                }
            }, 300); // Debounce delay
        }
    </script>
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
    <h2>CHECKLIST OF COURSES</h2>

    <div class="filter"> <!-- New section for filter and search -->
    <div>
        <label for="filter-dropdown">Select Year:</label>
        <select id="filter-dropdown" class="filter-dropdown" name="filter-dropdown" onchange="redirectToYear(this.value)"> <!-- Apply the new class -->
            <option value="">-- Select --</option>
            <option value="firstYear.php">First Year</option>
            <option value="secondYear.php">Second Year</option>
            <option value="thirdYear.php">Third Year</option>
            <option value="fourthYear.php">Fourth Year</option>
        </select>
    </div>
    <input type="text" class="search-bar" placeholder="Search..." /> <!-- Your search bar -->
</div>


    <div id="search-results"> <!-- AJAX results displayed here -->
        <?php
        require 'connection.php'; // Database connection

        // Define rows per page
        $rows_per_page = 10;

        // Determine which page to display based on a query parameter
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Default to page 1
        $offset = ($page - 1) * $rows_per_page; // Calculate offset for the query

        // SQL query to get the total number of rows
        $count_sql = "SELECT COUNT(*) AS total FROM wholeChecklist"; 
        $total_result = $connection->query($count_sql);
        $total_rows = $total_result->fetch_assoc()["total"];
        $total_pages = ceil($total_rows / $rows_per_page); // Calculate total pages

        // SQL query to fetch data from the wholeChecklist view with limit and offset
        $sql = "SELECT * FROM wholeChecklist LIMIT $rows_per_page OFFSET $offset"; 
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            echo "<table>"; 
            echo "<tr>
                <th>Student Number</th>
                <th>Course Code</th>
                <th>Course Title</th>
                <th>Credit Unit Lecture</th>
                <th>Credit Unit Lab</th>
                <th>Contact Hours Lecture</th>
                <th>Contact Hours Lab</th>
                <th>Grade</th>
                <th>Instructor Name</th>
                <th>Semester</th>
                <th>Year Level</th>
              </tr>"; 

            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>" . htmlspecialchars($row["student_number"]) . "</td>
                    <td>" . htmlspecialchars($row["course_code"]) . "</td>
                    <td>" . htmlspecialchars($row["course_title"]) . "</td>
                    <td>" . htmlspecialchars($row["credit_unit_lecture"]) . "</td>
                    <td>" . htmlspecialchars($row["credit_unit_lab"]) . "</td>
                    <td>" . htmlspecialchars($row["contact_hours_lecture"]) . "</td>
                    <td>" . htmlspecialchars($row["contact_hours_lab"]) . "</td>
                    <td>" . htmlspecialchars($row["grade"] ?? 'N/A') . "</td>
                    <td>" . htmlspecialchars($row["instructor_name"]) . "</td>
                    <td>" . htmlspecialchars($row["semester"]) . "</td>
                    <td>" . htmlspecialchars($row["year_level"]) . "</td>
                  </tr>"; 
            }

            echo "</table>"; 

            // Pagination logic
            echo "<div class='pagination'>";

            if ($page > 1) {
                echo "<a href='?page=" . ($page - 1) . "'>Previous</a>"; 
            }

            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == $page) {
                    echo "<strong>$i</strong>"; 
                } else {
                    echo "<a href='?page=$i'>$i</a>"; 
                }
            }

            if ($page < $total_pages) {
                echo "<a href='?page=" . ($page + 1) . "'>Next</a>"; 
            }

            echo "</div>"; 

        } else {
            echo "No data found in wholeChecklist."; 
        }

        $connection->close(); // Close the connection
        ?>
    </div> <!-- End of search-results div -->

    <br>
    <a href='index.php' class='back-button'>Back to Home</a> <!-- Back button -->

</div> <!-- End of container -->
</body>
</html>