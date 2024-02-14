<?php
include 'includes/config.php';
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit();
}

function addToSales($userId, $pay_id, $con)
{
    global $salesid;

    $insertQuery = "INSERT INTO sales (user_id, pay_id) VALUES (?, ?)";
    $stmt = $con->prepare($insertQuery);
    $stmt->bind_param("is", $userId, $pay_id);

    if ($stmt->execute()) {
        $salesid = $con->insert_id;
    } else {
        echo "Error: " . $stmt->error;
        $_SESSION['payment_error'] = "<p class='alert alert-warning'>Error: " . $stmt->error . "</p>";
        header("Location: checkout.php");

    }

    $stmt->close();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_SESSION['userId'];
    if (isset($_POST['pay_id'])) {

        if($_POST['pay_id']=="card"){
            if(!isset($_POST['card_number']) || !isset($_POST['CVV']) || !isset($_POST['card_date']) || empty($_POST['card_number']) || empty($_POST['CVV']) || empty($_POST['card_date']) ){
                $_SESSION['payment_error'] = "Card Details not filled!";
                return header("Location: checkout.php");
            }
        }else if($_POST['pay_id']=="bankTransfer"){
            if(!isset($_POST['bankSelect']) || !isset($_POST['account_number']) || !isset($_POST['card_date'])){
                $_SESSION['payment_error'] = "Bank Account Details not filled";
               return header("Location: checkout.php");
            }
        }

        $payId = $_POST['pay_id'];
        addToSales($userId, $payId, $con);

        $stmt = $con->prepare("SELECT cart.quantity, cart.medicineId FROM cart WHERE userId = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {

            $insertDetail = $con->prepare("INSERT INTO details (sales_id, medicineId, quantity) VALUES (?, ?, ?)");
            $insertDetail->bind_param("iii", $salesid, $row['medicineId'], $row['quantity']);
            if ($insertDetail->execute()) {
                $updateMedicine = $con->prepare("UPDATE medicine SET quantity = quantity -".$row['quantity']."  WHERE medicineId = ?");
                $updateMedicine->bind_param("i", $row['medicineId']);
                $updateMedicine->execute();
                $updateMedicine->close();
            }
            
            $insertDetail->close();
        }

        $coupon=0;
        $amount = $_POST['amount'];
        if ($amount>200 && $amount< 500)
        $coupon=1;
        else if ( $amount>500 && $amount< 700)
        $coupon=2;
        else if ( $amount>700 && $amount< 900)
        $coupon=3; 
        else if ( $amount>900 && $amount< 1500)
        $coupon=4;
        else if ( $amount>1500)
        $coupon=5;

        $stmt3 = $con->prepare("SELECT * FROM coupon WHERE couponId = ?");
        $stmt3->bind_param("i", $coupon);
        $stmt3->execute();
        $result3 = $stmt3->get_result();

        $now = new DateTime();

        $now->modify('+1 month');
        $now= $now->format('Y-m-d');

        while ($row3 = $result3->fetch_assoc()) {

            $insertDetail3 = $con->prepare("INSERT INTO userscoupon (userId, couponId, endDate, isActive) VALUES (?, ?, ?,1)");
            $insertDetail3->bind_param("iis",$userId, $row3['couponId'],$now);
            if ($insertDetail3->execute()) {
              
            }
            
            $insertDetail3->close();
        }
        



        $stmt = $con->prepare("DELETE FROM cart WHERE userId = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->close();

        if ($coupon!=0)
        $_SESSION['success'] = 'Transaction successful. Thank you. You got a coupon with percentage '. $coupon * 10 .' %, you can use it at the future';
    else 
    $_SESSION['success'] = 'Transaction successful. Thank you.';

        header("Location: thankyou.php");
        exit();
    } else {
        $_SESSION['payment_error'] = "No payment method selected!";
        header("Location: checkout.php");


    }



} else {
    http_response_code(405);
    exit('Method Not Allowed');
}

?>
