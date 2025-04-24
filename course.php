<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Course Pre-requisite</title>
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
        
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }

        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(odd) {
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
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
            font-family: Content;
            margin-bottom: 10px;
            
        }
        
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
    <script>
        var searchTimeout;

        function handleSearch() {
            clearTimeout(searchTimeout); 
            searchTimeout = setTimeout(function() {
                var query = document.getElementById("search-input").value;
                if (query) {
                    $.post("search.php", { input: query }, function(data) { 
                        document.getElementById("search-results").innerHTML = data;
                    });
                } else {
                    location.reload();
                }
            }, 300);
        }

        function handlePagination(page) {
            var input = document.getElementById("search-input").value;
            $.post("search.php", { page: page, input: input }, function(data) {
                document.getElementById("search-results").innerHTML = data;
            });
        }
    </script>
</head>
<body>
<div class="container">
    <div class="greeting">
        <img src="Student Profile.png" alt="Student Profile">
        <?php
        require 'connection.php';
        
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
    <h2>Course Pre-requisite</h2>  
    <div class="search-bar-container"> 
        <input type="text" id="search-input" class="search-bar" placeholder="Search..." onkeyup="handleSearch()"/> 
    </div>

    <div id="search-results"> 

    <?php
    require 'connection.php';

    $rows_per_page = 10;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $rows_per_page;

    $count_sql = "SELECT COUNT(*) AS total FROM course"; 
    $total_result = $connection->query($count_sql);
    $total_rows = $total_result->fetch_assoc()["total"];
    $total_pages = ceil($total_rows / $rows_per_page);

    $sql = "SELECT course_code, course_title, credit_unit_lecture, credit_unit_lab, contact_hours_lecture, contact_hours_lab, pre_requisite FROM course LIMIT $rows_per_page OFFSET $offset";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr>
            <th>Course Code</th>
            <th>Course Title</th>
            <th>Pre-requisite</th>
          </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>" . htmlspecialchars($row["course_code"]) . "</td>
                <td>" . htmlspecialchars($row["course_title"]) . "</td>
                <td>" . htmlspecialchars($row["pre_requisite"] ?? 'N/A') . "</td>
              </tr>";
        }

        echo "</table>";

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
        echo "No courses found.";
    }

    echo "<br>";
    echo "<a href='wholeChecklist.php' class='back-button'>Back to Checklist</a>";

    $connection->close();
    ?>

    </div>
</div>
</body>
</html>
