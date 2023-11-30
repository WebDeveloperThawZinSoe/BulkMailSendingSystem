<?php 
    require_once "../database.php";
    
    // Check if the user is logged in
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // Fetch data from database
        $query = "SELECT email FROM contact_group WHERE user_id = $user_id";
        $result = $conn->query($query);

        // Output CSV headers
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="contact_list.csv"');

        // Create a file pointer connected to the output stream
        $output = fopen('php://output', 'w');

        // Output the CSV column headers
        fputcsv($output, ['Email']);

        // Output each row of the data
        while ($row = $result->fetch_assoc()) {
            fputcsv($output, $row);
        }

        // Close the database connection
        $conn->close();

        // Redirect back to the page from where the export was initiated
       // $_SESSION["success_message"] = "Export Success";
        // header('Location: ../user/contact.php');
        //exit(); // Ensure that no further code is executed after the redirect
    } else {
        // Handle the case where the user is not logged in
        // You may want to redirect to a login page or display an error message
        $_SESSION["fail_message"] = "Login First";
        header('Location: login.php');
        exit();
    }
?>
