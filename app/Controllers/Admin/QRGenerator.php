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

   const UPLOADS_PATH = FCPATH . 'uploads' . DIRECTORY_SEPARATOR;

   public function __construct()
   {
      $this->setQrCodeFilePath(self::UPLOADS_PATH);

      $this->writer = new PngWriter();

      $this->labelFont = new Font(FCPATH . 'assets/fonts/Roboto-Medium.ttf', 14);

      $this->foregroundColor = new Color(44, 73, 162);
      $this->foregroundColor2 = new Color(28, 101, 90);
      $this->backgroundColor = new Color(255, 255, 255);

      if (boolval(env('QR_LOGO'))) {
         // Create logo
         $logo = (new \Config\School)::$generalSettings->logo;
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

      $this->generate(
         unique_code: $this->request->getVar('unique_code'),
         nama: $this->request->getVar('nama'),
         nomor: $this->request->getVar('nomor')
      );

      return $this->response->setJSON(true);
   }

   public function generateQrAdmin()
   {
      $this->qrCode->setForegroundColor($this->foregroundColor2);
      $this->label->setTextColor($this->foregroundColor2);

      $this->qrCodeFilePath .= 'qr-admin/';

      if (!file_exists($this->qrCodeFilePath)) {
         mkdir($this->qrCodeFilePath, recursive: true);
      }

      $this->generate(
         unique_code: $this->request->getVar('unique_code'),
         nama: $this->request->getVar('nama'),
         nomor: $this->request->getVar('nomor')
      );

      return $this->response->setJSON(true);
   }

   public function generate($nama, $nomor, $unique_code)
   {
      $fileExt = $this->writer instanceof SvgWriter ? 'svg' : 'png';
      $filename = url_title($nama, lowercase: true) . "_" . url_title($nomor, lowercase: true) . ".$fileExt";

      // set qr code data
      $this->qrCode->setData($unique_code);

      $this->label->setText($nama);

      // Save it to a file
      $this->writer
         ->write(
            qrCode: $this->qrCode,
            logo: $this->logo,
            label: $this->label
         )
         ->saveToFile(
            path: $this->qrCodeFilePath . $filename
         );

      return $this->qrCodeFilePath . $filename;
   }

   public function downloadQrKaryawan($idKaryawan = null)
   {
      $karyawan = (new KaryawanModel)->find($idKaryawan);
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
      $admin = (new AdminModel)->find($idAdmin);
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

         $this->qrCodeFilePath .= 'qr-admin/';

         if (!file_exists($this->qrCodeFilePath)) {
            mkdir($this->qrCodeFilePath, recursive: true);
         }

         return $this->response->download(
            $this->generate(
               nama: $admin['nama_admin'],
               nomor: $admin['nuptk'],
               unique_code: $admin['unique_code'],
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
         $output = self::UPLOADS_PATH . 'qrcode-karyawan' . ($departemen ? "_{$departemen}.zip" : '.zip');

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
         $output = self::UPLOADS_PATH . DIRECTORY_SEPARATOR . 'qrcode-admin.zip';

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
      $zip->open($output, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

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

   protected function departemen(string $unique_code)
   {
      return self::UPLOADS_PATH . DIRECTORY_SEPARATOR . "qr-karyawan/{$unique_code}.png";
   }

   protected function getDepartemenJabatanSlug(string $idDepartemen)
   {
      $departemen = (new DepartemenModel)->getDepartemen($idDepartemen);;
      if ($departemen) {
         return url_title($departemen->departemen . ' ' . $departemen->jabatan, lowercase: true);
      } else {
         return false;
      }
   }
}
