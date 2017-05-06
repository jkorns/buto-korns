<?php
session_start();

require_once 'includes/auth.php';
include_once 'includes/header.php';
require_once 'includes/login.php';

$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die($conn->connect_error);

echo "<h1>Welcome to the Buto-Korns Family Database</h1>";
echo "<img src=\"images/tree.jpg\" alt=\"tree\">";
#echo "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam id nibh nec velit tempus dignissim. Fusce vitae condimentum ligula. Morbi varius hendrerit orci eu ultrices. Donec gravida nulla quis sapien malesuada suscipit. Duis placerat magna vitae mauris semper, eu vehicula ipsum feugiat. Vestibulum vulputate leo libero, at condimentum enim iaculis vitae. Proin rhoncus justo felis, posuere porta nisl malesuada vel. Quisque sit amet dui nec odio molestie lobortis sed at magna.</p>";

?>
</div>
<?php include_once 'includes/footer.php'; ?>
