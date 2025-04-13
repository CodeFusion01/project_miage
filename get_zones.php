<?php
include 'conn.php';

if (isset($_GET['ville_id']) && !empty($_GET['ville_id'])) {
    $ville_id = $_GET['ville_id'];
    $result = $conn->query("SELECT * FROM setting_zones WHERE ville_id = $ville_id");

    // تحويل النتائج إلى JSON
    $zones = [];
    while ($row = $result->fetch_assoc()) {
        $zones[] = $row;
    }

    echo json_encode($zones);
}
?>
