<?php
/**
 * Script Debug: Cek apakah kolom tanggal_join sudah ada
 * Buka di browser: http://localhost/Project-Arjuna/cek_kolom_tanggal_join.php
 */

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Debug Kolom Tanggal Join</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #333; border-bottom: 3px solid #4CAF50; padding-bottom: 10px; }
        .success { background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .error { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .warning { background: #fff3cd; border: 1px solid #ffeaa7; color: #856404; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .info { background: #d1ecf1; border: 1px solid #bee5eb; color: #0c5460; padding: 15px; border-radius: 5px; margin: 10px 0; }
        code { background: #f4f4f4; padding: 2px 6px; border-radius: 3px; font-family: monospace; }
        pre { background: #2d2d2d; color: #f8f8f2; padding: 15px; border-radius: 5px; overflow-x: auto; }
        .step { background: #e3f2fd; padding: 15px; margin: 15px 0; border-left: 4px solid #2196F3; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        table th, table td { padding: 10px; text-align: left; border: 1px solid #ddd; }
        table th { background: #4CAF50; color: white; }
        table tr:nth-child(even) { background: #f9f9f9; }
        .highlight { background: yellow; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Debug: Kolom Tanggal Join di tb_admin</h1>
        
        <?php
        // Coba berbagai konfigurasi koneksi
        $configs = [
            ['host' => 'localhost', 'user' => 'root', 'pass' => '', 'db' => 'arjuna2'],
            ['host' => 'localhost', 'user' => 'root', 'pass' => 'root', 'db' => 'arjuna2'],
            ['host' => 'localhost', 'user' => 'root', 'pass' => 'password', 'db' => 'arjuna2'],
            ['host' => '127.0.0.1', 'user' => 'root', 'pass' => '', 'db' => 'arjuna2'],
        ];
        
        $mysqli = null;
        $connectedConfig = null;
        
        foreach ($configs as $config) {
            try {
                $mysqli = @new mysqli($config['host'], $config['user'], $config['pass'], $config['db']);
                if (!$mysqli->connect_error) {
                    $connectedConfig = $config;
                    break;
                }
            } catch (Exception $e) {
                continue;
            }
        }
        
        if (!$mysqli || $mysqli->connect_error) {
            echo '<div class="error">';
            echo '<h2>❌ GAGAL KONEKSI KE DATABASE</h2>';
            echo '<p>Tidak bisa terkoneksi ke database dengan konfigurasi yang umum.</p>';
            echo '<p><strong>Yang sudah dicoba:</strong></p>';
            echo '<ul>';
            foreach ($configs as $cfg) {
                echo "<li>Host: {$cfg['host']}, User: {$cfg['user']}, Password: " . ($cfg['pass'] === '' ? '(kosong)' : $cfg['pass']) . "</li>";
            }
            echo '</ul>';
            echo '</div>';
            
            echo '<div class="step">';
            echo '<h3>📋 Solusi Manual:</h3>';
            echo '<p>Silakan jalankan SQL berikut di <strong>phpMyAdmin</strong>:</p>';
            echo '<pre>ALTER TABLE tb_admin ADD tanggal_join DATE NULL AFTER no_hp;</pre>';
            echo '<ol>';
            echo '<li>Buka <a href="http://localhost/phpmyadmin" target="_blank">http://localhost/phpmyadmin</a></li>';
            echo '<li>Pilih database <code>arjuna2</code></li>';
            echo '<li>Klik tab "SQL"</li>';
            echo '<li>Copy-paste SQL di atas</li>';
            echo '<li>Klik tombol "Go"</li>';
            echo '</ol>';
            echo '</div>';
            exit;
        }
        
        echo '<div class="success">';
        echo '<h2>✓ Berhasil Terkoneksi ke Database</h2>';
        echo '<p><strong>Host:</strong> ' . $connectedConfig['host'] . '<br>';
        echo '<strong>User:</strong> ' . $connectedConfig['user'] . '<br>';
        echo '<strong>Database:</strong> ' . $connectedConfig['db'] . '</p>';
        echo '</div>';
        
        // Cek apakah kolom tanggal_join ada
        $result = $mysqli->query("SHOW COLUMNS FROM tb_admin LIKE 'tanggal_join'");
        
        if ($result && $result->num_rows > 0) {
            $column = $result->fetch_assoc();
            echo '<div class="success">';
            echo '<h2>✓ Kolom tanggal_join SUDAH ADA</h2>';
            echo '<table>';
            echo '<tr><th>Field</th><td>' . $column['Field'] . '</td></tr>';
            echo '<tr><th>Type</th><td>' . $column['Type'] . '</td></tr>';
            echo '<tr><th>Null</th><td>' . $column['Null'] . '</td></tr>';
            echo '<tr><th>Default</th><td>' . ($column['Default'] ?? 'NULL') . '</td></tr>';
            echo '</table>';
            echo '</div>';
            
            // Cek data sample
            $sampleData = $mysqli->query("SELECT id_admin, nama_admin, tanggal_join FROM tb_admin LIMIT 3");
            if ($sampleData && $sampleData->num_rows > 0) {
                echo '<div class="info">';
                echo '<h3>📊 Sample Data (3 baris pertama):</h3>';
                echo '<table>';
                echo '<tr><th>ID</th><th>Nama Admin</th><th>Tanggal Join</th></tr>';
                while ($row = $sampleData->fetch_assoc()) {
                    $tanggal = $row['tanggal_join'] ?? '-';
                    echo '<tr>';
                    echo '<td>' . $row['id_admin'] . '</td>';
                    echo '<td>' . $row['nama_admin'] . '</td>';
                    echo '<td>' . ($tanggal ?: '<em style="color:#999;">NULL/Kosong</em>') . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
                echo '</div>';
            }
            
        } else {
            echo '<div class="error">';
            echo '<h2>❌ Kolom tanggal_join BELUM ADA!</h2>';
            echo '<p>Kolom belum ditambahkan ke database. Ini penyebab utama kolom tidak muncul.</p>';
            echo '</div>';
            
            echo '<div class="step">';
            echo '<h3>🔧 Menambahkan Kolom Sekarang...</h3>';
            $addResult = $mysqli->query("ALTER TABLE tb_admin ADD tanggal_join DATE NULL AFTER no_hp");
            
            if ($addResult) {
                echo '<div class="success">';
                echo '<p><strong>✓ BERHASIL!</strong> Kolom tanggal_join telah ditambahkan ke database.</p>';
                echo '</div>';
            } else {
                echo '<div class="error">';
                echo '<p><strong>✗ GAGAL!</strong> Error: ' . $mysqli->error . '</p>';
                echo '</div>';
            }
            echo '</div>';
        }
        
        // Tampilkan struktur lengkap tabel
        echo '<div class="info">';
        echo '<h3>📋 Struktur Lengkap Tabel tb_admin:</h3>';
        $columns = $mysqli->query("SHOW COLUMNS FROM tb_admin");
        if ($columns) {
            echo '<table>';
            echo '<tr><th>#</th><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>';
            $no = 1;
            while ($col = $columns->fetch_assoc()) {
                $highlight = ($col['Field'] === 'tanggal_join') ? ' class="highlight"' : '';
                echo '<tr' . $highlight . '>';
                echo '<td>' . $no . '</td>';
                echo '<td><strong>' . $col['Field'] . '</strong></td>';
                echo '<td>' . $col['Type'] . '</td>';
                echo '<td>' . $col['Null'] . '</td>';
                echo '<td>' . $col['Key'] . '</td>';
                echo '<td>' . ($col['Default'] ?? 'NULL') . '</td>';
                echo '</tr>';
                $no++;
            }
            echo '</table>';
            echo '</div>';
        }
        
        $mysqli->close();
        ?>
        
        <div class="step">
            <h3>🚀 Langkah Selanjutnya:</h3>
            <ol>
                <li><strong>Clear cache browser:</strong> Tekan <code>Ctrl + Shift + Del</code>, pilih "Cached images and files", pilih "All time", klik "Clear data"</li>
                <li><strong>Restart Apache</strong> di XAMPP Control Panel</li>
                <li><strong>Buka aplikasi di tab baru</strong> atau gunakan <strong>Incognito Mode</strong></li>
                <li><strong>Buka halaman Data Admin</strong></li>
                <li><strong>Tekan Ctrl + F5</strong> untuk hard refresh</li>
            </ol>
        </div>
        
        <div class="warning">
            <h3>⚠️ Jika Kolom Masih Belum Muncul:</h3>
            <p>Kemungkinan penyebabnya:</p>
            <ul>
                <li><strong>Browser cache:</strong> Gunakan Incognito/Private window</li>
                <li><strong>PHP OpCache:</strong> Restart Apache di XAMPP</li>
                <li><strong>Session cache:</strong> Logout lalu login kembali</li>
                <li><strong>JavaScript AJAX:</strong> Cek di Network tab browser DevTools (F12)</li>
            </ul>
        </div>
    </div>
</body>
</html>

