<?php
/**
 * Script untuk menambahkan kolom tanggal_join ke database
 * Jalankan dengan: php tambah_kolom_database.php
 */

echo "==============================================\n";
echo "Menambahkan kolom tanggal_join ke tb_admin\n";
echo "==============================================\n\n";

// Coba koneksi dengan mysqli extension
$host = 'localhost';
$user = 'root';
$database = 'arjuna2';

// Array password yang akan dicoba
$passwords = ['', 'root', 'password', 'admin', 'mysql'];

$connected = false;
$mysqli = null;

foreach ($passwords as $pass) {
    try {
        // Suppress error untuk mencoba koneksi
        $mysqli = @new mysqli($host, $user, $pass, $database);
        
        if ($mysqli->connect_error) {
            continue;
        }
        
        $connected = true;
        echo "✓ Berhasil terkoneksi ke database!\n";
        echo "  Database: $database\n";
        echo "  Password yang digunakan: " . ($pass === '' ? '(kosong)' : $pass) . "\n\n";
        break;
    } catch (Exception $e) {
        continue;
    }
}

if (!$connected) {
    echo "❌ GAGAL KONEKSI KE DATABASE\n\n";
    echo "Silakan jalankan SQL berikut secara MANUAL via phpMyAdmin:\n";
    echo "=" . str_repeat("=", 60) . "\n\n";
    echo "ALTER TABLE tb_admin ADD tanggal_join DATE NULL AFTER no_hp;\n\n";
    echo "=" . str_repeat("=", 60) . "\n";
    exit(1);
}

// Cek apakah kolom sudah ada
$check = $mysqli->query("SHOW COLUMNS FROM tb_admin LIKE 'tanggal_join'");

if ($check && $check->num_rows > 0) {
    echo "✓ Kolom 'tanggal_join' SUDAH ADA di database\n\n";
    
    // Tampilkan info kolom
    $check = $mysqli->query("SHOW COLUMNS FROM tb_admin LIKE 'tanggal_join'");
    $col = $check->fetch_assoc();
    echo "  Field: " . $col['Field'] . "\n";
    echo "  Type: " . $col['Type'] . "\n";
    echo "  Null: " . $col['Null'] . "\n";
    echo "  Default: " . ($col['Default'] ?? 'NULL') . "\n\n";
} else {
    echo "⚠ Kolom 'tanggal_join' BELUM ADA. Menambahkan sekarang...\n\n";
    
    $sql = "ALTER TABLE tb_admin ADD tanggal_join DATE NULL AFTER no_hp";
    
    if ($mysqli->query($sql)) {
        echo "✓ BERHASIL! Kolom 'tanggal_join' telah ditambahkan!\n\n";
    } else {
        echo "❌ GAGAL menambahkan kolom!\n";
        echo "Error: " . $mysqli->error . "\n\n";
        exit(1);
    }
}

// Tampilkan struktur tabel lengkap
echo "==============================================\n";
echo "Struktur tabel tb_admin:\n";
echo "==============================================\n";

$result = $mysqli->query("SHOW COLUMNS FROM tb_admin");
if ($result) {
    $no = 1;
    while ($row = $result->fetch_assoc()) {
        $marker = ($row['Field'] === 'tanggal_join') ? ' ← BARU!' : '';
        echo sprintf("%2d. %-20s %-15s %s\n", $no, $row['Field'], '(' . $row['Type'] . ')', $marker);
        $no++;
    }
}

echo "\n";
echo "==============================================\n";
echo "✓✓✓ SELESAI! ✓✓✓\n";
echo "==============================================\n\n";
echo "Langkah selanjutnya:\n";
echo "1. Buka browser\n";
echo "2. Buka halaman Data Admin\n";
echo "3. Tekan Ctrl+Shift+R (hard refresh)\n";
echo "4. Kolom 'Tanggal Join' akan muncul!\n\n";
echo "Jika masih belum muncul:\n";
echo "- Clear cache browser (Ctrl+Shift+Del)\n";
echo "- Tutup dan buka kembali browser\n";
echo "- Restart Apache di XAMPP\n\n";

$mysqli->close();

