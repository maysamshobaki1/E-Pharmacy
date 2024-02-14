
<?php
session_start(); // Start the session at the very beginning

// ... rest of your PHP code ...

if (!isset($_SESSION['userId'])) {
    header("location: index.php");
    exit(); // It's important to exit after sending a header redirect
}

$id = $_SESSION['userId'];
// ... rest of your code ...
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap Profile Card and Table</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <style>
        .main-row {
    background-color: #f0f0f0; 
    color: black;   
}


.details-row {
  background-color: white;
    color: black;
    display: none;
}
.highlighted-row {
    background-color: #6F6F6F;
}
.details-row th {
    background-color: #999999; 
    color:white;
    font-size: 12px;
}
table .main-row.highlighted-row {
    background-color: white !important;
}
    </style>
    <script>
      function toggleDetails(salesId) {
    var details = document.getElementsByClassName('details-' + salesId);
    var mainRow = document.querySelector('.main-row-' + salesId);
    var isExpanded = false; // Flag to check if any detail row is expanded

    for (var i = 0; i < details.length; i++) {
        if (details[i].style.display === 'none') {
            details[i].style.display = 'table-row';
            isExpanded = true; // Set flag to true if any detail row is expanded
        } else {
            details[i].style.display = 'none';
        }
    }

    // Check the flag and add/remove 'highlighted-row' class accordingly
    if (mainRow) {
        if (isExpanded) {
            mainRow.classList.add('highlighted-row');
        } else {
            mainRow.classList.remove('highlighted-row');
        }
    }
}

$(document).on('click', '.ship-icon', function(e) {
    e.preventDefault();
    var salesId = $(this).data('sales-id');
    updateStatus(salesId, 'SHIPPED');
});

$(document).on('click', '.deliver-icon', function(e) {
    e.preventDefault();
    var salesId = $(this).data('sales-id');
    updateStatus(salesId, 'DELIVERED');
});
function updateStatus(salesId, status) {
    // AJAX request to server
    $.ajax({
        url: 'update_status.php',
        type: 'POST',
        data: { sales_id: salesId, status: status },
        dataType: 'json', // Expecting JSON response
        success: function(response) {
            if (response.success) {
                var mainRow = $('.main-row[data-sales-id="' + salesId + '"]');
                var expandedRows = $('.details-' + salesId); // Selecting the expanded rows
                var statusCell = mainRow.find('.status-cell');
                statusCell.text(status); // Update the status cell

                // If the new status is 'DELIVERED', remove/hide the row and its expanded rows
                if (status === 'DELIVERED') {
                    mainRow.remove(); // Remove the main row
                    expandedRows.remove(); // Remove the expanded rows
                }
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX error:", status, error);
        }
    });
}




    </script>
        <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
        }
        .profile-card {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .profile-img {
            width: 100%;
            height: auto;
            border-radius: 5px; /* Adjust if you want rounded corners */
        }
        .card-body {
            display: flex; /* Align card content horizontally */
        }
        .card-info {
            margin-left: 20px; /* Space between image and info */
        }
        .card-title {
            margin-bottom: 0.5rem;
        }
        .table-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <!-- Profile Card -->
    <div class="profile-card mb-4">
        <div class="card">
            <?php
            include 'includes/config.php';
            $error = "";

         
            $sql = "SELECT * FROM users WHERE userId = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) { 
            ?>
                <div class="card-body d-flex justify-content-between">
                    <div class="d-flex align-items-center"> 
                        <div class="profile-img-container">
                            <img src="admin/user/<?php echo $row['imgName']; ?>" alt="Profile Image" class="profile-img" style="height: 150px;">
                        </div>
                        <div class="card-info">
                            <h5 class="card-title"><?php echo $row['name']; ?></h5>
                            <p class="card-text"><strong>Address:</strong> <?php echo $row['address']; ?></p>
                            <p class="card-text"><strong>Phone:</strong> <?php echo $row['phone']; ?></p>
                            <p class="card-text"><strong>Email:</strong> <?php echo $row['email']; ?></p>
                        </div>
                    </div>
                    <div class="align-self-start">
                    <button class="btn btn-success" onclick="openUpdateDriverModal(<?php echo $row['userId']; ?>)">Update Profile</button>

                        <a href="logout.php" class="btn btn-danger">Logout</a>
                    </div>
                </div>
            <?php 
            } 
            ?>
        </div>
    </div>
<?php

$sql = "SELECT s.id AS sales_id, u.name AS user_name, u.address, u.phone, d.status,
        d.medicineId, d.quantity, m.name AS medicine_name,m.expiryDate AS ExpiryDate, m.price, m.imageName as medicine_Image
        FROM sales s
        JOIN users u ON s.user_id = u.userId
        JOIN details d ON s.id = d.sales_id
        JOIN medicine m ON d.medicineId = m.medicineId
        WHERE d.status= 'NEW' OR d.status= 'SHIPPED'
        ORDER BY s.id";

