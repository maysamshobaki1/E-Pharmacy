<?php
ob_start(); // Start output buffering

include 'includes/config.php';

$minPrice = isset($_POST['minPrice']) && $_POST['minPrice'] !== '' ? (int)$_POST['minPrice'] : 0;
$maxPrice = isset($_POST['maxPrice']) && $_POST['maxPrice'] !== '' ? (int)$_POST['maxPrice'] : 9999;

$medicinesPerPage = 20;
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
$offset = ($page - 1) * $medicinesPerPage;

$sql = "SELECT DISTINCT * FROM medicine WHERE price BETWEEN $minPrice AND $maxPrice LIMIT $offset, $medicinesPerPage";

$result = mysqli_query($con, $sql);

if (!$result) {
    die('Error in SQL query: ' . mysqli_error($con));
}

if (mysqli_num_rows($result) == 0) {
    echo "<div>No medicines found within the specified price range.</div>";
} else {
    while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.15s">
            <div class="team-item position-relative rounded overflow-hidden">
                <div class="overflow-hidden">
                    <br>
                    <img class="img-fluid" src="admin/medicies/<?php echo $row['imageName']; ?>" alt="" style="height:350px; width:300px">
                </div>
                <div class="team-text bg-light text-center p-4">
                    <h3 class="text-dark"><a href="shop-single.php?id=<?php echo $row['medicineId']; ?>"><?php echo $row['Name']; ?></a></h3>
                    <div class="team-social text-center">
                        <p class="price">₪ <?php echo $row['price']; ?></p>
                    </div>
                </div>
            </div><br>
        </div>
        <?php
    }
}

$totalFilteredMedicines = mysqli_num_rows(mysqli_query($con, "SELECT DISTINCT * FROM medicine WHERE price BETWEEN $minPrice AND $maxPrice"));
$totalFilteredPages = ceil($totalFilteredMedicines / $medicinesPerPage);

$paginationHtml = '';
if ($totalFilteredMedicines > 0) {
    $paginationHtml .= '<ul>';
    for ($i = 1; $i <= $totalFilteredPages; $i++) {
        $paginationHtml .= "<li><a href='?page=$i'>$i</a></li>";
    }
    $paginationHtml .= '</ul>';
}

// Get the buffered output (products HTML)
$productsHtml = ob_get_clean();

// Return JSON response
header('Content-Type: application/json');
echo json_encode(['products' => $productsHtml, 'pagination' => $paginationHtml]);

mysqli_close($con);
?>
