<?php
session_start();

include 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['userId'])) {
        $userId = $_SESSION['userId'];
        $quantities = $_POST['quantity'];

        foreach ($quantities as $cartId => $quantity) {
            $updateQuery = "UPDATE cart SET quantity = $quantity WHERE Id = $cartId AND userId = $userId";
            $result = mysqli_query($con, $updateQuery);

            if (!$result) {
                $_SESSION['error_message'] = 'Error updating cart. Please try again.';
                header('Location: cart.php');
                exit();
            }
        }

        $_SESSION['success_message'] = 'Cart updated successfully';
        header('Location: cart.php');
        exit();
    }
}

header('Location: cart.php');
exit();
?>
