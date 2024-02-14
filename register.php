<?php
include("config.php");
$error = "";
$msg = "";

if (isset($_POST['insert'])) {
    $adminName = $_POST['adminName'];
    $adminAddress = $_POST['adminAddress'];
    $adminPhone = $_POST['adminPhone'];
    $adminEmail = $_POST['adminEmail'];
    $adminPass = password_hash($_POST['adminPass'], PASSWORD_DEFAULT);

    if (!empty($adminName) && !empty($adminAddress) && !empty($adminPhone) && !empty($adminEmail) && !empty($adminPass)) {
        $imageName = "avatar-01.png";

        if (isset($_FILES['adminImage'])) {
            $image = $_FILES['adminImage'];
            $imageName = $image['name'];

            // Define the directory to save uploaded images
            $uploadDirectory = 'assets/img/';

            // Check if the directory exists; if not, create it
            if (!file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0777, true);
            }

            $imagePath = $uploadDirectory . $imageName;
            move_uploaded_file($image['tmp_name'], $imagePath);
        }

        $sql = "INSERT INTO Admin (adminName, adminAddress, adminPhone, adminEmail, adminPass, adminImage) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssssss", $adminName, $adminAddress, $adminPhone, $adminEmail, $adminPass, $imageName);

        if ($stmt->execute()) {
            $msg = 'Admin Registered Successfully';
        } else {
            $error = 'Error Registering Admin. Please Try Again';
        }
        $stmt->close();
    } else {
        $error = 'Please Fill All the Fields!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
        <meta name=viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Admin Dashboard - Register</title>
		
		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">

		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
		
		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">
		
		<!-- Main CSS -->
        <link rel="stylesheet" href="assets/css/style.css">
		
		<!--[if lt IE 9]>
			<script src="assets/js/html5shiv.min.js"></script>
			<script src="assets/js/respond.min.js"></script>
		<![endif]--></head>

<body>
    <!-- Main Wrapper -->
    <div class="page-wrappers login-body">
        <div class="login-wrapper">
            <div class="container">
                <div class="loginbox">
                    <div class="login-right">
                        <div class="login-right-wrap">
                            <h1>Register</h1>
                            <p class="account-subtitle">Access to our dashboard</p>
                            <p style="color:red;"><?php echo $error; ?></p>
                            <p style="color:green;"><?php echo $msg; ?></p>
                            <!-- Form -->
                            <form method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <input class="form-control" type="text" placeholder="adminName" name="adminName">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="text" placeholder="adminAddress" name="adminAddress">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="text" placeholder="admin Phone" name="adminPhone">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="password" placeholder="admin Password" name="adminPass" maxlength="20">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="email" placeholder="adminEmail" name="adminEmail" maxlength="50">
                                </div>

                                <div class="form-group">
                                    <input class="form-control" type="file" accept="image/*" name="adminImage">
                                </div>
                                <div class="form-group mb-0">
                                    <input class="btn btn-primary btn-block" type="submit" name="insert" value="Register">
                                </div>
                            </form>
                            <!-- /Form -->

                            <div class="text-center dont-have">Already have an account? <a href="index.php">Login</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Main Wrapper -->

    <!-- jQuery -->
    <script src="assets/js/jquery-3.2.1.min.js"></script>

    <!-- Bootstrap Core JS -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Custom JS -->
    <script src="assets/js/script.js"></script>

</body>

</html>
