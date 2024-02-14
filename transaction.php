<?php
include 'includes/config.php'; 
session_start();
header('Content-Type: application/json');

$id = $_POST['id'];
$output = array('list'=>'');

$query = "SELECT details.*, medicine.name, medicine.price, details.quantity, sales.sales_date, sales.pay_id FROM details 
          LEFT JOIN medicine ON medicine.medicineId = details.medicineId 
          LEFT JOIN sales ON sales.id = details.sales_id 
          WHERE details.sales_id = ?";

if ($stmt = $con->prepare($query)) {
    $stmt->bind_param("i", $id); 
    $stmt->execute();

    $result = $stmt->get_result();

    $total = 0;
    while ($row = $result->fetch_assoc()) {
        $output['transaction'] = $row['pay_id'];
        $output['date'] = date('M d, Y', strtotime($row['sales_date']));
        $subtotal = $row['price'] * $row['quantity'];
        $total += $subtotal;
        $output['list'] .= "
            <tr class='prepend_items'>
                <td>".$row['name']."</td>
                <td>₪ ".number_format($row['price'], 2)."</td>
                <td>".$row['quantity']."</td>
                <td>₪ ".number_format($subtotal, 2)."</td>
            </tr>
        ";
    }

    $stmt->close();
} else {
    die("Error preparing statement: " . $con->error);
}

$output['total'] = '₪ '.number_format($total, 2).'';
echo json_encode($output);
?>
