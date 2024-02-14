<?php
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['updateInfo'])) {
    // Get the updated user data from the form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    // Connect to the database
    $dsn = "mysql:host=localhost;dbname=projectdb";
    $user = "root";
    $pass = "";

    try {
        $con = new PDO($dsn, $user, $pass);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    // Check if a new image is uploaded
    if (isset($_FILES['imgName']) && !empty($_FILES['imgName']['name'])) {
        $image = $_FILES['imgName'];
        $imgName = $image['name'];

        $uploadDirectory = 'admin/user/';

        if (!file_exists($uploadDirectory)) {
            mkdir($uploadDirectory, 0777, true);
        }

        $imagePath = $uploadDirectory . $imgName;

        if (move_uploaded_file($image['tmp_name'], $imagePath)) {
            // Image uploaded successfully
        } else {
            $error = "Error uploading the image. Please try again.";
        }
    } else {
        // Retrieve the current imgName from the database and assign it to $imgName
        $userId = $_SESSION['userId'];
        $query = "SELECT imgName FROM users WHERE userId = :userId";

        try {
            $stmt = $con->prepare($query);
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $imgName = $result['imgName'];
            } else {
                $error = "Error retrieving the current image from the database.";
            }
        } catch (PDOException $e) {
            $error = "Error: " . $e->getMessage();
        }
    }

    $userId = $_SESSION['userId'];
    $query = "UPDATE users SET name = ?, email = ?, address = ?, phone = ?, imgName = ? WHERE userId = ?";

    $stmt = $con->prepare($query);
    $stmt->execute([$name, $email, $address, $phone, $imgName, $userId]);

    // Redirect to the updated profile page or another appropriate page
    header("Location: profile.php");
    exit();
}

// Rest of your HTML and form goes here

?>
