<?php

session_start();

if (isset($_SESSION['userId'])) {
   

        $sender = $_SESSION['userId'];
        $receiver = $_GET['doctorId'];

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
        
        $userId = $_GET['doctorId'];
        $query = "SELECT * FROM doctor WHERE doctorId = :userId";
        
        try {
            $stmt = $con->prepare($query);
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();
            $user = $stmt->fetch();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }else
          header("Location: login.php");
    
        
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

<body>

 <!-- Spinner Start -->
 <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->
  <div class="site-wrap">


  <?php
  include 'includes/header.php'
  ?>

<div class="bg-light py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0">
            <a href="index.php">Home</a> <span class="mx-2 mb-0">/</span>
            <strong class="text-black">Ask The Doctor</strong>
          </div>
        </div>
      </div>
    </div>

    <div class="site-section">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <?php
          if (isset($_SESSION['messageSent'])) {
                echo "<div class='alert alert-success'>" . $_SESSION['messageSent'] . "</div>";
                unset($_SESSION['messageSent']);
            }
            
            if (isset($_SESSION['message_Error'])) {
              echo "<div class='alert alert-warning'>".$_SESSION['message_Error']. "</div>";
              unset($_SESSION['message_Error']);
          }?>
            
            
            <h2 class="h3 mb-5 text-black">Ask Dr. <?php echo $user['name'];?></h2>
          </div>
          <div class="col-md-12">
    
          <form action="sendDoctorMsg.php" method="post" enctype="multipart/form-data" style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
            <input type="number" value="<?php echo  $_SESSION['userId'];?>" name="sender" hidden >
            <input type="number"  value="<?php echo $receiver;?>" name="receiver"hidden >

              <div class="p-3 p-lg-5 border">
                <div class="form-group row">
                  <div class="col-md-12">
                  <img id="previewImage" class="rounded-circle mt-3" width="150px" height="150px" src="admin/user/<?php echo $user['doctorImage'];?>" alt="Profile Image">
                  </div>                 
                </div>
           
                   
                <div class="form-group row">
                  <div >
                    <textarea name="message" id="message" cols="109" rows="5" placeholder="Type your Message here" class="form-control"></textarea>
                  </div>

                </div>
                <div class="form-group row">

                <input class="form-control"  name="image" type="file" >
                </div>
                <br><br>
                <div class="form-group row">
                  <div class="col-lg-12">
                  <button type="submit" class="btn btn-primary ">
                     <i class="fa fa-paper-plane" aria-hidden="true"></i>  Send 
                  </button>
                  </div>
                </div>
              </div>
            </form>
          </div>
          
        </div>
      </div>
    </div>


<?php
include 'includes/footer.php'
?>

    
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
