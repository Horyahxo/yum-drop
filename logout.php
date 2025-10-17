<?php
session_start();
session_unset();
session_destroy();
header('location: Homepage_for_all_logIN.html');
exit;
?>
