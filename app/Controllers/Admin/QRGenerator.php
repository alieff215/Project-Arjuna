<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminModel;
use App\Models\DepartemenModel;
use App\Models\KaryawanModel;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Font\Font;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\SvgWriter;
use Endroid\QrCode\Writer\WriterInterface;

class QRGenerator extends BaseController
{
   protected QrCode $qrCode;
   protected WriterInterface $writer;
   protected ?Logo $logo = null;
   protected Label $label;
   protected Font $labelFont;
   protected Color $foregroundColor;
   protected Color $foregroundColor2;
   protected Color $backgroundColor;

   protected string $qrCodeFilePath;
   protected KaryawanModel $karyawanModel;
   protected DepartemenModel $departemenModel;
   protected AdminModel $adminModel;
   protected int $dpi = 300;
   protected string $fontRegular;
   protected string $fontMedium;
   protected string $fontBold;

   const UPLOADS_PATH = FCPATH . 'uploads' . DIRECTORY_SEPARATOR;

   public function __construct()
   {
      $this->setQrCodeFilePath(self::UPLOADS_PATH);

      $this->writer = new PngWriter();

      $this->labelFont = new Font(FCPATH . 'assets/fonts/Roboto-Medium.ttf', 14);

      $this->foregroundColor = new Color(44, 73, 162);
      $this->foregroundColor2 = new Color(28, 101, 90);
      $this->backgroundColor = new Color(255, 255, 255);

      $this->karyawanModel = new KaryawanModel();
      $this->departemenModel = new DepartemenModel();
      $this->adminModel = new AdminModel();

      $this->fontRegular = FCPATH . 'assets/fonts/Roboto-Regular.ttf';
      if (!is_file($this->fontRegular)) {
         $this->fontRegular = FCPATH . 'assets/fonts/Roboto-Medium.ttf';
      }

      $this->fontMedium = FCPATH . 'assets/fonts/Roboto-Medium.ttf';
      if (!is_file($this->fontMedium)) {
         $this->fontMedium = $this->fontRegular;
      }

      $this->fontBold = FCPATH . 'assets/fonts/Roboto-Bold.ttf';
      if (!is_file($this->fontBold)) {
         $this->fontBold = $this->fontMedium;
      }

      if (boolval(env('QR_LOGO'))) {
         // Create logo
         $logo = (new \Config\Company)::$generalSettings->logo;
         if (empty($logo) || !file_exists(FCPATH . $logo)) {
            $logo = 'assets/img/logo_sekolah.jpg';
         }
         if (file_exists(FCPATH . $logo)) {
            $fileExtension = pathinfo(FCPATH . $logo, PATHINFO_EXTENSION);
            if ($fileExtension === 'svg') {
               $this->writer = new SvgWriter();
               $this->logo = Logo::create(FCPATH . $logo)
                  ->setResizeToWidth(75)
                  ->setResizeToHeight(75);
            } else {
               $this->logo = Logo::create(FCPATH . $logo)
                  ->setResizeToWidth(75);
            }
         }
      }

      $this->label = Label::create('')
         ->setFont($this->labelFont)
         ->setTextColor($this->foregroundColor);

      // Create QR code
      $this->qrCode = QrCode::create('')
         ->setEncoding(new Encoding('UTF-8'))
         ->setErrorCorrectionLevel(new ErrorCorrectionLevelHigh())
         ->setSize(300)
         ->setMargin(10)
         ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
         ->setForegroundColor($this->foregroundColor)
         ->setBackgroundColor($this->backgroundColor);
   }

   public function setQrCodeFilePath(string $qrCodeFilePath)
   {
      $this->qrCodeFilePath = $qrCodeFilePath;
      if (!file_exists($this->qrCodeFilePath)) mkdir($this->qrCodeFilePath, recursive: true);
   }

