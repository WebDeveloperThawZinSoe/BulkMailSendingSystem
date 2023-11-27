<?php
require_once "../database.php";

if (isset($_POST["create_now"])) {
    if (isset($_SESSION['user_id'])) {
        $user_id  = $_SESSION['user_id'];
        $name = htmlspecialchars($_POST["name"]);
        $email =  htmlspecialchars($_POST["email"]);
        $passcode =  htmlspecialchars($_POST["password"]);
        // Check if the email already exists
        $checkEmailQuery = "SELECT id FROM sender_account WHERE sender_mail = ?";
        $checkEmailStmt = $conn->prepare($checkEmailQuery);
        $checkEmailStmt->bind_param("s", $email);
        $checkEmailStmt->execute();
        $result = $checkEmailStmt->get_result();

        if ($result->num_rows > 0) {
            // Email already exists
            $_SESSION["fail_message"] = "Email already exists. Please choose a different email";
            header("Location: ../user/sender_account.php");
            exit();
        } else {
            $insertQuery = "INSERT INTO sender_account (user_id, sender_name, sender_mail, sender_username, sender_password, created_by) VALUES (?,?,?,?,?,?)";
            $insertStmt = $conn->prepare($insertQuery);
    
            // Use an array to pass parameters directly to bind_param
            $insertStmt->bind_param("issssi", $user_id, $name, $email, $name, $passcode, $user_id);
    
            if ($insertStmt->execute()) {
                $_SESSION["success_message"] = "Sender  Account Create Success.";
            } else {
                $_SESSION["fail_message"] = "Error: " . $insertStmt->error;
            }
    
            $insertStmt->close();
    
            $successMessage = isset($_SESSION["success_message"]) ? $_SESSION["success_message"] : "";
            $failMessage = isset($_SESSION["fail_message"]) ? $_SESSION["fail_message"] : "";
    
            header("Location:../user/sender_account.php#userTable");
            exit();
        }

    } else {
        $_SESSION["fail_message"] = "User not logged in.";
        header("Location: ".$_SERVER['HTTP_REFERER']);
        exit();
    }
}

