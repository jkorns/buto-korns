<footer>
<?php
if (isset($_SESSION['forename']) && isset($_SESSION['surname']) ) {
	echo "<h3>".$_SESSION['forename']." ".$_SESSION['surname']." is logged in";
	echo " | <small><a href=\"sign_out.php\">Logout</a></small></h3>";
	}
?>
</footer>
</body>
</html>