   public function generateQrKaryawan()
   {
      $Departemen = $this->getDepartemenJabatanSlug($this->request->getVar('id_departemen'));
      if (!$Departemen) {
         return $this->response->setJSON(false);
      }

      $this->qrCodeFilePath .= "qr-karyawan/$Departemen/";

      if (!file_exists($this->qrCodeFilePath)) {
         mkdir($this->qrCodeFilePath, recursive: true);
      }

      $departemenData = null;
      $idDepartemen = $this->request->getVar('id_departemen');
      if (!empty($idDepartemen)) {
         $departemenData = $this->departemenModel->getDepartemen($idDepartemen);
      }

      $departemenName = $this->request->getVar('departemen');
      $grade = $this->request->getVar('grade');

      if (!$departemenName && $departemenData) {
         $departemenName = $departemenData->departemen ?? null;
      }

      if (!$grade && $departemenData) {
         $grade = $departemenData->jabatan ?? null;
      }

      $this->generate(
         unique_code: $this->request->getVar('unique_code'),
         nama: $this->request->getVar('nama'),
         nomor: $this->request->getVar('nomor'),
         departemen: $departemenName,
         grade: $grade
      );

      return $this->response->setJSON(true);
   }

   public function generateQrAdmin()
   {
      $this->qrCode->setForegroundColor($this->foregroundColor2);
      $this->label->setTextColor($this->foregroundColor2);

      // Sederhanakan QR untuk admin: gunakan ECC medium dan tanpa logo
      try {
         $this->qrCode->setErrorCorrectionLevel(new \Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelMedium());
      } catch (\Throwable $th) {
         // Abaikan jika versi library tidak mendukung, tetap lanjut
      }
      $this->logo = null;

      $this->qrCodeFilePath .= 'qr-admin/';

      if (!file_exists($this->qrCodeFilePath)) {
         mkdir($this->qrCodeFilePath, recursive: true);
      }

      $this->generate(
         unique_code: $this->request->getVar('unique_code'),
         nama: $this->request->getVar('nama'),
         nomor: $this->request->getVar('nomor'),
         departemen: $this->request->getVar('departemen'),
         grade: $this->request->getVar('grade'),
         simple: true
      );

      return $this->response->setJSON(true);
   }

   public function generate($nama, $nomor, $unique_code, ?string $departemen = null, ?string $grade = null, bool $simple = false)
   {
      $fileExt = 'png';
      $filename = url_title($nama, lowercase: true) . "_" . url_title($nomor, lowercase: true) . ".$fileExt";

      $this->qrCode->setData($unique_code);
      $this->label->setText('');

      // Ukuran dan margin tetap sama untuk semua, sesuai permintaan
      $qrTargetPx = $this->cmToPx(2.0);
      $qrMarginPx = max(2, (int) round($this->cmToPx(0.1)));
      $qrEffectiveSize = max(40, $qrTargetPx - ($qrMarginPx * 2));

      $this->qrCode
         ->setMargin($qrMarginPx)
         ->setSize($qrEffectiveSize);

      if ($simple) {
         try {
            // Turunkan tingkat koreksi kesalahan untuk pola QR yang lebih sederhana
            $this->qrCode->setErrorCorrectionLevel(new \Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelMedium());
         } catch (\Throwable $th) {
            // Abaikan bila tidak tersedia
         }
      }

      [$resolvedDepartemen, $resolvedGrade] = $this->resolveCardMeta($unique_code, $departemen, $grade);

      $writer = $this->writer instanceof SvgWriter ? new PngWriter() : $this->writer;

      try {
         $this->createCardImage(
            filename: $filename,
            payload: [
               'nama' => $nama,
               'nomor' => $nomor,
               'unique_code' => $unique_code,
               'departemen' => $resolvedDepartemen,
               'grade' => $resolvedGrade,
            ],
            writer: $writer,
            qrTargetPx: $qrTargetPx
         );
      } catch (\Throwable $th) {
         log_message('error', 'Gagal membuat kartu QR: {message}', ['message' => $th->getMessage()]);
         $this->saveFallbackQr($filename, $writer);
      }

      return $this->qrCodeFilePath . $filename;
   }

