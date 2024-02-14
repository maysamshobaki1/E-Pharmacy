<?php
session_start();

include 'includes/config.php';

$response = ['success' => false, 'message' => 'Invalid request.'];

if (isset($_SESSION['userId']) && isset($_POST['Id'])) {
    $userId = $_SESSION['userId'];
    $cartItemId = $_POST['Id'];

    $deleteQuery = "DELETE FROM cart WHERE userId = $userId AND Id = $cartItemId";
    $result = mysqli_query($con, $deleteQuery);

    if ($result) {
        $response = ['success' => true, 'message' => 'Item removed from the cart successfully.'];
    } else {
        $response = ['success' => false, 'message' => 'Error removing item from the cart. Please try again.'];
    }
}

header('Content-Type: application/json');
echo json_encode($response);
