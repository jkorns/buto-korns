<?php
session_start();

require_once 'includes/auth.php';
include_once 'includes/header.php';
require_once 'includes/login.php';
require_once 'includes/functions.php';

echo "<h1>Search the Database</h1>";

#Search Database by Name
if (isset($_GET['name'])) { //check if the form has been submitted
		$conn = new mysqli($hn, $un, $pw, $db);
		if ($conn->connect_error) die($conn->connect_error);
		$name = sanitizeMySQL($conn, $_GET['name']);
		$query = "SELECT * FROM person LEFT JOIN place ON person.birthplace=place_id WHERE CONCAT_WS('',fname,mname,lname) LIKE '%$name%'";
		$result = $conn->query($query);
		if (!$result) {
			die ("Database access failed: " . $conn->error);
		} else {
			$rows = $result->num_rows;
			if ($rows) {
				echo "<h2>Results</h2><table><tr><th>ID</th><th>Name</th><th>Sex</th><th>Date of Birth</th><th>City of Birth</th><th>State</th><th>Country</th></tr>";
				while ($row = $result->fetch_assoc()) {
					echo "<tr>";
					echo "<td>".$row["person_id"]."</td><td><a href=\"individuals.php?person_id=".$row["person_id"]."\">".$row["fname"]." ".$row["mname"]." ".$row["lname"]."</a></td><td>".$row["sex"]."</td><td>".$row["birthdate"]."</td><td>".$row["city"]."</td><td>".$row["state_province"]."</td><td>".$row["country"]."</td>";
					echo "</tr>";
				}
				echo "</table>";
			} else {
				echo "<p>No results!</p>";
			}
			echo "<h2>Search Again</h2>";
		}
	}

#Search Database by Location
if (isset($_GET['place'])) { //check if the form has been submitted
		$conn = new mysqli($hn, $un, $pw, $db);
		if ($conn->connect_error) die($conn->connect_error);
		$place = sanitizeMySQL($conn, $_GET['place']);
		$query = "SELECT pers1.person_id AS \"person_id\",pers1.fname AS \"fname\",pers1.mname AS \"mname\",pers1.lname AS \"lname\",plac1.city AS \"bcity\",plac1.state_province AS \"bstate\",plac1.country AS \"bcountry\",plac2.city AS \"dcity\",plac2.state_province AS \"dstate\",plac2.country AS \"dcountry\" FROM `person` AS pers1 LEFT JOIN place AS plac1 ON pers1.birthplace=plac1.place_id LEFT JOIN place AS plac2 ON pers1.deathplace=plac2.place_id WHERE CONCAT_WS('',plac1.city,plac1.state_province,plac1.country,plac2.city,plac2.state_province,plac2.country) LIKE '%$place%'";
		$result = $conn->query($query);
		if (!$result) {
			die ("Database access failed: " . $conn->error);
		} else {
			$rows = $result->num_rows;
			if ($rows) {
				echo "<h2>Results</h2><table><tr><th>ID</th><th>Name</th><th>Birth City</th><th>State</th><th>Country</th><th>Death City</th><th>State</th><th>Country</th></tr>";
				while ($row = $result->fetch_assoc()) {
					echo "<tr>";
					echo "<td>".$row["person_id"]."</td><td><a href=\"individuals.php?person_id=".$row["person_id"]."\">".$row["fname"]." ".$row["mname"]." ".$row["lname"]."</a></td><td>".$row["bcity"]."</td><td>".$row["bstate"]."</td><td>".$row["bcountry"]."</td><td>".$row["dcity"]."</td><td>".$row["dstate"]."</td><td>".$row["dcountry"]."</td>";
					echo "</tr>";
				}
				echo "</table>";
			} else {
				echo "<p>No results!</p>";
			}
			echo "<h2>Search Again</h2>";
		}
	}

#Search Database by Date
if (isset($_GET['year'])) { //check if the form has been submitted
		$conn = new mysqli($hn, $un, $pw, $db);
		if ($conn->connect_error) die($conn->connect_error);
		$year = sanitizeMySQL($conn, $_GET['year']);
		$query = "SELECT * FROM person WHERE YEAR(birthdate)<='$year' AND (YEAR(deathdate)>='$year' OR deathdate IS NULL)";
		$result = $conn->query($query);
		if (!$result) {
			die ("Database access failed: " . $conn->error);
		} else {
			$rows = $result->num_rows;
			if ($rows) {
				echo "<h2>Results</h2><table><tr><th>ID</th><th>Name</th><th>Sex</th><th>Date of Birth</th><th>Date of Death</th></tr>";
				while ($row = $result->fetch_assoc()) {
					echo "<tr>";
					echo "<td>".$row["person_id"]."</td><td><a href=\"individuals.php?person_id=".$row["person_id"]."\">".$row["fname"]." ".$row["mname"]." ".$row["lname"]."</a></td><td>".$row["sex"]."</td><td>".$row["birthdate"]."</td><td>".$row["deathdate"]."</td>";
					echo "</tr>";
				}
				echo "</table>";
			} else {
				echo "<p>No results!</p>";
			}
			echo "<h2>Search Again</h2>";
		}
	}

?>
<form method="get" action="search.php">
	<fieldset>
		<legend>Search by Name</legend>
		Name:<br><input type="text" name="name" required><br> 
		<input type="submit" name="submit">
	</fieldset>
</form>
<form method="get" action="search.php">
	<fieldset>
		<legend>Search by Location</legend>
		Location:<br><input type="text" name="place" required><br> 
		<input type="submit" name="submit">
	</fieldset>
</form>
<form method="get" action="search.php">
	<fieldset>
		<legend>Search by Year</legend>
		Year:<br><input type="text" name="year" required><br> 
		<input type="submit" name="submit">
	</fieldset>
</form>
</div>
<?php include_once 'includes/footer.php'; ?>