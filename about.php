<?php
session_start();

require_once 'includes/auth.php';
include_once 'includes/header.php';
require_once 'includes/login.php';

$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die($conn->connect_error);

echo "<h1>About</h1>";
echo "<p>This project began in 1996 as a grade school genealogy assignment. I worked with living relatives to collect information about family members going back four generations on both sides of my family. As part of this project, numerous living relatives contributed written autobiographies, family narratives, and/or their time for interviews, which were transcribed. This website is comprised of the data collected as part of this project as well as PDFs of documents contributed by family members.</p>";
echo "<p>Many thanks to all those who contributed to this project!</p>";
?>

</div>
<?php include_once 'includes/footer.php'; ?>

