<?php
session_start();
include 'includes/config.php';

if (isset($_SESSION['userId'])) {
    $userId = $_SESSION['userId'];

    $query = "SELECT distinct c.couponId, c.discountPercentage FROM usersCoupon uc
              JOIN coupon c ON uc.couponId = c.couponId
              WHERE uc.userId = $userId AND uc.isActive = 1";

    $result = $con->query($query);

    if ($result) {
        $coupons = [];
        while ($row = $result->fetch_assoc()) {
            $coupons[] = [
                'couponId' => $row['couponId'],
                'discountPercentage' => $row['discountPercentage']
            ];
        }
        echo json_encode($coupons);
    } else {
        echo json_encode(['error' => 'Error fetching coupons']);
    }
} else {
    echo json_encode(['error' => 'User not logged in']);
}

$con->close();
?>
