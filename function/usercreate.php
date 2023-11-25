<?php
require_once "../database.php";

/* Create User Code When Register From Register Form */
if (isset($_POST["register"])) {
    /* Check password and Confirm password */
    if ($_POST["password"] == $_POST["c_password"]) {
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = md5($_POST["password"]);

        // Check if the email already exists
        $checkEmailQuery = "SELECT * FROM user WHERE email = ?";
        $checkEmailStmt = $conn->prepare($checkEmailQuery);
        $checkEmailStmt->bind_param("s", $email);
        $checkEmailStmt->execute();
        $result = $checkEmailStmt->get_result();

        if ($result->num_rows > 0) {
            // Email already exists
            $_SESSION["fail_message"] = "Email already exists. Please choose a different email";
            header("Location: ../register.php");
            exit();
        } else {
            // Email does not exist, proceed with registration
            $insertQuery = "INSERT INTO user (name, email, password) VALUES (?, ?, ?)";
            $insertStmt = $conn->prepare($insertQuery);

            // Use an array to pass parameters directly to bind_param
            $insertStmt->bind_param("sss", $username, $email, $password);

            if ($insertStmt->execute()) {
                $_SESSION["success_message"] = "Register Success. Please Login .";
                header("Location: ../login.php");
                exit();
            } else {
                $_SESSION["fail_message"] = "Error:  $insertStmt->error";
                header("Location: ../register.php");
                exit();
            }

            $insertStmt->close();
        }
        $checkEmailStmt->close();
    } else {
        $_SESSION["fail_message"] = "Passwords do not match!";
        header("Location: ../register.php");
        exit();
    }
}
?>
