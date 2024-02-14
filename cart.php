<!DOCTYPE html>
<html lang="en">

<head>
  <title>E-Pharmacy & Care</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href="https://fonts.googleapis.com/css?family=Rubik:400,700|Crimson+Text:400,400i" rel="stylesheet">
  <link rel="stylesheet" href="fonts/icomoon/style.css">
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

    include 'includes/config.php';

    if (isset($_SESSION['userId'])) {
        $userId = $_SESSION['userId'];
        $cartQuery = "SELECT cart.*, medicine.Name, medicine.price, medicine.imageName FROM cart 
                    INNER JOIN medicine ON cart.medicineId = medicine.medicineId 
                    WHERE cart.userId = $userId";
        $cartResult = mysqli_query($con, $cartQuery);
    }
    ?>
    <div class="bg-light py-4">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0">
            <a href="index.php">Home</a> <span class="mx-2 mb-0">/</span>
            <strong class="text-black">Cart</strong>
          </div>
        </div>
      </div>
    </div>

    <div class="site-section">

      <div class="container">
        <?php
        if (isset($_SESSION['success_message'])) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
          ' .
                $_SESSION['success_message'] .
                '
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
            unset($_SESSION['success_message']);
        }

        if (isset($_SESSION['error_message'])) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
          ' .
                $_SESSION['error_message'] .
                '
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
            unset($_SESSION['error_message']);
        }
        ?>
        <div class="row mb-5">
          <form class="col-md-12" method="post" action="update_cart.php">
            <div class="site-blocks-table">
            <div id="successMessage"></div>

              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th class="product-thumbnail">Image</th>
                    <th class="product-name">Product</th>
                    <th class="product-price">Price</th>
                    <th class="product-quantity">Quantity</th>
                    <th class="product-total">Total</th>
                    <th class="product-remove">Remove</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (isset($_SESSION['userId'])) {
                      while ($cartItem = mysqli_fetch_assoc($cartResult)) {
                          $quantity = $cartItem['quantity'];

                          if (isset($_POST['quantity']) && isset($_POST['quantity'][$cartItem['cartId']])) {
                              $quantity = $_POST['quantity'][$cartItem['cartId']];
                          }

                          echo '<tr>';
                          echo '<td class="product-thumbnail"><img src="admin/medicies/' . $cartItem['imageName'] . '" alt="Image" class="img-fluid"></td>';
                          echo '<td class="product-name"><h2 class="h5 text-black">' . $cartItem['Name'] . '</h2></td>';
                          echo '<td>₪' . $cartItem['price'] . '</td>';
                          echo '<td>
                                                    <div class="input-group mb-3" style="max-width: 120px;">
                                                        <div class="input-group-prepend">
                                                            <button class="btn btn-outline-primary js-btn-minus" type="button" data-cart-item-id="' .
                              $cartItem['Id'] .
                              '" data-change="-1">&minus;</button>
                                                        </div>
                                                        <input type="text" class="form-control text-center" min="1" name="quantity[' .
                              $cartItem['Id'] .
                              ']" value="' .
                              $quantity .
                              '" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1" required>
                                                        <div class="input-group-append">
                                                            <button class="btn btn-outline-primary js-btn-plus" type="button" data-cart-item-id="' .
                              $cartItem['Id'] .
                              '" data-change="+1">&plus;</button>
                                                        </div>
                                                    </div>
                                                </td>';
                          echo '<td>₪' . $cartItem['price'] * $cartItem['quantity'] . '</td>';
                          echo '<td>
                                            <button type="button" class="btn btn-primary height-auto btn-sm js-delete-item" style="color:white" data-cart-item-id="' .
                              $cartItem['Id'] .
                              '">X</button>
                                          </td>';
                          echo '</tr>';
                      }
                  } ?>
                </tbody>
              </table>
            </div>

        </div>


        <div class="row">
          <div class="col-md-6">
            <div class="row mb-5">
              <div class="col-md-6 mb-3 mb-md-0">
                <button type="submit" class="btn btn-primary btn-md btn-block">Update Cart</button>
              </div>
              <div class="col-md-6">
              <a class="btn btn-primary btn-md btn-block" href='shop.php'>Continue Shopping</a>
              </div>
            </div>
           
          </div>
          <div class="col-md-6 pl-5">
          </form>
          <div class="row justify-content-end">
            <div class="col-md-7">
              <div class="row">
                <div class="col-md-8 text-right border-bottom mb-5">
                  <h3 class="text-black h4 ">Cart Total Price</h3>
                </div>
              </div>

              <?php if (isset($_SESSION['userId'])) {
                  $totalPrice = 0;

                  $cartQuery = "SELECT medicine.*, cart.quantity FROM medicine
                    INNER JOIN cart ON medicine.medicineId = cart.medicineId
                    WHERE cart.userId = {$_SESSION['userId']}";

                  $cartResult = mysqli_query($con, $cartQuery);

                  while ($cartItem = mysqli_fetch_assoc($cartResult)) {
                      $productTotal = $cartItem['price'] * $cartItem['quantity'];
                      $totalPrice += $productTotal;

                      echo '<div class="row mb-3">
                <div class="col-md-6">
                  <span class="text-black" style="color:#0A6F85">' .
                          $cartItem['Name'] .
                          'X' .
                          $cartItem['price'] .
                          '₪</span>
                </div>
                <div class="col-md-6 text-right">
                  <strong class="text-black">' .
                          $productTotal .
                          ' ₪</strong>
                </div>
              </div>';
                  }
              } ?>

              <div class="row mb-5">
                <div class="col-md-6">
                  <span style="color:#089834; font-size:20px;"><strong>Total Price</strong></span>
                </div>
                <div class="col-md-6 text-right">
                  <strong class="text-black" style="color:#089834; font-size:20px;">₪<?php echo isset($totalPrice) ? $totalPrice : 0; ?></strong>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                <?php if (mysqli_num_rows($cartResult) > 0) : ?>
            <a class="btn btn-primary btn-md btn-block" href="checkout.php">Proceed To Checkout</a><br>
        <?php endif; ?>
                </div>
              </div>
            </div>
          </div>


        </div>
      </div>
    </div>

    <?php
    include 'includes/footer.php';
    mysqli_close($con);
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

  <script src="js/doctor/main.js"></script>
  <script>
    $('.js-btn-plus').on('click', function() {
        var cartItemId = $(this).data('cart-item-id');
        var changeAmount = $(this).data('change');

        var quantityInput = $('input[name="quantity[' + cartItemId + ']"]');
        var currentQuantity = parseInt(quantityInput.val(), 10);
        quantityInput.val(currentQuantity + changeAmount);
    });
 

    document.querySelectorAll('.js-delete-item').forEach(button => {
      button.addEventListener('click', function () {
        const cartItemId = this.dataset.cartItemId;
        deleteItem(cartItemId);
      });
    });

    function updateQuantity(cartItemId, change) {
      const quantityInput = document.querySelector(`input[name="quantity[${cartItemId}]"]`);
      let newQuantity = parseInt(quantityInput.value) + change;

      newQuantity = Math.max(newQuantity, 1);

      quantityInput.value = newQuantity;

    }

function deleteItem(cartItemId) {
    if (confirm("Are you sure you want to remove this item from the cart?")) {
        fetch('delete_cart_item.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `Id=${cartItemId}`,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('successMessage').innerHTML = "<p class='alert alert-success'>Item Removed from cart successfully!</p>";
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
}

document.querySelector('.btn-primary.btn-lg.btn-block').addEventListener('click', function(event) {
    
    var cartItems = document.querySelectorAll('table.table tbody tr').length;

    if (cartItems === 0) {
        event.preventDefault();
        alert("Please Add Medicines To Cart First");
    } else {
        window.location.href = 'checkout.php';
    }
});


  </script>
</body>

</html>
