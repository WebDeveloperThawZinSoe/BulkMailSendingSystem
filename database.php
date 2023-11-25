<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Database configuration
$servername = "localhost"; 
$username = "root";
$password = "";
$database = "mail_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Sweet Alert 2

// Check if there is a registration message in the session
if (isset($_SESSION["fail_message"])) {
    echo "<script>
            // Display SweetAlert2 message
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '" . $_SESSION["fail_message"] . "',
            });
          </script>";

    // Remove the session variable to avoid displaying the message again
    unset($_SESSION["fail_message"]);
}

if (isset($_SESSION["success_message"])) {
    echo "<script>
            // Display SweetAlert2 message
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '" . $_SESSION["success_message"] . "',
            });
          </script>";

    // Remove the session variable to avoid displaying the message again
    unset($_SESSION["success_message"]);
}
?>
