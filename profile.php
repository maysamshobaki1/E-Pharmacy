<?php
session_start(); // Start the session

if (!isset($_SESSION['userId'])) {
    // If userId is not set, navigate to the login page
    header("Location: login.php");
    exit();
}

$dsn = "mysql:host=localhost;dbname=projectdb";
$user = "root";
$pass = "";
$option = [
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8",
];

try {
    $con = new PDO($dsn, $user, $pass, $option);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}

// Fetch user data based on userId from your database
$userId = $_SESSION['userId'];
// Replace with your database query
$query = "SELECT * FROM users WHERE userId = :userId";

try {
    $stmt = $con->prepare($query);
    $stmt->bindParam(':userId', $userId);
    $stmt->execute();
    $user = $stmt->fetch();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">


<head>
  <title>E-Pharmacy & Care</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

   <!-- Google Web Fonts -->
   <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Roboto:wght@500;700;900&display=swap" rel="stylesheet"> 

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/doctor/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/doctor/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,700|Crimson+Text:400,400i" rel="stylesheet">
  <link rel="stylesheet" href="fonts/icomoon/style.css">

  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/magnific-popup.css">
  <link rel="stylesheet" href="css/jquery-ui.css">
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">


  <link rel="stylesheet" href="css/aos.css">

  <link rel="stylesheet" href="css/style.css">

</head>
<script>
    const imageUpload = document.getElementById('imageUpload');
    const previewImage = document.getElementById('previewImage');

    previewImage.addEventListener('click', function () {
      imageUpload.click();
    });

    imageUpload.addEventListener('change', function () {
      if (imageUpload.files && imageUpload.files[0]) {
        const reader = new FileReader();

        reader.onload = function (e) {
          previewImage.src = e.target.result;
        };

        reader.readAsDataURL(imageUpload.files[0]);
      }
    });
  </script>

<body>


  <div class="site-wrap">
  <div class="site-wrap">


  <?php include 'includes/header.php'; ?>

<div class="bg-light py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0">
            <a href="index.php">Home</a> <span class="mx-2 mb-0">/</span>
            <strong class="text-black">Profile</strong>
          </div>
        </div>
      </div>
    </div>

    <div class="site-section">
      <div class="container">
        <div class="row">
          
          <div class="col-md-12">
    
            <form  action="UpdateProfile.php" method="POST" enctype="multipart/form-data"  style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
    
              <div class="p-3 p-lg-5 border">
              <div class="form-group row justify-content-center">
              <div class="col-md-12 text-center">
                  <input type="file" id="imageUpload" name="imgName" accept="image/*" style="display: none;">
                  <img id="previewImage" class="rounded-circle mt-3" width="200px"
                      src="admin/user/<?php echo $user['imgName']; ?>" alt="Profile Image"><br />

                  <label for="imageUpload" class="text-black" style="cursor: pointer;"><b>Click Here to Change Profile
                          Image</b></label>
              </div>
          </div>

                <div class="form-group row justify-content-center">
                  <div class="col-md-6">
                    <label for="fullName" class="text-black"> <i class="far fa-address-book" style="color:#036176;"></i>  Full Name </label>
                    <input type="text" class="form-control" id="fullName" value="<?php echo $user['name']; ?>" name="name">
                  </div>
                 
                </div>
                <div class="form-group row justify-content-center">
                  <div class="col-md-6">
                    <label for="phone" class="text-black"><i class="fas fa-mobile-alt" style="color:#036176;"></i> Phone Number</label>
                    <input type="number" class="form-control" id="phone" value="<?php echo $user['phone']; ?>" name="phone" placeholder="">
                  </div>
                </div>
                <div class="form-group row justify-content-center">
                  <div class="col-md-6">
                    <label for="address" class="text-black"><i class="fa fa-location-arrow" style="color:#036176;"></i> Address </label>
                    <input type="text" class="form-control" id="address"  value="<?php echo $user['address']; ?>" name="address">
                  </div>
                </div>
    
                <div class="form-group row justify-content-center">
                  <div class="col-md-6">
                    <label for="email" class="text-black"><i class="fas fa-envelope" style="color:#036176;"></i> Email </label>
                    <input name="email" id="message" type="email" value="<?php echo $user['email']; ?>" class="form-control"></input>
                  </div>
                </div>
                <br><br>
                <div class="form-group row justify-content-center">
                  <div class="col-md-6">
                  <input type="submit" class="btn btn-primary btn-lg btn-block" name="updateInfo" value="Update Info">
                   </div>
                  
                </div>

              </div>

            </form>
          </div>
          
        </div>
      </div>
    </div>


<?php include 'includes/footer.php'; ?>

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i class="bi bi-arrow-up"></i></a>

    
  </div>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>

  <script src="js/main.js"></script>
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/doctor/main.js"></script>

</body>

</html>