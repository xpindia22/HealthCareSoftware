<?php
require 'header-jhcpl.php';
//payments are added to index .php itself into user_info table
// require 'authenticate.php';
$host = "localhost";
$user = "jhcpl";
$pwd = "jhcpl";
$db = "open72";

// Create connection
$conn = new mysqli($host, $user, $pwd, $db);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>



<!DOCTYPE html>
<html>
<head>
    <title>Sort Patient Info</title>
    <style>
        body {
            background-color: #f0f0f0; /* Change this to your preferred soothing color */
        }
        #userTable tr:nth-child(even) {
            background-color: #d0d0d0; /* Change this to your preferred even row color */
        }
        #userTable tr:nth-child(odd) {
            background-color: #ffffff; /* Change this to your preferred odd row color */
        }
        .body-class{
            margin: 50px;
        }
        table{
            text-align: left;
        }
    </style>
    <script type="text/javascript">
        // Your existing JavaScript code...
    </script>
    <script type="text/javascript">
        function sortTable(column) {
            var table = document.getElementById("userTable");
            var rows = Array.from(table.getElementsByTagName("tr"));
            var headerRow = rows.shift(); // Remove header row

            rows.sort(function(a, b) {
                var aValue = a.cells[column].textContent;
                var bValue = b.cells[column].textContent;
                return aValue.localeCompare(bValue);
            });

            // Reverse the order if already sorted in ascending
            if (table.getAttribute("data-sorted") === column.toString()) {
                rows.reverse();
                table.removeAttribute("data-sorted");
            } else {
                table.setAttribute("data-sorted", column.toString());
            }

            // Re-insert rows into the table
            table.innerHTML = "";
            table.appendChild(headerRow);
            rows.forEach(function(row) {
                table.appendChild(row);
            });
        }
    </script>
</head>
<body class='body-class'>
 
<?php
 

// Sort by ID
$sql = "SELECT * FROM patient_data ORDER BY id DESC";
$result = $conn->query($sql);

 

if ($result->num_rows > 0) {
    // Start table with CSS for borders
    echo "<table style='border-collapse: collapse; width: 100%;'>";

    // Print column headers
    echo "<tr>
    <th>ID</th>
    <th>FName</th>
    <th>LName</th>
    <th>Sex</th>
    <th>DOB</th>
    <th>regdate</th>
    <th>phone_cell</th>
    <th>Date</th>
    <th>Referral Source</th>

    </tr>";

    while ($row = $result->fetch_assoc()) {
 

        // Start row
        echo "<tr style='border: 1px solid black;'>";
    
        // Print each column value with CSS for borders

        echo "<td style='border: 1px solid black;'>" . $row['id'] . "</td>";
        echo "<td style='border: 1px solid black;'>" . $row['fname'] . "</td>";
        echo "<td style='border: 1px solid black;'>" . $row['lname'] . "</td>";
         echo "<td style='border: 1px solid black;'>" . $row['sex'] . "</td>";
         echo "<td style='border: 1px solid black;'>" . $row['DOB'] . "</td>";
         echo "<td style='border: 1px solid black;'>" . $row['regdate'] . "</td>";
         echo "<td style='border: 1px solid black;'>" . $row['phone_cell'] . "</td>";
         echo "<td style='border: 1px solid black;'>" . $row['date'] . "</td>";
         echo "<td style='border: 1px solid black;'>" . $row['referral_source'] . "</td>";



         
 
        echo "</tr>";
    }

 
    echo "</table>";

 
}
?>
