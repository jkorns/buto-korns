<?php
session_start();

require_once 'includes/auth.php';
include_once 'includes/header.php';
require_once 'includes/login.php';

#Connect to MySQL server
$conn = new mysqli($hn, $un, $pw, $db);
#If connect_error has a value, then there was an error, so call the die function
if ($conn->connect_error) die($conn->connect_error);

#MySQL query
$query = "SELECT * FROM person LEFT JOIN place ON person.birthplace=place_id ORDER BY ISNULL(birthdate),birthdate ASC";
#Result of MySQL query
$result = $conn->query($query);
#If $result is false, there was a problem, so call the die function
if (!$result) die ("Database access failed: " . $conn->error);

#The number of rows in the result
$rows = $result->num_rows;

echo "<h1>Family Members in the Database</h1>";
#Print table of results
echo "<table><tr><th>ID</th><th>Name</th><th>Sex</th><th>Date of Birth</th><th>City of Birth</th><th>State</th><th>Country</th></tr>";
#Each row of the result is fetched
while ($row = $result->fetch_assoc()) {
	echo '<tr>';
	echo "<td>".$row["person_id"]."</td><td><a href=\"individuals.php?person_id=".$row["person_id"]."\">".$row["fname"]." ".$row["mname"]." ".$row["lname"]."</a></td><td>".$row["sex"]."</td><td>".$row["birthdate"]."</td><td>".$row["city"]."</td><td>".$row["state_province"]."</td><td>".$row["country"]."</td>";
	echo '</tr>';
}

echo "</table>";
?>
</div>
<?php include_once 'includes/footer.php'; ?>