   public function downloadQrKaryawan($idKaryawan = null)
   {
      $karyawan = $this->karyawanModel
         ->select('tb_karyawan.*, tb_departemen.departemen, tb_jabatan.jabatan')
         ->join('tb_departemen', 'tb_departemen.id_departemen = tb_karyawan.id_departemen', 'left')
         ->join('tb_jabatan', 'tb_departemen.id_jabatan = tb_jabatan.id', 'left')
         ->where('tb_karyawan.id_karyawan', $idKaryawan)
         ->first();
      if (!$karyawan) {
         session()->setFlashdata([
            'msg' => 'Karyawan tidak ditemukan',
            'error' => true
         ]);
         return redirect()->back();
      }
      
      try {
         $departemen = $this->getDepartemenJabatanSlug($karyawan['id_departemen']) ?? 'tmp';
         $this->qrCodeFilePath .= "qr-karyawan/$departemen/";

         if (!file_exists($this->qrCodeFilePath)) {
            mkdir($this->qrCodeFilePath, recursive: true);
         }

         return $this->response->download(
            $this->generate(
               nama: $karyawan['nama_karyawan'],
               nomor: $karyawan['nis'],
               unique_code: $karyawan['unique_code'],
               departemen: $karyawan['departemen'] ?? null,
               grade: $karyawan['jabatan'] ?? null,
            ),
            null,
            true,
         );
      } catch (\Throwable $th) {
         session()->setFlashdata([
            'msg' => $th->getMessage(),
            'error' => true
         ]);
         return redirect()->back();
      }
   }

   public function downloadQrAdmin($idAdmin = null)
   {
      $admin = $this->adminModel
         ->select('tb_admin.*, tb_departemen.departemen, tb_jabatan.jabatan')
         ->join('tb_departemen', 'tb_admin.id_departemen = tb_departemen.id_departemen', 'left')
         ->join('tb_jabatan', 'tb_departemen.id_jabatan = tb_jabatan.id', 'left')
         ->where('tb_admin.id_admin', $idAdmin)
         ->first();
      if (!$admin) {
         session()->setFlashdata([
            'msg' => 'Data tidak ditemukan',
            'error' => true
         ]);
         return redirect()->back();
      }
      try {
         $this->qrCode->setForegroundColor($this->foregroundColor2);
         $this->label->setTextColor($this->foregroundColor2);

         // Sederhanakan QR admin pada unduhan: ECC medium, tanpa logo
         try {
            $this->qrCode->setErrorCorrectionLevel(new \Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelMedium());
         } catch (\Throwable $th) {
            // Abaikan bila tidak tersedia
         }
         $this->logo = null;

         $this->qrCodeFilePath .= 'qr-admin/';

         if (!file_exists($this->qrCodeFilePath)) {
            mkdir($this->qrCodeFilePath, recursive: true);
         }

         return $this->response->download(
            $this->generate(
               nama: $admin['nama_admin'],
               nomor: $admin['nuptk'],
               unique_code: $admin['unique_code'],
               departemen: $admin['departemen'] ?? null,
               grade: $admin['jabatan'] ?? null,
               simple: true,
            ),
            null,
            true,
         );
      } catch (\Throwable $th) {
         session()->setFlashdata([
            'msg' => $th->getMessage(),
            'error' => true
         ]);
         return redirect()->back();
      }
   }

   public function downloadAllQrKaryawan()
   {
      $departemen = null;
      if ($idDepartemen = $this->request->getVar('id_departemen')) {
         $departemen = $this->getDepartemenJabatanSlug($idDepartemen);
         if (!$departemen) {
            session()->setFlashdata([
               'msg' => 'Departemen tidak ditemukan',
               'error' => true
            ]);
            return redirect()->back();
         }
      }

      $this->qrCodeFilePath .= "qr-karyawan/" . ($departemen ? "{$departemen}/" : '');

      if (!file_exists($this->qrCodeFilePath) || count(glob($this->qrCodeFilePath . '*')) === 0) {
         session()->setFlashdata([
            'msg' => 'QR Code tidak ditemukan, generate qr terlebih dahulu',
            'error' => true
         ]);
         return redirect()->back();
      }

      try {
         $output = $this->getWritableUploadsPath() . 'qrcode-karyawan' . ($departemen ? "_{$departemen}.zip" : '.zip');

         $this->zipFolder($this->qrCodeFilePath, $output);

         return $this->response->download($output, null,  true);
      } catch (\Throwable $th) {
         session()->setFlashdata([
            'msg' => $th->getMessage(),
            'error' => true
         ]);
         return redirect()->back();
      }
   }

