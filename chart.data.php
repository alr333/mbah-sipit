<?php
header('Content-Type: application/json');
include '../config/db.php';

// Ambil 7 hari terakhir
$labels = [];
$values = [];

for ($i = 6; $i >= 0; $i--) {
    $tanggal = date('Y-m-d', strtotime("-$i days"));
    $labels[] = date('d M', strtotime($tanggal)); // contoh: 26 Jun

    // Hitung jumlah pesanan untuk tanggal tersebut
    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM orders WHERE DATE(created_at) = ?");
    $stmt->bind_param("s", $tanggal);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    $values[] = isset($result['total']) ? (int)$result['total'] : 0;
}

echo json_encode([
    'labels' => $labels,
    'values' => $values
]);