$result = $con->query($sql);
$rows = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rows[$row['sales_id']]['sales_info'] = [
            'user_name' => $row['user_name'],
            'address' => $row['address'],
            'phone' => $row['phone'],
            'status' => $row['status']
        ];
        $rows[$row['sales_id']]['details'][] = [
            'medicine_name' => $row['medicine_name'],
            'quantity' => $row['quantity'],
            'price' => $row['price'],
            'ExpiryDate' => $row['ExpiryDate'],
            'medicine_Image' => $row['medicine_Image']
        ];
    }
} else {
    echo "0 results";
}

$con->close();
?>
    <div class="table-container">
        <h2>Orders Table</h2>
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Order Number</th>
                    <th scope="col">User Name</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Address</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>

                </tr>
            </thead>
            <tbody>
    <?php 
    $mainRowCounter = 1; 
    foreach ($rows as $salesId => $data):
    ?>
<tr class="main-row main-row-<?php echo $salesId; ?>" onclick="toggleDetails('<?php echo $salesId; ?>')" data-sales-id="<?php echo $salesId; ?>">
            <td><?php echo $mainRowCounter++; ?></td>
            <td><?php echo $salesId; ?></td>
            <td><?php echo $data['sales_info']['user_name']; ?></td>
            <td><?php echo $data['sales_info']['phone']; ?></td>
            <td><?php echo $data['sales_info']['address']; ?></td>
            <td class="status-cell"><?php echo $data['sales_info']['status']; ?></td>
            <td>
            <a href="#" style="color:maroon;" class="ship-icon" data-sales-id="<?php echo $salesId; ?>" title="Shipped">
    <i class="fas fa-truck"></i>
</a>
<a href="#" class="deliver-icon" data-sales-id="<?php echo $salesId; ?>" title="Delivered">
    <i style="color:green;" class="fa fa-check-square"></i>
</a>   </td>
        </tr>

        <?php 
        $expandedRowCounter = 1;
        foreach ($data['details'] as $detail):
            if ($expandedRowCounter == 1):
        ?>
<tr class="details-row details-<?php echo $salesId; ?>">
                <th></th>
                <th>#</th>
                <th>Medicine Image</th>
                <th>Medicine Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Expiry Date</th>
            </tr>
        <?php endif; ?>

        <tr class="details-row details-<?php echo $salesId; ?>">
            <td></td>
            <td><?php echo $expandedRowCounter++; ?></td>
            <td><img style="width:50px;" src="admin/medicies/<?php echo htmlspecialchars($detail['medicine_Image']); ?>"></td>
            <td><?php echo htmlspecialchars($detail['medicine_name']); ?></td>
            <td><?php echo htmlspecialchars($detail['quantity']); ?></td>
            <td><?php echo htmlspecialchars($detail['price']); ?></td>
            <td><?php echo htmlspecialchars($detail['ExpiryDate']); ?></td>
        </tr>
    <?php endforeach; ?>
<?php endforeach; ?>
</tbody>

        </table>
    </div>
    <div class="modal fade" id="updateDriverModal" tabindex="-1" role="dialog" aria-labelledby="updateDriverModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateDriverModalLabel">Update Driver Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updateDriverForm" action="update_driver.php" method="post">
                    <div class="form-group">
                        <label for="updateDriverName">Name:</label>
                        <input type="text" class="form-control" id="updateDriverName" name="updateDriverName" required>
                    </div>
                    <div class="form-group">
                        <label for="updateDriverAddress">Address:</label>
                        <input type="text" class="form-control" id="updateDriverAddress" name="updateDriverAddress" required>
                    </div>
                    <div class="form-group">
                        <label for="updateDriverPhone">Phone:</label>
                        <input type="text" class="form-control" id="updateDriverPhone" name="updateDriverPhone" required>
                    </div>
                    <div class="form-group">
                        <label for="updateDriverEmail">Email:</label>
                        <input type="email" class="form-control" id="updateDriverEmail" name="updateDriverEmail" required>
                    </div>
                    <div class="form-group">
                        <label for="updateDriverImage">Image:</label>
                        <input type="file" class="form-control" id="updateDriverImage" name="updateDriverImage">
                    </div>
                    <div class="form-group">
                        <label for="updateDriverPassword">Password:</label>
                        <input type="password" class="form-control" id="updateDriverPassword" name="updateDriverPassword" required>
                    </div>
                
                    <input type="hidden" id="updateDriverId" name="updateDriverId">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>

    function openUpdateDriverModal(driverId) {
        $.ajax({
            url: 'get_driver_data.php',
            type: 'POST',
            data: { driverId: driverId },
            dataType: 'json',
            success: function (response) {
                console.log(response);
                $('#updateDriverId').val(response.userId);
                $('#updateDriverName').val(response.name);
                $('#updateDriverAddress').val(response.address);
                $('#updateDriverPhone').val(response.phone);
                $('#updateDriverEmail').val(response.email);
                $('#updateDriverModal').modal('show');
            },
            error: function (xhr, status, error) {
                console.error("AJAX error:", status, error);
            }
        });
    }
    $(document).ready(function () {
    $('#updateDriverForm').submit(function (e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            type: 'POST',
            url: 'update_driver.php',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                if (response.success) {

                    location.reload();

                } else {
                    console.log(response);
                }
            },
            error: function (xhr, status, error) {
                // Log the full error to the console for debugging
                console.log(xhr);
            }
        });
    });
       
    });
</script>


</body>
</html>
