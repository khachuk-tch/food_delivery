


<?php
session_start();
session_unset();
session_destroy();

// Extra protection: prevent caching of previous page
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

header("Location: login.php");
exit();
?>
