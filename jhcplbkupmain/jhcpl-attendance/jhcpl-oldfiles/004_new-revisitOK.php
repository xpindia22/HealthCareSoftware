<!DOCTYPE html>
<html lang="en">
<head>
<style>
table {
  border-collapse: collapse;
  width: 100%;
  background-color: #f2f2f2; /* light gray */
}

th, td {
  border: 1px solid #ddd; /* light gray */
  padding: 8px;
  background-color: #add8e6; /* light blue */
}

tr:nth-child(even) {
  background-color: #ddd; /* darker gray for every other row */
}
.body-class{
            margin: 50px;
        }
</style>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body class='body-class'>

<?php
require 'header-jhcpl.php';
require_once 'conn.php';

$unit_no = ''; // Define $unit_no here
$name = ''; // Define $name here
$age = ''; // Define $age here
$sex = ''; // Define $sex here
$mobile = ''; // Define $mobile here
$salary = '';
$designation = ''; // Define $diagnosis here
$leaves_allowed = '';
$leaves_taken = '';
$deductions = '';
$salary_final = '';
// Fetch all unit_no from the attendance table
$sql = "SELECT DISTINCT unit_no  FROM attendance ORDER BY unit_no DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  echo "<form method='post' action=''>
  <select name='unit_no'>
  <option value=''>Select unit_no</option>";
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo "<option value='".$row["unit_no"]."'>".$row["unit_no"]."</option>";
  }
  echo "</select>
  <input type='submit' name='submit' value='Fetch Employee Records' />
  </form>";
} else {
  echo "No unit_no found";
}

// If form is submitted, fetch records for the selected unit_no
if (isset($_POST['submit'])) {
  $unit_no = $_POST['unit_no'];
 
  // Fetch user info for the selected unit_no
  $sql = "SELECT name, age, sex, mobile, designation, salary,leaves_allowed FROM attendance WHERE unit_no = '$unit_no'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $attendance = $result->fetch_assoc();
    $name = $attendance['name'];
    $age = $attendance['age'];
    $sex = $attendance['sex'];
    $mobile = $attendance['mobile'];
    $designation = $attendance['designation'];
    $salary = $attendance['salary'];
    $leaves_allowed = $attendance['leaves_allowed'];
  } else {
    echo "No user info found for unit_no: $unit_no";
  }
}

// Display the "Add Employee Record" form regardless of previous visits
echo "<h2>Employee Record for unit_no: $unit_no </h2>
  
<table class='table'> <form method='post' action=''>
    <tr>
      <th><label for='unit_no'>Unit No:</label></th>
      <td><input type='text' id='unit_no' name='unit_no' value='$unit_no' readonly></td>
    </tr>
    <tr>
      <th><label for='name'>Employee Name:</label></th>
      <td><input type='text' id='name' name='name' value='$name'></td>
    </tr>
    <tr>
      <th><label for='age'>Age:</label></th>
      <td><input type='text' id='age' name='age' value='$age'></td>
    </tr>
    <tr>
      <th><label for='sex'>Sex:</label></th>
      <td><input type='text' id='sex' name='sex' value='$sex'></td>
    </tr>
    <tr>
      <th><label for='mobile'>Mobile:</label></th>
      <td><input type='text' id='mobile' name='mobile' value='$mobile'></td>
    </tr>
    <tr>
      <th><label for='designation'>Designation:</label></th>
      <td><input type='text' id='designation' name='designation' value='$designation'></td>
    </tr>
    <tr>
    <th><label for='salary'>Salary:</label></th>
    <td><input type='number' id='salary' name='salary' value='$salary'></td>
    </tr>

    <tr>
    <th><label for='leaves_allowed'>Leaves Allowed:</label></th>
    <td><input type='number' id='leaves_allowed'  name='leaves_allowed'  value='$leaves_allowed'></td>
  </tr>
  <tr>
  <th><label for='leaves_taken'>leaves_taken:</label></th>
  <td><input type='number' id='leaves_taken' name='leaves_taken' value='0'></td>
  </tr>
  <tr>
  <th><label for='deductions'>Deductions:</label></th>
  <td><input type='number' id='deductions' name='deductions' value='0'></td>
  </tr>

  <tr>
  <th><label for='salary_final'>salary_final:</label></th>
  <td><input type='number' id='salary_final' name='salary_final' value='0'></td>
  </tr>
    <tr>
      <th><label for='date'>Date:</label></th>
      <td><input type='date' id='date' name='date'></td>
    </tr>
    <tr>
      <td colspan='2'><input type='submit' name='add' value='Add Emplyee Details'></td>
    </tr>
</form></table>";

if (isset($_POST['add'])) {
    
    $unit_no = $_POST['unit_no'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $sex = $_POST['sex'];
    $mobile = $_POST['mobile'];
    $designation = $_POST['designation'];
    $date = $_POST['date'];
    $salary = $_POST['salary'];
    $leaves_allowed = $_POST['leaves_allowed'];
    $leaves_taken = $_POST['leaves_taken'];
    $salary_final = $_POST['salary_final'];
    $deductions = $_POST['deductions'];
    $salary_final = $_POST['salary_final'];
    $sql = "INSERT INTO attendance_record (name, unit_no, age, sex, mobile, designation, date, salary,leaves_allowed, leaves_taken,deductions, salary_final) VALUES ('$name', '$unit_no', '$age', '$sex', '$mobile', '$designation', '$date','$salary','$leaves_allowed','$leaves_taken','$deductions','$salary_final')";

    if ($conn->query($sql) === TRUE) {
       echo "<br>Employee Mr/Ms  $name, Unit No: $unit_no On $date created successfully.</br>";
       //echo "<a href="https://www.example.com">Link text</a> ";
         } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
?>
<a href="/jhcpl-attendance/005_visitsAddEdit.php"> Click Here To Edit The Record</a>
</body>
</html>
