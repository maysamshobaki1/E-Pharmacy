
                    <!DOCTYPE html>
                    <html lang="en">
                    <head>
                    <title>E-Pharmacy & Care</title>
                    <meta charset="utf-8" />
                    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

                    <link href="https://fonts.googleapis.com/css?family=Rubik:400,700|Crimson+Text:400,400i" rel="stylesheet" />
                    <link rel="stylesheet" href="fonts/icomoon/style.css" />

                    <link rel="stylesheet" href="css/bootstrap.min.css" />
                    <link rel="stylesheet" href="css/magnific-popup.css" />
                    <link rel="stylesheet" href="css/jquery-ui.css" />
                    <link rel="stylesheet" href="css/owl.carousel.min.css" />
                    <link rel="stylesheet" href="css/owl.theme.default.min.css" />
                    <link rel="preconnect" href="https://fonts.googleapis.com">
                    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@700&family=Josefin+Sans:wght@700&display=swap" rel="stylesheet">
                    <link rel="stylesheet" href="css/aos.css" />
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

                    <link rel="stylesheet" href="css/style.css" />
                    </head>
                    <?php
                    include 'includes/config.php';
                    session_start();
                    include "includes/header.php";

                    ?>
         


                    <div class="box-body">
                    <table class="table table-bordered" id="example1">
                    <thead>
                    <th>No.</th>
                    <th>Date</th>
                    <th>Transaction</th>
                    <th>Status</th>
                    <th>Total Amount</th>
                    <th>Full Details</th>
                    </thead>
                    <tbody>
                    <?php

                    try {

                    $userId = $_SESSION['userId'];

                    $stmt = $con->prepare("SELECT * FROM sales WHERE user_id = ? ORDER BY sales_date DESC");
                    $stmt->bind_param("i", $userId);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $counter = 1;

                    while ($row = $result->fetch_assoc()) {
                    $stmt2 = $con->prepare("SELECT details.quantity,details.status, medicine.price, medicine.medicineId FROM details
                    LEFT JOIN medicine ON medicine.medicineId = details.medicineId WHERE sales_id = ?");
                    $stmt2->bind_param("i", $row['id']);
                    $stmt2->execute();
                    $result2 = $stmt2->get_result();

                    $total = 0;
                    while ($row2 = $result2->fetch_assoc()) {
                    $status = isset($row2['status']) ? $row2['status'] : 'N/A';
                    $subtotal = $row2['price'] * $row2['quantity'];
                    $total += $subtotal;
                    echo "
                    <tr>
                    <td style='width:1%'>" . $counter . "</td>
                    <td>".date('M d, Y', strtotime($row['sales_date']))."</td>
                    <td>".$row['pay_id']."</td>
                    <td>" . $status . "</td>

                    <td>".$total."₪</td>
                    <td><a href='#transaction' class='btn btn-sm btn-flat btn-info btn-flat btn-sm transact' id='transact' data-toggle='modal'  data-id='".$row['id']."'><i class='fa fa-search'></i> View </a></td>
                    </tr>
                    ";
                    $counter++; 

                    }
                    $stmt2->close();

                  
                    }

                    $stmt->close();
                    } catch (mysqli_sql_exception $e) {
                    echo "There is some problem in connection: " . $e->getMessage();
                    }
                    ?>
                    </tbody>
                    </table>
                    </div>

                    <!-- Transaction History -->
                    <div class="modal fade" id="transaction">
                    <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><b>Transaction Full Details</b></h4>
                    </div>
                    <div class="modal-body">
                    <p>
                    Date: <span id="date"></span>
                    <span class="pull-right">Transaction: <span id="transid"></span></span> 
                    </p>
                    <table class="table table-bordered">
                    <thead>
                    <th>Medicine Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    </thead>
                    <tbody id="detail">
                    <tr>
                    <td colspan="3" style="align:right"><b>Total</b></td>
                    <td><p id="summation"></p></td>
                    </tr>
                    </tbody>
                    </table>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                    </div>
                    </div>
                    </div>
                    </div>

                    <script>
  $(document).on('click', '#transact', function (e) {
    e.preventDefault();
    $('#transaction').modal('show');
    var id = $(this).data('id');
    console.log(id);
    $.ajax({
      type: 'POST',
      url: 'transaction.php',
      data: { id: id },
      dataType: 'json',
      success: function (response) {
        console.log("Success: ", response);
        console.log("Total: ", response.total);

        // Set the total using .text() instead of .html()
        $('#date').html(response.date);
        $('#transid').html(response.transaction);
        $('#detail').html(response.list);

        // Use jQuery to set innerHTML
        $('#summation').html(response.total);
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
        console.log("Response text: " + jqXHR.responseText);
      }
    });
  });

  $("#transaction").on("hidden.bs.modal", function () {
    $('#date').html('');
    $('#transid').html('');
    $('#detail').html('');
  });
</script>

