-- ===============================================================
-- Script SQL: Menambahkan Kolom tanggal_join ke Tabel tb_admin
-- ===============================================================
-- File: tambah_kolom_tanggal_join_admin.sql
-- Cara pakai: Import file ini via phpMyAdmin atau jalankan via SQL tab
-- ===============================================================

-- 1. Tambahkan kolom tanggal_join ke tabel tb_admin
ALTER TABLE `tb_admin` 
ADD COLUMN IF NOT EXISTS `tanggal_join` DATE NULL AFTER `no_hp`;

-- 2. Tambahkan record migrasi (untuk tracking, opsional)
INSERT INTO `migrations` (`version`, `class`, `group`, `namespace`, `time`, `batch`)
SELECT '2025-11-04-000002', 
       'App\\Database\\Migrations\\AddTanggalJoinToAdminTable', 
       'default', 
       'App', 
       UNIX_TIMESTAMP(), 
       (SELECT IFNULL(MAX(`batch`), 0) + 1 FROM (SELECT `batch` FROM `migrations`) as `temp`)
WHERE NOT EXISTS (
    SELECT 1 FROM `migrations` WHERE `version` = '2025-11-04-000002'
);

-- ===============================================================
-- Verifikasi: Jalankan query berikut untuk memastikan berhasil
-- ===============================================================
-- SHOW COLUMNS FROM tb_admin LIKE 'tanggal_join';
-- SELECT * FROM migrations WHERE version = '2025-11-04-000002';
-- ===============================================================

