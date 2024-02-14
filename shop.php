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

  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>

 <script>
    $(document).ready(function () {
        $("#applyFilter").click(function () {
            var minPrice = $("#minPrice").val();
            var maxPrice = $("#maxPrice").val();

            $.ajax({
                type: "POST",
                url: "filter.php",
                dataType: 'json', 
                data: { minPrice: minPrice, maxPrice: maxPrice },
                success: function (response) {
                    $(".existing-products").html(response.products);
                    $(".main-pagination").hide(); 
                    $(".filtered-pagination").html(response.pagination).show();
                },
                error: function (error) {
                    console.error("Error in AJAX request:", error);
                }
            });
        });
    });
</script>


<body>


<div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    

  <div class="site-wrap" >
    <?php
    session_start();

    include 'includes/header.php';
    include 'includes/config.php';

    $medicinesPerPage = 20;
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($page - 1) * $medicinesPerPage;
    
    $searchTerm = isset($_GET['searchTerm']) ? mysqli_real_escape_string($con, $_GET['searchTerm']) : '';

    
    if (!empty($searchTerm)) {
        $sql = "SELECT * FROM medicine WHERE Name LIKE '%$searchTerm%' LIMIT $offset, $medicinesPerPage";
        $totalMedicines = mysqli_num_rows(mysqli_query($con,$sql));

    } else {
        $sql = "SELECT * FROM medicine LIMIT $offset, $medicinesPerPage";
        $totalMedicines = mysqli_num_rows(mysqli_query($con, "SELECT * FROM medicine"));

    }
    
    $result = mysqli_query($con, $sql);
    

    $totalPages = ceil($totalMedicines / $medicinesPerPage);
    ?>

    <div  style="background-color:#EFF5FA; height:40px" >
      <div class="container">
        <div class="row" >
          
          <div class="col-md-12 mb-0" ><a href="index.php" >Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Store</strong></div>
        </div>
      </div>
    </div>

    <div class="site-section" >
      <div class="container">

 

      <div class="row">
    <div class="col-lg-6">
        <h3 class="mb-3 h6 text-uppercase text-black d-block">Filter by Price</h3>
        <div class="row">
    <div class="col-md-6">
        <label for="minPrice">Min Price</label>
    </div>
    <div class="col-md-6">
        <label for="maxPrice">Max Price</label>
    </div>
</div>
<div class="row">
    <div class="col-md-5">
    <input type="number" min="0" id="minPrice" name="min" class="form-control">
    </div>
    <div class="col-md-5">
    <input type="number" min="1" id="maxPrice" name="max" class="form-control">
    </div>
    <div class="col-md-2">
    <button type="button" id="applyFilter" class="btn btn-primary">Apply Filter</button>
    </div>
</div>


    </div>
</div>

<hr>


<div class="row existing-products">
  <?php
  while ($row = mysqli_fetch_assoc($result)) { ?>
   <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.15s">
    <div class="team-item position-relative rounded overflow-hidden">
        <a href="shop-single.php?id=<?php echo $row['medicineId']; ?>" class="d-block">
            <div class="overflow-hidden">
                <br>  
                <img class="img-fluid" src="admin/medicies/<?php echo $row['imageName']; ?>" alt="" style="height:350px; width:300px">
            </div>
            <div class="team-text bg-light text-center p-4">
                <h3 class="text-dark"><?php echo $row['Name']; ?></h3>
                <div class="team-social text-center">
                    <p class="price">₪ <?php echo $row['price']; ?></p>
                </div>
            </div>
        </a>
    </div><br>
</div>

  <?php }
  mysqli_close($con);
  ?>
</div>

<div class="row mt-5">
  <div class="col-md-12 text-center">
    <div class="site-block-27 main-pagination">
      <ul>
        <?php for ($i = 1; $i <= $totalPages; $i++) {
            $activeClass = $i == $page ? 'class="active"' : '';
            echo "<li $activeClass><a href='?page=$i'>$i</a></li>";
        } ?>
      </ul>
    </div>
    <div class="site-block-27 filtered-pagination" style="display: none;">
    <!-- Filtered pagination will be displayed here -->
</div>

  </div>
</div>


      </div>
  <?php include 'includes/footer.php'; ?>

</div>

<a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i class="bi bi-arrow-up"></i></a>

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
