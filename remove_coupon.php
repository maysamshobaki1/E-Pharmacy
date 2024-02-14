<?php
session_start();
include 'includes/config.php';

if (isset($_SESSION['userId'])) {
    $userId = $_SESSION['userId'];
    
    if (isset($_GET['couponId'])) {
        $couponId = $_GET['couponId'];

        $updateQuery = "UPDATE usersCoupon SET isActive = 0 WHERE userId = $userId AND couponId = $couponId";
        $updateResult = $con->query($updateQuery);

        if ($updateResult) {
            echo "Coupon removed successfully";
        } else {
            echo "Error removing coupon: " . $con->error;
        }
    } else {
        echo "Coupon ID not provided";
    }
} else {
    echo "User not logged in";
}

$con->close();
?>
