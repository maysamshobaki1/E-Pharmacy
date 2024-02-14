<?php
include 'includes/config.php';
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit();
}
$error = "";
$msg = "";
function addToCart($userId, $medicineId, $quantity, $con)
{
    $insertQuery = "INSERT INTO cart (userId, medicineId, quantity)
                    VALUES (?, ?, ?)";

    $stmt = $con->prepare($insertQuery);
    $stmt->bind_param("iii", $userId, $medicineId, $quantity);

    if ($stmt->execute()) {
        $_SESSION['add_to_cart_msg'] = "<p class='alert alert-success'>Item added to cart successfully!</p>";
    } else {
        $_SESSION['add_to_cart_msg'] = "<p class='alert alert-warning'>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_SESSION['userId'];
    $medicineId = $_POST['medicineId'];
    $quantity = $_POST['quantity'];

    addToCart($userId, $medicineId, $quantity, $con);

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
} else {
    http_response_code(405);
    exit('Method Not Allowed');
}
?>
