<?php
// 1. Start or resume the session
// This is crucial to be able to access and then destroy the session.
session_start();

// 2. Unset all of the session variables.
// This clears all data stored in the session.
$_SESSION = array();

// 3. Destroy the session.
// This completely removes the session itself.
if (session_destroy()) {
    // 4. If session destruction is successful, redirect to the login page.
    // Make sure 'login.view.php' is the correct path to your login page.
    header("Location: login.view.php");
    exit; // It's important to call exit() after a header redirect.
} else {
    // Optional: Handle the case where session destruction fails, though it's rare.
    echo "Error: Could not log out. Please try again.";
    // You might want to log this error or redirect to an error page.
}
?>