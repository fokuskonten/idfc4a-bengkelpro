<?php
// Smart Dual-Mode Database Connector (FokusKonten Portable Runtime)
// Prioritas 1: Port 3307 (Runtime Portable Mandiri)
// Prioritas 2: Port 3306 (XAMPP / MariaDB Lokal jika ada)

error_reporting(0);
mysqli_report(MYSQLI_REPORT_OFF);

$conn = null;
$ports = [3307, 3306];

// Auto-retry koneksi hingga 5 kali (2.5 detik) untuk menyerap jeda pemanasan database pertama kali
for ($attempt = 1; $attempt <= 5; $attempt++) {
    foreach ($ports as $p) {
        $testConn = @new mysqli("127.0.0.1", "root", "", "db_bengkel", $p);
        if (!$testConn->connect_error) {
            $conn = $testConn;
            break 2;
        }
    }
    usleep(500000); // 500ms
}

if (!$conn || $conn->connect_error) {
    // Tampilan transisi elegan auto-reload jika database membutuhkan waktu inisialisasi ekstra
    header("Refresh: 2");
    echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>BengkelPro - Menghubungkan Sistem</title>';
    echo '<style>body{margin:0;display:flex;height:100vh;align-items:center;justify-content:center;background:#0f172a;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,sans-serif;color:#f8fafc;text-align:center;}';
    echo '.box{max-width:380px;padding:32px;background:#1e293b;border-radius:16px;box-shadow:0 10px 25px rgba(0,0,0,0.5);}';
    echo '.spinner{width:36px;height:36px;border:3px solid #334155;border-top-color:#38bdf8;border-radius:50%;animation:spin 0.8s linear infinite;margin:0 auto 20px;}';
    echo '@keyframes spin{to{transform:rotate(360deg);}}</style></head>';
    echo '<body><div class="box"><div class="spinner"></div><h4 style="margin:0 0 8px;">Menghubungkan Basis Data...</h4>';
    echo '<p style="color:#94a3b8;font-size:13px;margin:0;">Layanan basis data mandiri sedang disiapkan. Halaman ini akan memuat otomatis...</p></div></body></html>';
    exit;
}
?>
