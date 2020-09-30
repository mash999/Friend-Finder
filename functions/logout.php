
<?php
session_start();
session_destroy();
unset($_SESSION['f_finder_active_user']);
$_SESSION[] = array();
echo "<script>location.href = '../index.php?login';</script>";
die();
?>