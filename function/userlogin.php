<?php
require_once "../database.php";


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

   
    // Check if the user exists
    $checkUserQuery = "SELECT id, email, password FROM user WHERE email = ? AND  type=2";
    $checkUserStmt = $conn->prepare($checkUserQuery);
    $checkUserStmt->bind_param("s", $username);
    $checkUserStmt->execute();
    $result = $checkUserStmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (md5($password) == $user['password']) {
            // Password is correct, start the session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['email'];
            $_SESSION['normal_user_role'] = "YES";

            // Redirect to a protected page or homepage

            $_SESSION["success_message"] = "Login Success";
            header("Location: ../user/index.php");
            exit();
        } else {
            $_SESSION["fail_message"] = "Invalid password";
            header("Location: ../login.php");
            exit();
        }
    } else {
        $_SESSION["fail_message"] = "User Not Found";
        header("Location: ../login.php");
        exit();
    }

    $checkUserStmt->close();
    $conn->close();
}
?>
