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
    <link href='https://fonts.googleapis.com/css?family=Bungee' rel='stylesheet'>

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

 <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

  <div class="site-wrap">


  <?php
  session_start();

  include 'includes/header.php';
  ?>

    <div class="site-blocks-cover" style="background-image: url('images/hero_1.jpg');">
      <div class="container">
        <div class="row">
          <div class="col-lg-7 mx-auto order-lg-2 align-self-center">
            <div class="site-block-cover-content text-center">
              <h2 class="sub-title">Effective Medicine, New Medicine Everyday</h2>
              <h1 style="margin-left:10px;">Welcome To The E-Pharmacy & Care System</h1>
              <p>
                <a href="shop.php" class="btn btn-primary px-5 py-3">Shop Now</a>
                <a href="prescription.php" class="btn btn-primary px-5 py-3">Search By Image</a>

              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

   
    <div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
        <h1 style="font-family: 'Bungee'; font-size: 50px;color:#0267E3;">Common Medicines</h1>
        </div>
        <div class="row g-4">

            <?php
            include 'includes/config.php';
            $sql = "SELECT * FROM medicine limit 8";
            $result = mysqli_query($con, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) { ?>

            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.15s">
                <div class="team-item position-relative rounded overflow-hidden">
                    <a href="shop-single.php?id=<?php echo $row['medicineId']; ?>" class="d-block">
                        <div class="overflow-hidden">
                            <img class="img-fluid" src="admin/medicies/<?php echo $row['imageName']; ?>" alt="" style="height:350px; width:300px">
                        </div>
                        <div class="team-text bg-light text-center p-4">
                            <h3 class="text-dark"><?php echo $row['Name']; ?></h3>
                            <div class="team-social text-center">
                                <p class="price">₪<?php echo $row['price']; ?></p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <?php }
            } else {
                echo "0 results";
            }

            mysqli_close($con);
            ?>
        </div>
    </div>
</div>

        

<div class="site-section bg-light">
    <div class="container">
        <div class="row">
            <div class="title-section text-center col-12">
                <h2 class="text-uppercase">New Products</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 block-3 products-wrap">
                <div class="nonloop-block-3 owl-carousel">

                    <?php
                    include 'includes/config.php';

                    $sql = "SELECT * FROM medicine ORDER BY medicineId  DESC LIMIT 6";
                    $result = mysqli_query($con, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <div class="text-center item mb-4">
                        <a href="shop-single.php?id=<?php echo $row['medicineId']; ?>" class="d-block">
                            <img src="admin/medicies/<?php echo $row['imageName']; ?>" alt="Image" style="height:350px; width:300px">
                            <h3 class="text-dark"><?php echo $row['Name']; ?></h3>
                        </a>
                        <p class="price">₪<?php echo $row['price']; ?></p>
                    </div>
                    <?php }
                    } else {
                        echo "0 results";
                    }

                    mysqli_close($con);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>


    <?php include 'includes/footer.php'; ?>


   
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