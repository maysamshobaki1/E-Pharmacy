<?php
session_start();
if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if (isset($_FILES['imgName'])) {
        $image = $_FILES['imgName'];
        $imageName = $image['name'];

        $uploadDirectory = 'admin/user';

        if (!file_exists($uploadDirectory)) {
            mkdir($uploadDirectory, 0777, true);
        }

        $imagePath = $uploadDirectory . $imageName;
        move_uploaded_file($image['tmp_name'], $imagePath);
    } else {
        $imageName = null; 
    }

    $dsn = "mysql:host=localhost;dbname=projectdb";
    $user = "root";
    $pass = "";
    $option = [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8",
    ];

    try {
        $con = new PDO($dsn, $user, $pass, $option);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($name) && isset($address) && isset($phone) && isset($email) && isset($password)) {
            
            if (!preg_match('/^\d{10}$/', $phone) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['registration_error'] = " <p style='border-radius: 10px; color: white; background-color: #7E1313;  padding: 10px;'>Please Check Your Phone Number (10 digits) and check inserted Email</p>";
                header("Location: login.php");
                exit();
            }

            else if (isset($phone) && !preg_match('/^\d{10}$/', $phone)) {
              
                $_SESSION['registration_error']= " <p style='border-radius: 10px; color: white; background-color: #7E1313;  padding: 10px;'>Please Check Your Phone Number, It Must be 10 integers</p>";
                header("Location: login.php");

                exit(); 
            } 
            else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['registration_error'] = " <p style='border-radius: 10px; color: white; background-color: #7E1313;  padding: 10px;'>Inalid Email,Please Check Your Email</p>";
                header("Location: login.php");
                exit();
            }
            

            $stmtcheck = $con->prepare("SELECT * FROM users WHERE email = ?");
            $stmtcheck->execute([$email]);
            $row = $stmtcheck->rowCount();
            if ($row > 0) {
                $_SESSION['registration_error']= " <p style='border-radius: 10px; color: white; background-color: #7E1313;  padding: 10px;'>Registration Failed,Email already exists!</p>";
                header("Location: login.php");
                exit(); 

            } else {
                $stmt = $con->prepare("INSERT INTO users(`name`, `email`, `password`, `address`, `phone`, `imgName`,`userType`) VALUES (?, ?, ?, ?, ?, ?,1)");

                $stmt->execute([
                    $name,
                    $email,
                    $password,
                    $address,
                    $phone,
                    $imageName, 
                ]);
                $row = $stmt->rowCount();
                if ($row > 0) {
                    $baseUrl = $_SERVER["HTTP_HOST"];
                    header("Location: http://$baseUrl/E-Pharmacy_Care/login.php");
                    exit();
                }
            }
        } else {
            echo json_encode([
                "status" => "fail",
                "message" => "Missing required field!",
            ]);
        }
    } else {
        echo json_encode([
            "status" => "fail",
            "message" => "Request should be POST!",
        ]);
    }
}
else {
    echo json_encode([
        "status" => "fail",
        "message" => "Not Registerd",
    ]);
}
?>
