<?php
session_start();

include_once 'includes/header.php';
require_once 'includes/login.php';
require_once 'includes/functions.php';

if (isset($_POST['submit'])) { //check if the form has been submitted
	if ( empty($_POST['username']) || empty($_POST['password']) ) {
		$message = '<p class="error">Please enter your username and password.</p>';
	} else {
		$conn = new mysqli($hn, $un, $pw, $db);
		if ($conn->connect_error) die($conn->connect_error);
		$username = sanitizeMySQL($conn, $_POST['username']);
		$password = sanitizeMySQL($conn, $_POST['password']);			
		$salt1 = "wk%m$";  
		$salt2 = "bd*h";  
		$password = hash('ripemd128', $salt1.$password.$salt2);
		$query  = "SELECT forename, surname FROM user WHERE username='$username' AND password='$password'"; 
		$result = $conn->query($query);    
		if (!$result) die($conn->error); 
		$rows = $result->num_rows;
		if ($rows==1) {
			$row = $result->fetch_assoc();
			$_SESSION['forename'] = $row['forename'];
			$_SESSION['surname'] = $row['surname'];
			$goto = empty($_SESSION['goto']) ? '/~jkorns/buto-korns/' : $_SESSION['goto'];			
			header('Location: ' . $goto);
			exit;			
		} else {
			$message = '<p class="error">Invalid username/password combination</p>';
		}
	}
}
?>

<?php 
include_once 'includes/header.php'; 
if (isset($message)) echo $message;
?>
<fieldset>
	<legend>Sign in</legend>
	<form method="POST" action="#">
	<script>document.querySelector("form").setAttribute("action", "")</script>
	Username:<br><input type="text" name="username" size="40"><br>
	Password:<br><input type="password" name="password" size="40"><br>
	<input type="submit" name="submit" value="Log-In">
	</form>
</fieldset>
</div>