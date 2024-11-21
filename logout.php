<?php
session_start();

// Destroy session to log out the user
session_unset();
session_destroy();

// Redirect to user_account (or homepage)
header("Location: user_account.html"); // You can also redirect to the homepage
exit();
?>
