<?php
session_start();
session_unset();
session_destroy();
header("Location: http://localhost/gaming_corner/HomePage.php");
exit;
?>