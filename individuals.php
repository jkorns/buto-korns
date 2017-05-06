<?php
session_start();

require_once 'includes/auth.php';
include_once 'includes/header.php';
require_once 'includes/login.php';
require_once 'includes/functions.php';

$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die($conn->connect_error);

#Basic Person info and place of birth
if (isset($_GET['person_id'])) {
	$id = sanitizeMySQL($conn, $_GET['person_id']);
	$query = "SELECT * FROM person LEFT JOIN place ON person.birthplace=place_id WHERE person_id=".$id;
	$result = $conn->query($query);
	if (!$result) die ("Invalid person id.");
	$rows = $result->num_rows;
	if ($rows == 0) {
		echo "No person found with id of $id<br>";
	} else {
		while ($row = $result->fetch_assoc()) {
			echo '<h1>About '.$row["fname"]." ".$row["mname"]." ".$row["lname"].'</h1>';
			echo "<table><tr><th>Sex</th><th>Birthdate</th><th>City</th><th>State/Province</th><th>Country</th></tr>";
			#Each row of the result is fetched
				echo '<tr>';
				echo "<td>".$row["sex"]."</td><td>".$row["birthdate"]."</td><td>".$row["city"]."</td><td>".$row["state_province"]."</td><td>".$row["country"]."</td>";
				echo '</tr>';
			}
echo "</table>";
}

} else {
	echo "No person id passed";
}

#Marriage(s)
if (isset($_GET['person_id'])) {
	$id = sanitizeMySQL($conn, $_GET['person_id']);
	$query = "SELECT m1.spouse_id AS \"spouse_id\",p2.fname AS \"spouse-f\",p2.mname AS \"spouse-m\",p2.lname AS \"spouse-l\",m1.date_married AS \"date_married\" FROM `person` AS p1 INNER JOIN marriage AS m1 ON p1.person_id=m1.person_id INNER JOIN person AS p2 ON m1.spouse_id=p2.person_id WHERE p1.person_id=".$id;
	$result = $conn->query($query);
	if (!$result) die ("Invalid person id.");
	$rows = $result->num_rows;
	if ($rows == 0) {
	} else {
			echo "<h2>Marriage(s)</h2>";
						echo "<table><tr><th>Name</th><th>Marriage Date</th></tr>";
		while ($row = $result->fetch_assoc()) {
			#Each row of the result is fetched
				echo '<tr>';
				echo "<td><a href=\"individuals.php?person_id=".$row["spouse_id"]."\">".$row["spouse-f"]." ".$row["spouse-m"]." ".$row["spouse-l"]."</a></td><td>".$row["date_married"]."</td>";
				echo '</tr>';
			}
echo "</table>";
}
} 

#Death Information
if (isset($_GET['person_id'])) {
	$id = sanitizeMySQL($conn, $_GET['person_id']);
	$query = "SELECT * FROM person INNER JOIN place ON person.deathplace=place_id WHERE person_id=".$id;
	$result = $conn->query($query);
	if (!$result) die ("Invalid person id.");
	$rows = $result->num_rows;
	if ($rows == 0) {
	} else {
			echo "<h2>Death</h2>";
			echo "<table><tr><th>Date of Death</th><th>City</th><th>State/Province</th><th>Country</th></tr>";
			while ($row = $result->fetch_assoc()) {
			#Each row of the result is fetched
				echo '<tr>';
				echo "<td>".$row["deathdate"]."</td><td>".$row["city"]."</td><td>".$row["state_province"]."</td><td>".$row["country"]."</td>";
				echo '</tr>';
			}
echo "</table>";
}
}

#Parents
if (isset($_GET['person_id'])) {
	$id = sanitizeMySQL($conn, $_GET['person_id']);
	$query = "SELECT par1.parent_person_id AS \"parent1-id\",pers2.fname AS \"parent1-f\",pers2.mname AS \"parent1-m\",pers2.lname AS \"parent1-l\",par1.relationship AS \"relationship\" FROM `person` AS pers1 INNER JOIN parent AS par1 ON pers1.person_id=par1.person_id INNER JOIN person AS pers2 ON par1.parent_person_id=pers2.person_id WHERE pers1.person_id=".$id;
	$result = $conn->query($query);
	if (!$result) die ("Invalid person id.");
	$rows = $result->num_rows;
	if ($rows == 0) {
	} else {
			echo "<h2>Parents</h2>";
						echo "<table><tr><th>Name</th><th>Relationship to Person</th></tr>";
		while ($row = $result->fetch_assoc()) {
			#Each row of the result is fetched
				echo '<tr>';
				echo "<td><a href=\"individuals.php?person_id=".$row["parent1-id"]."\">".$row["parent1-f"]." ".$row["parent1-m"]." ".$row["parent1-l"]."</a></td><td>".$row["relationship"]."</td>";
				echo '</tr>';
			}
echo "</table>";
}
}

#Documents Authored
if (isset($_GET['person_id'])) {
	$id = sanitizeMySQL($conn, $_GET['person_id']);
	$query = "SELECT * FROM person JOIN document ON person.person_id=document.author_id WHERE person_id=".$id;
	$result = $conn->query($query);
	if (!$result) die ("Invalid person id.");
$rows = $result->num_rows;
if ($rows == 0) {
} else {
	echo "<h1>Documents Authored</h1>";
	echo "<table><tr><th>Download</th><th>Author</th><th>Title</th><th>Date</th><th>Type</th><th>Description</th></tr>";
	while ($row = $result->fetch_assoc()) {
	echo "<tr><td>";
	if (!empty($row["thumb_url"])) {
		echo "<a href=\"pdf_documents/".$row["doc_url"]."\"><img src=\"images/thumbnails/".$row["thumb_url"]."\" width=\"100\" alt=\"thumb_url\"></a>";		
	};
	echo "</td><td><a href=\"individuals.php?person_id=".$row["person_id"]."\">".$row["fname"]." ".$row["mname"]." ".$row["lname"]."</a></td><td>".$row["title"]."</td><td>".$row["date"]."</td><td>".$row["type"]."</td><td>".$row["description"]."</td>";
	echo '</tr>';
}

echo "</table>";
}
}
?>
</div>

<?php include_once 'includes/footer.php';?>