   public function downloadAllQrAdmin()
   {
      $this->qrCodeFilePath .= 'qr-admin/';

      if (!file_exists($this->qrCodeFilePath) || count(glob($this->qrCodeFilePath . '*')) === 0) {
         session()->setFlashdata([
            'msg' => 'QR Code tidak ditemukan, generate qr terlebih dahulu',
            'error' => true
         ]);
         return redirect()->back();
      }

      try {
         $output = $this->getWritableUploadsPath() . 'qrcode-admin.zip';

         $this->zipFolder($this->qrCodeFilePath, $output);

         return $this->response->download($output, null,  true);
      } catch (\Throwable $th) {
         session()->setFlashdata([
            'msg' => $th->getMessage(),
            'error' => true
         ]);
         return redirect()->back();
      }
   }

   private function zipFolder(string $folder, string $output)
   {
      $zip = new \ZipArchive;
      $openResult = $zip->open($output, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
      if ($openResult !== true) {
         throw new \RuntimeException('Gagal membuka arsip ZIP: kode ' . (string) $openResult);
      }

      // Create recursive directory iterator
      /** @var \SplFileInfo[] $files */
      $files = new \RecursiveIteratorIterator(
         new \RecursiveDirectoryIterator($folder),
         \RecursiveIteratorIterator::LEAVES_ONLY
      );

      foreach ($files as $file) {
         // Skip directories (they would be added automatically)
         if (!$file->isDir()) {
            // Get real and relative path for current file
            $filePath = $file->getRealPath();
            $folderLength = strlen($folder);
            if ($folder[$folderLength - 1] === DIRECTORY_SEPARATOR) {
               $relativePath = substr($filePath, $folderLength);
            } else {
               $relativePath = substr($filePath, $folderLength + 1);
            }

            // Add current file to archive
            $zip->addFile($filePath, $relativePath);
         }
      }
      $zip->close();
   }

   private function getWritableUploadsPath(): string
   {
      $path = rtrim(WRITEPATH, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;
      if (!file_exists($path)) {
         mkdir($path, recursive: true);
      }
      return $path;
   }

   protected function resolveCardMeta(string $uniqueCode, ?string $departemen, ?string $grade): array
   {
      $departemen = $departemen ? trim((string) $departemen) : null;
      $grade = $grade ? trim((string) $grade) : null;

      if ($departemen && $grade) {
         return [$departemen, $grade];
      }

      if (!$departemen || !$grade) {
         $karyawan = $this->karyawanModel
            ->select('tb_departemen.departemen, tb_jabatan.jabatan')
            ->join('tb_departemen', 'tb_departemen.id_departemen = tb_karyawan.id_departemen', 'left')
            ->join('tb_jabatan', 'tb_departemen.id_jabatan = tb_jabatan.id', 'left')
            ->where('tb_karyawan.unique_code', $uniqueCode)
            ->first();
         if ($karyawan) {
            $departemen ??= $karyawan['departemen'] ?? null;
            $grade ??= $karyawan['jabatan'] ?? null;
         }
      }

      if (!$departemen || !$grade) {
         $admin = $this->adminModel
            ->select('tb_departemen.departemen, tb_jabatan.jabatan')
            ->join('tb_departemen', 'tb_admin.id_departemen = tb_departemen.id_departemen', 'left')
            ->join('tb_jabatan', 'tb_departemen.id_jabatan = tb_jabatan.id', 'left')
            ->where('tb_admin.unique_code', $uniqueCode)
            ->first();
         if ($admin) {
            $departemen ??= $admin['departemen'] ?? null;
            $grade ??= $admin['jabatan'] ?? null;
         }
      }

      return [$departemen, $grade];
   }

   protected function createCardImage(string $filename, array $payload, WriterInterface $writer, int $qrTargetPx): string
   {
      if (!extension_loaded('gd') || !function_exists('imagecreatetruecolor')) {
         throw new \RuntimeException('Ekstensi GD tidak tersedia untuk membuat kartu QR.');
      }

      $result = $writer->write(
         qrCode: $this->qrCode,
         logo: $this->logo,
         label: null
      );

      $qrImage = imagecreatefromstring($result->getString());
      if (!$qrImage) {
         throw new \RuntimeException('Gagal membuat resource gambar QR.');
      }

      $cardWidth = $this->cmToPx(5.5);
      $cardHeight = $this->cmToPx(8.5);
      $card = imagecreatetruecolor($cardWidth, $cardHeight);
      if (!$card) {
         imagedestroy($qrImage);
         throw new \RuntimeException('Gagal membuat canvas kartu.');
      }

      $white = imagecolorallocate($card, 255, 255, 255);
      imagefill($card, 0, 0, $white);

      $borderColor = imagecolorallocate($card, 212, 222, 240);
      $qrColor = $this->qrCode->getForegroundColor();
      $textColor = imagecolorallocate($card, $qrColor->getRed(), $qrColor->getGreen(), $qrColor->getBlue());
      $mutedColor = imagecolorallocate($card, 110, 125, 149);
      $accentColor = imagecolorallocate($card, 236, 241, 250);
      $photoBg = imagecolorallocate($card, 240, 243, 252);
      $photoBorder = imagecolorallocate($card, 190, 199, 216);

      imagerectangle($card, 0, 0, $cardWidth - 1, $cardHeight - 1, $borderColor);

      $margin = max(6, $this->cmToPx(0.35));
      $accentHeight = max(4, $this->cmToPx(0.6));
      imagefilledrectangle($card, 0, 0, $cardWidth - 1, $accentHeight, $accentColor);

      // Placeholder foto
      $photoWidth = $this->cmToPx(2.8);
      $photoHeight = $this->cmToPx(3.4);
      $photoX = (int) round(($cardWidth - $photoWidth) / 2);
      $photoY = $accentHeight + $margin;
      imagefilledrectangle($card, $photoX, $photoY, $photoX + $photoWidth, $photoY + $photoHeight, $photoBg);
      imagerectangle($card, $photoX, $photoY, $photoX + $photoWidth, $photoY + $photoHeight, $photoBorder);

      $placeholderLines = ['Tempel', 'Foto'];
      $placeholderFontSize = 16;
      $placeholderSpacing = 4;
      $totalPlaceholderHeight = count($placeholderLines) * $placeholderFontSize + (count($placeholderLines) - 1) * $placeholderSpacing;
      $placeholderY = $photoY + (int) round(($photoHeight - $totalPlaceholderHeight) / 2) + $placeholderFontSize;
      foreach ($placeholderLines as $line) {
         $lineBox = imagettfbbox($placeholderFontSize, 0, $this->fontMedium, $line);
         $lineWidth = $lineBox[2] - $lineBox[0];
         $lineX = $photoX + (int) round(($photoWidth - $lineWidth) / 2);
         imagettftext($card, $placeholderFontSize, 0, $lineX, $placeholderY, $mutedColor, $this->fontMedium, $line);
         $placeholderY += $placeholderFontSize + $placeholderSpacing;
      }

      $maxTextWidth = $cardWidth - (2 * $margin);
      $currentY = $photoY + $photoHeight + $this->cmToPx(0.3);

      $name = trim((string) ($payload['nama'] ?? '')) ?: '-';
      $nameFontSize = 28;
      $nameLines = $this->wrapText(mb_strtoupper($name, 'UTF-8'), $this->fontBold, $nameFontSize, $maxTextWidth);
      foreach ($nameLines as $line) {
         $box = imagettfbbox($nameFontSize, 0, $this->fontBold, $line);
         $lineHeight = abs($box[5] - $box[1]);
         $lineWidth = $box[2] - $box[0];
         $lineX = (int) round(($cardWidth - $lineWidth) / 2);
         imagettftext($card, $nameFontSize, 0, $lineX, $currentY + $lineHeight, $textColor, $this->fontBold, $line);
         $currentY += $lineHeight + 6;
      }

      $currentY += $this->cmToPx(0.15);

      $departemenValue = trim((string) ($payload['departemen'] ?? ''));
      $gradeValue = trim((string) ($payload['grade'] ?? ''));
      if ($gradeValue !== '') {
         $gradeValue = mb_strtoupper($gradeValue, 'UTF-8');
      }

      $infoValues = array_values(array_filter([$departemenValue, $gradeValue], static fn($val) => $val !== null && $val !== ''));
      if (count($infoValues) === 0) {
         $infoValues[] = '-';
      }

      $infoFontSize = 20;
      foreach ($infoValues as $value) {
         $valueLines = $this->wrapText($value, $this->fontRegular, $infoFontSize, $maxTextWidth);
         foreach ($valueLines as $valueLine) {
            $valueBox = imagettfbbox($infoFontSize, 0, $this->fontRegular, $valueLine);
            $valueHeight = abs($valueBox[5] - $valueBox[1]);
            $valueWidth = $valueBox[2] - $valueBox[0];
            $valueX = (int) round(($cardWidth - $valueWidth) / 2);
            imagettftext($card, $infoFontSize, 0, $valueX, $currentY + $valueHeight, $textColor, $this->fontRegular, $valueLine);
            $currentY += $valueHeight + 2;
         }
         $currentY += $this->cmToPx(0.1);
      }

      $qrPadding = max(4, (int) round($this->cmToPx(0.12)));
      $qrX = (int) round(($cardWidth - $qrTargetPx) / 2);
      $availableHeight = $cardHeight - $margin - $qrTargetPx - $currentY;
      $qrY = $currentY + max(0, (int) round($availableHeight / 2));
      $qrY = min($qrY, $cardHeight - $margin - $qrTargetPx);

      imagefilledrectangle($card, $qrX - $qrPadding, $qrY - $qrPadding, $qrX + $qrTargetPx + $qrPadding, $qrY + $qrTargetPx + $qrPadding, $accentColor);
      imagerectangle($card, $qrX - $qrPadding, $qrY - $qrPadding, $qrX + $qrTargetPx + $qrPadding, $qrY + $qrTargetPx + $qrPadding, $borderColor);

      $qrCanvas = imagecreatetruecolor($qrTargetPx, $qrTargetPx);
      imagefill($qrCanvas, 0, 0, imagecolorallocate($qrCanvas, 255, 255, 255));
      imagecopyresampled($qrCanvas, $qrImage, 0, 0, 0, 0, $qrTargetPx, $qrTargetPx, imagesx($qrImage), imagesy($qrImage));
      imagecopy($card, $qrCanvas, $qrX, $qrY, 0, 0, $qrTargetPx, $qrTargetPx);

      $path = $this->qrCodeFilePath . $filename;
      imagepng($card, $path, 9);

      imagedestroy($qrCanvas);
      imagedestroy($qrImage);
      imagedestroy($card);

      return $path;
   }

   protected function wrapText(string $text, string $fontPath, int $fontSize, int $maxWidth): array
   {
      $text = trim($text);
      if ($text === '') {
         return ['-'];
      }

      if ($maxWidth <= 0) {
         return [$text];
      }

      $words = preg_split('/\s+/u', $text) ?: [];
      if (count($words) <= 1) {
         return [$text];
      }

      $lines = [];
      $current = '';
      foreach ($words as $word) {
         $candidate = $current === '' ? $word : $current . ' ' . $word;
         $box = imagettfbbox($fontSize, 0, $fontPath, $candidate);
         $lineWidth = $box[2] - $box[0];
         if ($lineWidth > $maxWidth && $current !== '') {
            $lines[] = $current;
            $current = $word;
         } else {
            $current = $candidate;
         }
      }

      if ($current !== '') {
         $lines[] = $current;
      }

      return $lines ?: ['-'];
   }

   protected function cmToPx(float $cm): int
   {
      $px = (int) round(($cm / 2.54) * $this->dpi);
      return max(1, $px);
   }

   protected function saveFallbackQr(string $filename, WriterInterface $writer): string
   {
      $writer
         ->write(
            qrCode: $this->qrCode,
            logo: $this->logo,
            label: null
         )
         ->saveToFile($this->qrCodeFilePath . $filename);

      return $this->qrCodeFilePath . $filename;
   }

   protected function departemen(string $unique_code)
   {
      return self::UPLOADS_PATH . DIRECTORY_SEPARATOR . "qr-karyawan/{$unique_code}.png";
   }

   protected function getDepartemenJabatanSlug(?string $idDepartemen)
   {
      if ($idDepartemen === null) {
         return false;
      }

      $departemen = $this->departemenModel->getDepartemen($idDepartemen);
      if ($departemen) {
         return url_title(($departemen->departemen ?? '') . ' ' . ($departemen->jabatan ?? ''), lowercase: true);
      }

      return false;
   }
}
