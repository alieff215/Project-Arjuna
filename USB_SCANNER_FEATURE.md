# Fitur USB Scanner untuk Sistem Absensi QR Code

## Deskripsi
Fitur ini menambahkan opsi untuk melakukan scan QR Code menggunakan USB Scanner (kamera scanner yang terhubung ke USB) sebagai alternatif dari scanning menggunakan kamera web.

## Implementasi

### File yang Dimodifikasi
1. `app/Views/scan/scan_admin.php` - Halaman scan untuk admin
2. `app/Views/scan/scan_user.php` - Halaman scan untuk user
3. `app/Views/scan/scan_main.php` - Halaman utama scan

### Fitur yang Ditambahkan

#### 1. Toggle Mode Scan
- Pengguna dapat memilih antara dua mode:
  - **Mode Kamera**: Menggunakan kamera web untuk scan QR Code
  - **Mode USB Scanner**: Menggunakan USB scanner untuk input QR Code

#### 2. Mode Kamera
- Menggunakan library ZXing untuk scan QR Code melalui kamera
- Menampilkan preview kamera
- Pilihan untuk memilih kamera yang tersedia
- Otomatis scan saat QR Code terdeteksi

#### 3. Mode USB Scanner
- Menyediakan input field untuk menerima data dari USB scanner
- USB scanner bekerja seperti keyboard input
- Otomatis memproses setelah menerima input (Enter key)
- Auto-focus kembali ke input field setelah scan untuk memudahkan scan berikutnya
- Delay 100ms untuk memastikan scanner selesai mengirim data

### Cara Kerja USB Scanner

USB barcode/QR code scanner biasanya bekerja sebagai "keyboard wedge":
1. Scanner mengirimkan karakter sebagai keystroke events
2. Data ditangkap oleh input field
3. Scanner biasanya mengirimkan Enter key setelah selesai scan
4. Sistem mendeteksi Enter key dan memproses data QR Code

### Event Handlers

#### Input Event Handler
```javascript
$(document).on('input', '#usbScanInput', function(e) {
   clearTimeout(usbScanTimeout);
   usbScanBuffer = $(this).val();
   
   // Wait for scanner to finish (usually sends Enter key)
   usbScanTimeout = setTimeout(() => {
      if (usbScanBuffer.trim().length > 0) {
         processUSBScan(usbScanBuffer.trim());
         $(this).val(''); // Clear input
         usbScanBuffer = '';
      }
   }, 100);
});
```

#### Enter Key Handler
```javascript
$(document).on('keypress', '#usbScanInput', function(e) {
   if (e.which === 13) { // Enter key
      e.preventDefault();
      clearTimeout(usbScanTimeout);
      const code = $(this).val().trim();
      if (code.length > 0) {
         processUSBScan(code);
         $(this).val(''); // Clear input
         usbScanBuffer = '';
      }
   }
});
```

#### Process USB Scan
```javascript
function processUSBScan(code) {
   console.log('USB Scanner detected code:', code);
   audio.play(); // Play beep sound (only in user mode)
   cekData(code); // Process the QR code data
   
   // Re-focus input for next scan after delay
   setTimeout(() => {
      $('#usbScanInput').focus();
   }, 2500);
}
```

### Toggle Mode Handler
```javascript
$(document).on('change', 'input[name="scanMode"]', function() {
   currentMode = $(this).val();
   
   if (currentMode === 'camera') {
      $('#cameraModeSection').show();
      $('#usbModeSection').hide();
      if (codeReader) {
         codeReader.reset();
      }
      if (navigator.mediaDevices) {
         initScanner();
      }
   } else {
      $('#cameraModeSection').hide();
      $('#usbModeSection').show();
      if (codeReader) {
         codeReader.reset();
      }
      $('#usbScanInput').focus();
   }
});
```

## UI/UX

### Mode Selector
- Toggle button group dengan dua opsi
- Icon yang jelas untuk setiap mode (camera_alt & usb)
- State active yang jelas menggunakan Bootstrap btn-check

