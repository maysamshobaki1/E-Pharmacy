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
    function confirmAddToCart() {
        var confirmation = confirm("Are you sure to add this item to the cart?");
        return confirmation;
    }
</script>
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
  include 'includes/config.php';

  $cid = $_GET['id'];
  $sql = "SELECT * FROM medicine WHERE medicineId  = '$cid'";
  $result = mysqli_query($con, $sql);

  if (!$result) {
      die('Error in SQL query: ' . mysqli_error($con));
  }

  $medicineData = mysqli_fetch_assoc($result);

  mysqli_close($con);
  ?>

  

    <div class="bg-light py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0"><a href="index.php">Home</a> <span class="mx-2 mb-0">/</span> <a
              href="shop.php">Store</a> <span class="mx-2 mb-0">/</span> <strong class="text-black"><?php echo $medicineData['Name']; ?></strong></div>
        </div>
      </div>
    </div>

    <div class="site-section">
      <div class="container">
      <form action="add_to_cart.php" method="POST" onsubmit="return confirmAddToCart();">
        <?php if (isset($_SESSION['add_to_cart_msg'])) {
            echo $_SESSION['add_to_cart_msg'];
            unset($_SESSION['add_to_cart_msg']);
        } ?>
        <div class="row">
          <div class="col-md-5 mr-auto">
            <div class="border text-center">
              <img src="admin/medicies/<?php echo $medicineData['imageName']; ?>" alt="Image" class="img-fluid p-5">
            </div>
          </div>
          
          <div class="col-md-6">
            <h2 class="text-black"><?php echo $medicineData['Name']; ?></h2>
            <p><?php echo $medicineData['Description']; ?></p>
            
            <p> <strong class="text-primary h4"><?php echo $medicineData['price']; ?> </strong> ₪ </p>
            <p> <strong class="text-primary h4">Quantity : <?php echo $medicineData['quantity']; ?> </strong></p>

            <?php if ($medicineData['quantity'] > 0) : ?>
    <div class="mb-5">
    <div class="input-group mb-3" style="max-width: 220px;">
                <div class="input-group-prepend">
                  <button class="btn btn-outline-primary js-btn-minus" type="button">&minus;</button>
                </div>
                <input type="number" class="form-control text-center" value="1" min="1" placeholder="" name="quantity" aria-describedby="button-addon1" required>
                <div class="input-group-append">
                  <button class="btn btn-outline-primary js-btn-plus" type="button">&plus;</button>
                </div>

              </div>
    </div>
    <button type="submit" class="buy-now btn btn-sm height-auto px-4 py-3 btn-primary" id="addToCartBtn" >Add To Cart</button>

  <?php else : ?>
    <p class="text-danger">Out of Stock</p>
  <?php endif; ?>
            <div class="mb-5">
              

            </div>
            <input type="number" name="medicineId" value="<?php echo $medicineData['medicineId']; ?>" hidden>
            <input type="number"  name="userId" value="<?php echo isset($$_SESSION['userId']) ? $$_SESSION['userId'] : 0; ?>" hidden >

          </div>
        </div>
</form>
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
  <script src="js/doctor/main.js"></script>
</body>

</html>