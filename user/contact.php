<?php
require_once "header.php";
// $successMessage = isset($_GET['success_message']) ? $_GET['success_message'] : '';
// $failMessage = isset($_GET['fail_message']) ? $_GET['fail_message'] : '';

// // Display messages if they are not empty
// if (!empty($successMessage)) {
//     echo "<script>
//             // Display SweetAlert2 message
//             Swal.fire({
//                 icon: 'error',
//                 title: 'Error',
//                 text: '" . $successMessage . "',
//             });
//           </script>";
// }

// if (!empty($failMessage)) {
//     echo "<script>
//     // Display SweetAlert2 message
//     Swal.fire({
//         icon: 'error',
//         title: 'Error',
//         text: '" . $failMessage . "',
//     });
//   </script>";
// }

?>

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Nav -->
    <?php
    require_once "nav.php";
    ?>
    <!-- End of Nav -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <?php
            require_once "topbar.php";
            ?>

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Contact Form -->
                <form id="userForm" action="../function/contactcreate.php" method="POST">

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <input type="submit" class="btn btn-primary" name="create_now" value="Submit">
                </form>
                <br>
                <hr> <br>
                <!-- Contact List -->
                <table id="userTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
            <?php 
                if (isset($_SESSION['user_id'])) {
                    $user_id = $_SESSION['user_id'];

                    // Fetch data from database
                    $query = "SELECT id, email FROM contact_group WHERE user_id = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $number = 0;
                    // Loop through the results and display them in the tbody
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . ++$number . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td><button class='btn btn-sm btn-danger'>Delete</button></td>"; // Customize as needed
                        echo "</tr>";
                    }
                }
            ?>
</tbody>

                </table>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <?php
        require_once "credit.php";
        ?>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<script>
        $(document).ready(function () {
            $('#userTable').DataTable();
        });
    </script>


<?php
require_once "footer.php";
?>