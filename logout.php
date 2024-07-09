<?php
session_start();

// Check if a session exists
if (isset($_SESSION["username"]) || isset($_SESSION["email"]) || isset($_SESSION["userId"])) {
  // Unset all session variables
  session_unset();

  // Destroy the session
  session_destroy();

  // Redirect to index.php
  header('location: index.php');
  exit();
} else {
  // Handle case where no session exists (optional: display message)
  echo "You are already logged out.";
}
?>