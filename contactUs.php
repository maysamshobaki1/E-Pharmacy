<?php
$host = "localhost";
$dbname = "projectdb";
$username = "root";
$password = "";

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['userId']) &&
        isset($_POST['fullName']) &&
        isset($_POST['phone']) &&
        isset($_POST['location']) &&
        isset($_POST['message'])
    ) {
        $userId = filter_var($_POST['userId'], FILTER_SANITIZE_STRING);
        $fullName = filter_var($_POST['fullName'], FILTER_SANITIZE_STRING);
        $phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
        $location = filter_var($_POST['location'], FILTER_SANITIZE_STRING);
        $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

        $stmt = $db->prepare("INSERT INTO contact (userId,fullName, phone, location, message) VALUES (:userId,:fullName, :phone, :location, :message)");
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':fullName', $fullName);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':message', $message);

        try {
            $stmt->execute();
            header("Location: contact.php");
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>
































?>
