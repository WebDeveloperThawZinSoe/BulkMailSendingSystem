<?php
require_once "header.php";

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


                <!-- Current Credit -->

                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Current Credit Points</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <?php
                                    $user_id = $_SESSION["user_id"];
                                    // Prepare a SQL statement
                                    $sql = "SELECT * FROM user WHERE id = ?";

                                    // Create a prepared statement
                                    $stmt = $conn->prepare($sql);

                                    // Bind the parameter
                                    $stmt->bind_param("i", $user_id);

                                    // Execute the statement
                                    $stmt->execute();

                                    // Get the result
                                    $result = $stmt->get_result();

                                    // Check if a row was returned
                                    if ($result->num_rows > 0) {
                                        // Fetch the data
                                        $row = $result->fetch_assoc();
                                        $credit = $row["credit"];
                                        echo $credit;
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>


                <br>

                <!-- Contact Form -->
                <form id="userForm" action="../function/sending_mail.php" method="POST">

                    <div class="form-group">
                        <label for="target">Target:</label>
                        <?php
                        $user_id = $_SESSION["user_id"];
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


                        ?>
                        <input type="text" class="form-control" id="target" name="target" value="All User ( <?php echo $result->num_rows ?> )" disabled>
                    </div>

                    <div class="form-group">
                        <label for="sender">Sender:</label>
                        <input type="text" class="form-control" id="sender" name="sender" required>
                    </div>

                    <div class="form-group">
                        <label for="subject">Subject :</label>
                        <input type="text" class="form-control" id="subject" name="subject" required>
                    </div>

                    <div class="form-group">
                        <label for="body">Body :</label>
                        <textarea class="form-control" id="body" name="body" required></textarea>
                    </div>

                    <input type="submit" class="btn btn-primary" name="send_all_now" value="Send">
                </form>
                <br>
                <hr> <br>
                <!-- Contact List -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->
        <script>
            CKEDITOR.replace('body');
        </script>
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
    $(document).ready(function() {
        $('#userTable').DataTable();
    });
</script>


<?php
require_once "footer.php";
?>