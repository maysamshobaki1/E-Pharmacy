<?php
include 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from POST request
    $driverId = $_POST['updateDriverId'];
    $name = $_POST['updateDriverName'];
    $address = $_POST['updateDriverAddress'];
    $phone = $_POST['updateDriverPhone'];
    $email = $_POST['updateDriverEmail'];

    // Handle image upload
    $imageDir = 'admin/user/';
    $imageName = '';

    if (!empty($_FILES['updateDriverImage']) && $_FILES['updateDriverImage']['error'] == 0) {
        $imageTmpName = $_FILES['updateDriverImage']['tmp_name'];
        $imageName = $_FILES['updateDriverImage']['name'];
        move_uploaded_file($imageTmpName, $imageDir . $imageName);
    }

    // Update driver data in the database
    if (!empty($imageName)) {
        // If image is provided
        $sql = "UPDATE users SET name=?, address=?, phone=?, email=?, imgName=? WHERE userId=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("sssssi", $name, $address, $phone, $email, $imageName, $driverId);
    } else {
        // If no image is provided
        $sql = "UPDATE users SET name=?, address=?, phone=?, email=? WHERE userId=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssssi", $name, $address, $phone, $email, $driverId);
    }

    $result = $stmt->execute();

    if ($result) {
        // Success
        echo json_encode(['success' => true, 'message' => 'Driver information updated successfully' . $driverId]);
    } else {
        // Error in updating data
        echo json_encode(['success' => false, 'message' => 'Error updating driver data: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    // Invalid request method
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

$con->close();
?>
