<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "../database.php";
require '../vendor/autoload.php';

if (isset($_POST["send_all_now"])) {
    $user_id = $_SESSION["user_id"];
    $subject = $_POST["subject"];
    $body = $_POST["body"];

    // Prepare a SQL statement
    $sql = "SELECT * FROM contact_group WHERE user_id = ?";

    // Create a prepared statement
    $stmt = $conn->prepare($sql);

    // Bind the parameter
    $stmt->bind_param("i", $user_id);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Loop through each row in the result set
        while ($row = $result->fetch_assoc()) {
            // Access the data for each row
        
            $email = $row['email'];

            // Send email
            $to = $email;  
            $subject = $subject;
            $message = $body;
            $gmail_username = 'apexmmweb@gmail.com';
            $gmail_password = 'hqyo iohu jowm nayy '; 

        
            $mail = new PHPMailer(true);
    
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = $gmail_username;
                $mail->Password = $gmail_password;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;
            
                // Recipients
                $mail->setFrom($gmail_username, 'Thaw Zin Soe');
                $mail->addAddress($to);
            
                // Content
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body = $message;
            
                // Send the email
                $mail->send();
                echo 'Email has been sent successfully.';
            } catch (Exception $e) {
                echo "Failed to send email. Error: {$mail->ErrorInfo}<br>";
            }
           

    
        }
    } else {
        echo "No results found.";
    }
    
    // Close the statement and the database connection
    $stmt->close();
    $conn->close();

}