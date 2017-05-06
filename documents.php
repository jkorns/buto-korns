<?php
session_start();

require_once 'includes/auth.php';
include_once 'includes/header.php';
require_once 'includes/login.php';

$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die($conn->connect_error);

#MySQL query
$query = "SELECT * FROM person JOIN document ON person.person_id=document.author_id ORDER BY date ASC";
#Result of MySQL query
$result = $conn->query($query);
#If $result is false, there was a problem, so call the die function
if (!$result) die ("Database access failed: " . $conn->error);

#The number of rows in the result
$rows = $result->num_rows;

echo "<h1>Family Documents</h1>";
echo "<table><tr><th>Download</th><th>Author</th><th>Title</th><th>Date</th><th>Type</th><th>Description</th></tr>";
#Each row of the result is fetched
while ($row = $result->fetch_assoc()) {
	echo "<tr><td>";
	if (!empty($row["thumb_url"])) {
		echo "<a href=\"pdf_documents/".$row["doc_url"]."\"><img src=\"images/thumbnails/".$row["thumb_url"]."\" width=\"100\" alt=\"thumb_url\"></a>";		
	};
	
	echo "</td><td><a href=\"individuals.php?person_id=".$row["person_id"]."\">".$row["fname"]." ".$row["mname"]." ".$row["lname"]."</a></td><td>".$row["title"]."</td><td>".$row["date"]."</td><td>".$row["type"]."</td><td>".$row["description"]."</td>";
	echo '</tr>';
}

echo "</table>";

?>
</div>
<?php include_once 'includes/footer.php'; ?>