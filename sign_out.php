<?php
session_start();
$_SESSION = array();
session_destroy();

include_once 'includes/header.php';
echo "<p>You are now logged out.</p>";
echo "<p><a href=\"index.php\">Return to log-in page</a></p>";
?>
</div>
<?php include_once 'includes/footer.php'; ?>