<?php

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

$sql = "SELECT * FROM about ORDER BY id DESC LIMIT 1";
$result = $con->query($sql);

if ($result->rowCount() > 0) {
    // Output data of each row
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $title1 = $row["title"];
        $content1 = $row["content"];
        $title2 = $row["title2"];
        $content2 = $row["content2"];
        $image1 = $row["image"];
        $image2 = $row["image2"];
    }
} else {
    echo "0 results";
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



      <div class="site-section bg-light custom-border-bottom" data-aos="fade">
        <div class="container">
          <div class="row mb-5">
            <div class="col-md-6">
              <div class="block-16">
                <figure>
                  <img
                    src="admin/upload/about/<?php echo $image1; ?>" alt="Image placeholder" class="img-fluid rounded" />
                
                </figure>
              </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-5">
              <div class="site-section-heading pt-3 mb-4">
                <h2 class="text-black"><?php echo $title1; ?></h2>
              </div>
              <p>
                <?php echo wordwrap($content1, 100, "<br>\n", true); ?>
                    </p>

            
            </div>
          </div>
        </div>
      </div>

      <div class="site-blocks-cover inner-page d-flex align-items-center justify-content-center" style="background-image: url('images/a11.jpg'); width: 100%; height: auto;">

        <div class="container">
          <div class="row">
            <div class="col-lg-7 mx-auto align-self-center">
              <div class="text-center">
                <h1>About Us</h1>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      
      <div class="site-section bg-light custom-border-bottom" data-aos="fade">
        <div class="container">
          <div class="row mb-5">
            <div class="col-md-6 order-md-1">
              <div class="block-16">
                <figure>
                  <img
                    src="admin/upload/about/<?php echo $image2; ?>"
                    alt="Image placeholder"
                    class="img-fluid rounded"
                  />
                
                </figure>
              </div>
            </div>
            <div class="col-md-5 mr-auto">
              <div class="site-section-heading pt-3 mb-4">
                <h2 class="text-black"><?php echo $title2; ?></h2>
              </div>
              <p>
              <?php echo wordwrap($content2, 70, "<br>\n", true); ?>
                </p>

              
            </div>
          </div>
        </div>
      </div>
      <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i class="bi bi-arrow-up"></i></a>

      
     <?php include 'includes/footer.php'; ?>

    <!-- Back to Top -->
      
    </div>
    
  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>

  <script src="js/main.js"></script>

    <!-- Template Javascript -->
    <script src="js/doctor/main.js"></script>
  </body>
</html>
<?php $con = null; // Close the PDO connection
?>