### USB Scanner Section
- Input field besar yang mudah dikenali
- Placeholder text yang informatif
- Alert box dengan petunjuk penggunaan
- Auto-focus ke input field saat mode diaktifkan

### Panduan Penggunaan
Diperbarui di `scan_main.php` untuk mencakup:
- Langkah-langkah untuk kedua mode scan
- Tips penggunaan USB Scanner
- Badge USB Scanner di header

## Keuntungan USB Scanner

1. **Lebih Cepat**: Scan lebih cepat dibanding kamera web
2. **Lebih Akurat**: Dedicated scanner lebih reliable
3. **Tidak Perlu Permission**: Tidak perlu izin akses kamera
4. **Lebih Stabil**: Tidak tergantung kondisi pencahayaan
5. **Professional**: Lebih cocok untuk environment profesional

## Testing

### Testing Mode Kamera
1. Buka halaman scan (`/scan/masuk` atau `/scan/pulang`)
2. Pastikan mode Kamera aktif (default)
3. Izinkan akses kamera
4. Scan QR Code dengan menunjukkan ke kamera
5. Verifikasi notifikasi sukses/error

### Testing Mode USB Scanner
1. Buka halaman scan (`/scan/masuk` atau `/scan/pulang`)
2. Klik tombol "USB Scanner"
3. Klik pada input field
4. Scan QR Code dengan USB scanner
5. Verifikasi notifikasi sukses/error
6. Scan QR Code kedua untuk memastikan auto-focus bekerja

### Testing Toggle Mode
1. Mulai dengan mode Kamera
2. Switch ke mode USB Scanner - verifikasi kamera berhenti
3. Switch kembali ke mode Kamera - verifikasi kamera start kembali
4. Verifikasi tidak ada memory leak atau camera stream yang tertinggal

## Troubleshooting

### USB Scanner Tidak Bekerja
1. Pastikan USB scanner terhubung dengan baik
2. Test scanner di notepad/text editor untuk memastikan berfungsi
3. Pastikan cursor ada di input field
4. Check console browser untuk error messages

### Scanner Mengirim Karakter Tambahan
- Beberapa scanner mengirim prefix/suffix characters
- Adjust timeout di `usbScanTimeout` jika perlu
- Trim whitespace sudah di-handle

### Mode Toggle Tidak Berfungsi
1. Check JavaScript console untuk errors
2. Pastikan jQuery loaded
3. Verify radio button IDs dan name attributes unique

## Kompatibilitas

### Browser Support
- Chrome/Edge: ✓
- Firefox: ✓
- Safari: ✓
- Opera: ✓

### USB Scanner Support
Kompatibel dengan semua USB barcode/QR code scanner yang bekerja sebagai "keyboard wedge" termasuk:
- Honeywell
- Zebra
- Datalogic
- Symbol
- Generic USB Scanners

## Future Improvements

1. **Scanner Configuration**: Opsi untuk configure prefix/suffix scanner
2. **Auto-detect Mode**: Otomatis detect jika USB scanner terkoneksi
3. **Scanner History**: Log history scan untuk audit
4. **Bulk Scan**: Mode untuk scan multiple QR codes sekaligus
5. **Scanner Settings**: Konfigurasi delay, beep sound, dll
6. **Barcode Support**: Extend untuk support 1D barcodes

## Catatan Teknis

- USB scanner input di-handle dengan timeout 100ms untuk memastikan semua karakter terkirim
- Enter key handler sebagai fallback untuk scanner yang mengirim Enter
- Auto-focus setelah 2.5 detik untuk sinkronisasi dengan notification display
- Camera stream di-stop saat switch ke USB mode untuk menghemat resources

## Kesimpulan

Fitur USB Scanner memberikan fleksibilitas lebih kepada pengguna untuk memilih metode scan yang paling sesuai dengan kebutuhan dan equipment yang tersedia. Implementasi yang user-friendly dengan toggle sederhana membuat fitur ini mudah digunakan tanpa mengorbankan fungsionalitas mode kamera yang sudah ada.


