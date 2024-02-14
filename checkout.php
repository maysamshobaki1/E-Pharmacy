<!DOCTYPE html>
<html lang="en">
    <head>
        <title>E-Pharmacy & Care</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

        <link href="https://fonts.googleapis.com/css?family=Rubik:400,700|Crimson+Text:400,400i" rel="stylesheet" />
        <link rel="stylesheet" href="fonts/icomoon/style.css" />

        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <link rel="stylesheet" href="css/magnific-popup.css" />
        <link rel="stylesheet" href="css/jquery-ui.css" />
        <link rel="stylesheet" href="css/owl.carousel.min.css" />
        <link rel="stylesheet" href="css/owl.theme.default.min.css" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@700&family=Josefin+Sans:wght@700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/aos.css" />

        <link rel="stylesheet" href="css/style.css" />
    </head>

<style>
h2, label, th ,p,h4 {
    font-family: 'Josefin Sans', sans-serif;
    color: black;
}
.icon {
        margin-right: 10px; 
    }

    input[type="radio"][name="pay_id"] {
        display: none;
    }

    input[type="radio"][name="pay_id"]:checked + label {
        background-color: #007bff;
        color: #fff;
    }

    #collapsebank,
    #collapsecheque,
    #collapsepaypal,
    #collapsecard {
        border: 2px solid #ccc;
        padding: 15px;
        border-radius: 5px;
        margin-top: 10px;
    }

    #collapsecard input[required],
    #collapsebank select[required],
    #collapsecheque input[required],
    #collapsepaypal input[required] {
        border: 1px solid #ced4da;
    }

    /* Style for error message */
    .error-message {
        color: #dc3545;
        margin-top: 5px;
    }
    </style>

    <body>
        <div class="site-wrap">
            <?php
            session_start();
            include "includes/header.php";
            include "includes/config.php";
            if (isset($_SESSION['payment_error'])) {
                echo "<div class='alert alert-danger'>" . $_SESSION['payment_error'] . "</div>";
                unset($_SESSION['payment_error']);
            }
            $userData = [];
            if (isset($_SESSION["userId"])) {
                $userId = $_SESSION["userId"];
                $query = "SELECT * FROM users WHERE userId = $userId";
                $result = $con->query($query);
                if ($result) {
                    $userData = $result->fetch_assoc();
                } else {
                    echo "Error: " .
                        $query .
                        "<br />
            " .
                        $con->error;
                }
            }
            $con->close();
            ?>

            <div class="bg-light py-3">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 mb-0">
                            <a href="index.php">Home</a> <span class="mx-2 mb-0">/</span>
                            <strong class="text-black">Checkout</strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="site-section">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 mb-5 mb-md-0">
                            <h2 >Billing Details</h2>
                            <div class="p-3 p-lg-5 border">
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label for="name" class="text-black">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($userData["name"]) ? $userData["name"] : ""; ?>">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label for="c_address" class="text-black">Address <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="c_address" name="c_address" placeholder="Address" value="<?php echo isset($userData["address"]) ? $userData["address"] : ""; ?>">
                                    </div>
                                </div>

                                <div class="form-group row mb-5">
                                    <div class="col-md-12">
                                        <label for="email" class="text-black">Email Address <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="email" name="email" value="<?php echo isset($userData["email"]) ? $userData["email"] : ""; ?>">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="phone" class="text-black">Phone <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number" value="<?php echo isset($userData["phone"]) ? $userData["phone"] : ""; ?>">
                                    </div>
                                </div>
                                <div class="form-group" id="couponForm">
                                    <div>
                                        <div class="py-2">
                                            <div class="row mb-">
                                                <div class="col-md-12">
                                                    <h2 >Coupon Code</h2>
                                                    <div class="p-3 p-lg-5 border">
                                                        <label for="userCoupon" class="text-black mb-3">Select your coupon code</label>
                                                        <div class="input-group w-100">
                                                            <select class="form-control" id="userCoupon" aria-label="Coupon Code" aria-describedby="button-addon2">

                                                        </select>
                                                            <div class="input-group-append">
                                                                <button class="btn btn-primary btn-sm px-4" style="color: white;" type="button" id="button-addon2" onclick="applyCoupon()">Apply</button>
                                                            </div>
                                                        </div>
                                                        <div id="couponList"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
    <div class="row mb-5">
        <div class="col-md-12">
        <form action="sales.php" method="POST">

            <h2 >Your Order</h2>
            <div class="p-3 p-lg-5 border">
                <table class="table site-block-order-table mb-5">
                    <thead>
                        <th>Product X Quanitity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </thead>
                    <tbody>
                    <?php
                    include 'includes/config.php';

                    if (isset($_SESSION['userId'])) {
                        $userId = $_SESSION['userId'];

                        $cartQuery = "SELECT c.*, m.Name AS medicineName, m.price AS medicinePrice
              FROM cart c
              JOIN medicine m ON c.medicineId = m.medicineId
              WHERE c.userId = $userId";

                        $cartResult = $con->query($cartQuery);
                        if ($cartResult) {
                            $totalOrder = 0;

                            while ($row = $cartResult->fetch_assoc()) {
                                $medicineName = $row['medicineName'];
                                $quantity = $row['quantity'];
                                $productTotal = $row['medicinePrice'] * $row['quantity'];
                                $totalOrder += $productTotal;

                                echo "<tr>";
                                echo "<td>{$medicineName} <strong class='mx-2'>x</strong> {$quantity}</td>";
                                echo "<td>{$row['medicinePrice']} ₪</td>";
                                echo "<td>{$productTotal} ₪</td>";
                                echo "</tr>";
                            }

                            $cartResult->free();
                        } else {
                            echo "Error: " . $cartQuery . "<br>" . $con->error;
                        }

                        $con->close();
                    } else {
                        echo "User not logged in.";
                    }
                    ?>
             

                    </tbody>
                    
                </table>
                <div class="border mb-5">

                <?php echo '<p id="total" style="display: inline-block; margin-right: 10px; color:#2C7DF7;">Total Order : </p>'; ?><br>
                <?php echo '<p id="couponVlaue" style="display: inline-block; margin-right: 10px; color:#2C7DF7;"></p>'; ?>
                <?php echo '<p id="discountdTotal" style="display: inline-block; margin-right: 10px; color:#2C7DF7;"></p>'; ?>

            </div>
            
            <h4>Please Choose Your Payment Method</h4>

            <div class="border mb-3">

            <div class="py-2 px-4">
                <label>
                <img src="images/bankTrans.png" alt="Bank Transfer Icon" class="icon" style="width:40px;">

                    <input type="radio" name="pay_id" value="bankTransfer" data-toggle="collapse" data-target="#collapsebank" aria-expanded="false" aria-controls="collapsebank">
                    Direct Bank Transfer
                </label>
                <div class="collapse" id="collapsebank">
                <select class="form-control mb-2" id="bankSelect" name="bankSelect">
                    <option value="" disabled selected>Select your bank</option>
                    <option value="arab-bank">Arab Bank</option>
                    <option value="arab-bank">Quds Bank</option>

                <option value="bank-of-palestine">Bank of Palestine</option>
                <option value="cairo-amman-bank">Cairo Amman Bank</option>
                <option value="palestine-investment-bank">Palestine Investment Bank</option>
                </select>
                <input class="form-control" placeholder="Enter your account number" name="account_number"></input><br>

                </div>

            </div>
            <input type="text"  id="myAmount" name="amount" hidden >

                <div class="py-2 px-4">
                    <label>
                    <img src="images/cheque.png" alt="Bank Transfer Icon" class="icon" style="width:40px;">

                        <input type="radio" name="pay_id" value="cheque" data-toggle="collapse" data-target="#collapsecheque" aria-expanded="false" aria-controls="collapsecheque">
                        Cheque Payment
                    </label>
                    <div class="collapse" id="collapsecheque">
                        <p class="mb-0">
                            Make your payment using Cheque when deliver your order
                        </p>
                    </div>
                </div>

                <div class="py-2 px-4">
                    <label>
                    <img src="images/paypal.png" alt="Bank Transfer Icon" class="icon" style="width:40px;">

                        <input type="radio" name="pay_id" value="paypal" data-toggle="collapse" data-target="#collapsepaypal" aria-expanded="false" aria-controls="collapsepaypal">
                        Paypal
                    </label>
                    <div class="collapse" id="collapsepaypal">
                        <p class="mb-0">
                            Make your payment Using Paypal, login into your Paypal account then complete the payment
                        </p>
                    </div>
                </div>
                <div class="py-2 px-4">
                    <label>
                    <img src="images/card.png" alt="Bank Transfer Icon" class="icon" style="width:30px;">

                        <input type="radio" name="pay_id" value="card" data-toggle="collapse" data-target="#collapsecard" aria-expanded="false" aria-controls="collapsecard">
                        Card
                    </label>
                    <div class="collapse" id="collapsecard">
                    <div class="row">
                <div class="col-md-12">
                    <input class="form-control" placeholder="Enter your Card number"  name="card_number">
                </div><br><br>
            
                <div class="col-md-3">
                    <input class="form-control" placeholder="CVV" name="CVV"> 
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control" name="card_date">
                </div>
            </div>

                    </div>
                </div>
            </div>
            </div>



                            <div class="form-group">
                                <button class="btn btn-primary btn-lg btn-block"  onclick="window.location='thankyouphp'">Place Order</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

     </form> 
                </div>
            </div>
            <?php include "includes/footer.php"; ?>
        </div>
        
        <script>
          document.addEventListener("DOMContentLoaded", function () {
    function getCoupon() {
        var couponCodeSelect = document.getElementById("userCoupon");
        var xhr = new XMLHttpRequest();
        var totalElement = document.getElementById("total");
        var originalTotal = <?php echo $totalOrder; ?>;

        xhr.open("GET", "fetch_coupons.php", true);
        var myAmount = document.getElementById("myAmount");
        myAmount.value = originalTotal;


      
        totalElement.innerHTML = "Total Order: ₪ " + originalTotal.toFixed(2);

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {

                if (xhr.status == 200) {
                    couponCodeSelect.innerHTML = "";

                    var coupons = JSON.parse(xhr.responseText);

                    var defaultOption = document.createElement("option");
                    defaultOption.text = "Select a coupon";
                    defaultOption.disabled = true;
                    defaultOption.selected = true;
                    couponCodeSelect.add(defaultOption);

                    for (var i = 0; i < coupons.length; i++) {
                        var option = document.createElement("option");
                        option.value = coupons[i].couponId;
                        option.text = coupons[i].discountPercentage + "%";
                        couponCodeSelect.add(option);
                    }
                    myAmount.innerHTML=discountedTotal;

                } else {
                    console.error("Error:", xhr.status, xhr.statusText);
                }
            }
        };
        xhr.send();
    }

    function applyCoupon() {
        var couponCodeSelect = document.getElementById("userCoupon");
        var totalElement = document.getElementById("discountdTotal");
        var myAmount = document.getElementById("myAmount");
        var coupon = document.getElementById("couponVlaue");
        var couponForm = document.getElementById("couponForm");
        var originalTotal = <?php echo $totalOrder; ?>;
        var selectedCoupon = couponCodeSelect.value*10;
        alert(selectedCoupon);
        if (selectedCoupon !== "Select a coupon") {
            var removeCouponXHR = new XMLHttpRequest();
            removeCouponXHR.open("GET", "remove_coupon.php?couponId=" + selectedCoupon, true);
            removeCouponXHR.onreadystatechange = function () {
                if (removeCouponXHR.readyState == 4 && removeCouponXHR.status == 200) {
                    couponForm.style.display = 'none';
                }
            };
            removeCouponXHR.send();

            var discountPercentage = parseFloat(selectedCoupon);
            var discountedTotal = (1 - discountPercentage / 100) * originalTotal;
            totalElement.innerHTML = "Total Order (Discounted): ₪ " + discountedTotal.toFixed(2) + " Instead Of ₪ " + originalTotal.toFixed(2);
            coupon.innerHTML = "Coupon Applied: " + discountPercentage + " % ";
            myAmount.value = discountedTotal;

        } else {
            totalElement.innerHTML = "Total Order: ₪ " + originalTotal.toFixed(2);
            myAmount.value = originalTotal;

        }
        
    }

    getCoupon();

    var applyButton = document.getElementById("button-addon2");
    applyButton.addEventListener("click", applyCoupon);
});

        </script>

        <script src="js/jquery-3.3.1.min.js"></script>
        <script src="js/jquery-ui.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/owl.carousel.min.js"></script>
        <script src="js/jquery.magnific-popup.min.js"></script>
        <script src="js/aos.js"></script>

        <script src="js/main.js"></script>
    </body>
</html>
