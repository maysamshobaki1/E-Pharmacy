<?php
include 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $salesId = $_POST['sales_id'];
    $status = $_POST['status'];

    $sql = "UPDATE details SET status = ? WHERE sales_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("si", $status, $salesId);
    $result = $stmt->execute();

    if ($result) {
        header('Content-Type: application/json');

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => true]);
    }
}
?>
