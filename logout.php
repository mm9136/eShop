<?php
	session_start();
	unset($_SESSION['email']);
    unset($_SESSION['role']);
    header('Refresh: 1; URL = index.php');
?>