<?php
require_once "../database.php";

if (isset($_POST["create_now"])) {
    if (isset($_SESSION['user_id'])) {
        $user_id  = $_SESSION['user_id'];
        $email = $_POST["email"];
        $insertQuery = "INSERT INTO contact_group (user_id, email) VALUES (?, ?)";
        $insertStmt = $conn->prepare($insertQuery);

        // Use an array to pass parameters directly to bind_param
        $insertStmt->bind_param("ss", $user_id, $email);

        if ($insertStmt->execute()) {
            $_SESSION["success_message"] = "Email Insert Success.";
        } else {
            $_SESSION["fail_message"] = "Error: " . $insertStmt->error;
        }

        $insertStmt->close();

        // Store messages in temporary variables
        $successMessage = isset($_SESSION["success_message"]) ? $_SESSION["success_message"] : "";
        $failMessage = isset($_SESSION["fail_message"]) ? $_SESSION["fail_message"] : "";

        // Unset session variables
        unset($_SESSION["success_message"]);
        unset($_SESSION["fail_message"]);

        // Redirect to the original page with messages as parameters
        // header("Location: ".$_SERVER['HTTP_REFERER']."?success_message=$successMessage&fail_message=$failMessage");
        // exit();
        header("Location: ".$_SERVER['HTTP_REFERER']);
        exit();
    } else {
        $_SESSION["fail_message"] = "User not logged in.";
        header("Location: ".$_SERVER['HTTP_REFERER']);
        exit();
    }
}
?>
