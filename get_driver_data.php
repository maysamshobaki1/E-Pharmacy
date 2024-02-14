<?php
include 'includes/config.php';

// Check if driverId is provided
if (isset($_POST['driverId'])) {
    $driverId = $_POST['driverId'];

    // Fetch driver data from the database
    $sql = "SELECT * FROM users WHERE userId = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $driverId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $driverData = $result->fetch_assoc();
        echo json_encode($driverData);
    } else {
        echo json_encode(['error' => 'Driver not found']);
    }
} else {
    echo json_encode(['error' => 'DriverId not provided']);
}
?>
