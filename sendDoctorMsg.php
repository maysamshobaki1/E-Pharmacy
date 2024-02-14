<?php
session_start();
include 'includes/config.php';

if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit();
}

$sender = $_SESSION['userId'];

if (!isset($_POST['receiver'], $_POST['message'])) {
    $_SESSION['message_Error']= "Message is empty!";
    header("Location: sendMessageToDoctor.php?doctorId=" . $_POST['receiver']);

    exit();
}

$receiver = mysqli_real_escape_string($con, $_POST['receiver']);
$message = mysqli_real_escape_string($con, $_POST['message']);

if (empty($receiver) || empty($message)) {
    $_SESSION['message_Error']= "Message is empty!";
    header("Location: sendMessageToDoctor.php?doctorId=" . $_POST['receiver']);

    exit();
}

$imagePath = "";
if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);

       if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $imagePath = $target_file;
    } else {
        echo "Error uploading image file.";
        exit();
    }
}

$query = "INSERT INTO conversations (sender, receiver, message, image) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "ssss", $_SESSION['userId'], $receiver, $message, $_FILES["image"]["name"]);

if (mysqli_stmt_execute($stmt)) {
    // Redirect or indicate success
    $_SESSION['messageSent']="Message sent successfully, Go to Inbox To view the chats";
    header("Location: sendMessageToDoctor.php?doctorId=" . $_POST['receiver']);
} else {
    echo "Error executing statement: " . mysqli_stmt_error($stmt);
}

mysqli_stmt_close($stmt);
mysqli_close($con);
?>
