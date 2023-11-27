<?php
require_once "header.php";
// Check if there is a registration message in the session
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
                <form id="userForm" action="../function/sendercreate.php" method="POST">

                    <div class="form-group">
                        <label for="name">Name <span style="color:red"> * </span> </label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>


                    <div class="form-group">
                        <label for="email">Google Email <span style="color:red"> * </span> :</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="passcode">Two Factor App Pass Code  <span style="color:red"> * </span>:</label>
                        <input type="text" class="form-control" id="passcode" name="password" placeholder="Not Your Google Account Password .... " required>
                    </div>

                    <div class="form-group">
                        <label for="host">Sender Host :</label>
                        <input type="text" class="form-control" id="passcode" name="host" placeholder="Optional" value="smtp.gmail.com" readonly disabled>
                    </div>

                    <div class="form-group">
                        <label for="port">Sender Host Port :</label>
                        <input type="text" class="form-control" id="port" name="port" placeholder="Optional" value="465" readonly disabled>
                    </div>

                    <a target="_blank" href="https://support.google.com/accounts/answer/1066447?hl=en&co=GENIE.Platform%3DAndroid" style="color:red"> How To Get Google 2Factor App Pass Code ?</a><br><br>
                    <input type="submit" class="btn btn-primary" name="create_now" value="Submit">
                </form>
                <br>
                <hr> <br>
                <!-- Contact List -->
                <table id="userTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
            <?php 
                if (isset($_SESSION['user_id'])) {
                    $user_id = $_SESSION['user_id'];

                    // Fetch data from database
                    $query = "SELECT id,sender_name,sender_mail FROM sender_account WHERE user_id = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $number = 0;
                    // Loop through the results and display them in the tbody
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . ++$number . "</td>";
                        echo "<td>" . $row['sender_name']. "</td>";
                        echo "<td>" . $row['sender_mail'] . "</td>";
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