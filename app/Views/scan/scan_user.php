<!DOCTYPE html>
<html lang="id">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Absensi QR Code - <?= $waktu ?? 'Masuk'; ?></title>
   
   <!-- Theme Bootstrapper -->
   <script>
      (function () {
         var KEY = 'ui-theme';
         try {
            var saved = localStorage.getItem(KEY);
            if (saved !== 'light' && saved !== 'dark') {
               var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
               saved = prefersDark ? 'dark' : 'light';
               localStorage.setItem(KEY, saved);
            }
            document.documentElement.setAttribute('data-theme', saved);
         } catch (e) {
            document.documentElement.setAttribute('data-theme', 'light');
         }
      })();
   </script>
   
   <!-- CSS Files -->
   <link href="<?= base_url('assets/fonts/fonts.css?v=1.0.0'); ?>" rel="stylesheet" />
   <link href="<?= base_url('assets/css/material-dashboard.css'); ?>" rel="stylesheet" />
   <link href="<?= base_url('assets/css/style.css?v=1.0.0'); ?>" rel="stylesheet" />
   
   <style>
   :root {
      --bg: #eef3fb;
      --bg-accent: #e5efff;
      --card: #ffffff;
      --text: #1f2937;
      --text-muted: #6b7280;
      --border: rgba(16, 24, 40, 0.12);
      --primary: #667eea;
      --success: #10b981;
      --warning: #f59e0b;
      --danger: #ef4444;
      --info: #3b82f6;
   }
   
   [data-theme="dark"] {
      --bg: #0a0f1a;
      --bg-accent: #141b2d;
      --card: #1a2332;
      --text: #f0f4ff;
      --text-muted: #b8c5d9;
      --border: rgba(200, 210, 230, 0.2);
      --primary: #8bb4ff;
      --success: #4ade80;
      --warning: #fcd34d;
      --danger: #f87171;
      --info: #60a5fa;
   }
   
   body {
      background: var(--bg);
      color: var(--text);
      font-family: 'Roboto', sans-serif;
      margin: 0;
      padding: 20px;
      transition: background-color 0.3s ease, color 0.3s ease;
   }
   
   .theme-toggle-btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 10px 16px;
      border-radius: 12px;
      border: 1px solid var(--border);
      background: var(--card);
      color: var(--text);
      cursor: pointer;
      font-weight: 600;
      font-size: 0.95rem;
      transition: all 0.3s ease;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
   }
   
   [data-theme="dark"] .theme-toggle-btn {
      background: var(--card);
      color: var(--text);
      border-color: var(--border);
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
   }
   
   .theme-toggle-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
   }
   
   [data-theme="dark"] .theme-toggle-btn:hover {
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
      background: var(--bg-accent);
   }
   
   .theme-toggle-btn .material-icons {
      font-size: 20px;
   }
   
   .card {
      background: var(--card) !important;
      color: var(--text) !important;
      border-color: var(--border) !important;
   }
   
   .card-body {
      background: var(--card) !important;
      color: var(--text) !important;
   }
   
   .text-muted {
      color: var(--text-muted) !important;
   }
   
   .form-control, .form-select {
      background: var(--card) !important;
      color: var(--text) !important;
      border-color: var(--border) !important;
   }
   
   [data-theme="dark"] .form-control,
   [data-theme="dark"] .form-select {
      background: var(--card) !important;
      color: var(--text) !important;
      border-color: var(--border) !important;
   }
   
   .form-control:focus, .form-select:focus {
      background: var(--card) !important;
      color: var(--text) !important;
      border-color: var(--primary) !important;
      box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
   }
   
   [data-theme="dark"] .form-control:focus,
   [data-theme="dark"] .form-select:focus {
      border-color: var(--primary) !important;
      box-shadow: 0 0 0 3px rgba(139, 180, 255, 0.2);
   }
   
   /* Button Styles untuk Dark Mode */
   [data-theme="dark"] .btn {
      color: var(--text) !important;
   }
   
   [data-theme="dark"] .btn-secondary {
      background-color: var(--bg-accent) !important;
      border-color: var(--border) !important;
      color: var(--text) !important;
   }
   
   [data-theme="dark"] .btn-secondary:hover {
      background-color: var(--card) !important;
      color: var(--text) !important;
   }
   
   [data-theme="dark"] .btn-light {
      background-color: var(--card) !important;
      border-color: var(--border) !important;
      color: var(--text) !important;
   }
   
   [data-theme="dark"] .btn-light:hover {
      background-color: var(--bg-accent) !important;
      color: var(--text) !important;
   }
   
   [data-theme="dark"] .btn-danger {
      background-color: var(--danger) !important;
      border-color: var(--danger) !important;
      color: #ffffff !important;
   }
   
   [data-theme="dark"] .btn-danger:hover {
      background-color: #ef4444 !important;
      color: #ffffff !important;
   }
   
   [data-theme="dark"] .btn-success {
      background-color: var(--success) !important;
      border-color: var(--success) !important;
      color: #ffffff !important;
   }
   
   /* Professional Button Group Styling */
   .scan-mode-group {
      display: flex;
      gap: 0;
      background: var(--card);
      border: 2px solid var(--border);
      border-radius: 14px;
      padding: 4px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      transition: all 0.3s ease;
   }
   
   .scan-mode-group:hover {
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
   }
   
   /* Hide radio button input completely */
   .scan-mode-group .btn-check {
      position: absolute !important;
      opacity: 0 !important;
      pointer-events: none !important;
      width: 0 !important;
      height: 0 !important;
      margin: 0 !important;
      padding: 0 !important;
      border: none !important;
      clip: rect(0, 0, 0, 0) !important;
   }
   
   /* Remove all radio button indicators */
   .scan-mode-group .btn-check::before,
   .scan-mode-group .btn-check::after {
      display: none !important;
      content: none !important;
   }
   
   /* Remove any default radio button styling */
   .scan-mode-group input[type="radio"] {
      display: none !important;
   }
   
   .scan-mode-btn {
      flex: 1;
      padding: 16px 24px;
      border: none;
      border-radius: 10px;
      font-weight: 600;
      font-size: 0.95rem;
      letter-spacing: 0.3px;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      background: transparent;
      color: var(--text-muted);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      cursor: pointer;
      position: relative;
      overflow: hidden;
   }
   
   /* Gradient background overlay for hover effect */
   .scan-mode-btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(135deg, var(--primary) 0%, rgba(102, 126, 234, 0.8) 100%);
      opacity: 0;
      transition: opacity 0.3s ease;
      border-radius: 10px;
      z-index: 0;
   }
   
   .scan-mode-btn i {
      position: relative;
      z-index: 1;
      font-size: 22px;
      transition: transform 0.3s ease;
   }
   
   .scan-mode-btn span {
      position: relative;
      z-index: 1;
   }
   
   .scan-mode-btn:hover {
      color: var(--primary);
      transform: translateY(-1px);
   }
   
   .scan-mode-btn:hover i {
      transform: scale(1.1);
   }
   
   .btn-check:checked + .scan-mode-btn {
      background: linear-gradient(135deg, var(--primary) 0%, rgba(102, 126, 234, 0.9) 100%);
      color: #ffffff;
      box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
      transform: translateY(-1px);
   }
   
   .btn-check:checked + .scan-mode-btn::before {
      opacity: 0;
   }
   
   .btn-check:checked + .scan-mode-btn i {
      transform: scale(1.1);
      color: #ffffff;
   }
   
   [data-theme="dark"] .btn-check:checked + .scan-mode-btn {
      background: linear-gradient(135deg, var(--primary) 0%, rgba(139, 180, 255, 0.9) 100%);
      box-shadow: 0 4px 12px rgba(139, 180, 255, 0.3);
   }
   
   /* Professional Select Styling */
   .camera-select-wrapper {
      position: relative;
   }
   
   .camera-select-wrapper::after {
      content: 'expand_more';
      font-family: 'Material Icons';
      position: absolute;
      right: 16px;
      top: 50%;
      transform: translateY(-50%);
      pointer-events: none;
      color: var(--text-muted);
      font-size: 24px;
      z-index: 1;
   }
   
   .camera-select {
      appearance: none;
      -webkit-appearance: none;
      -moz-appearance: none;
      background: var(--card);
      border: 2px solid var(--border);
      border-radius: 14px;
      padding: 16px 48px 16px 20px;
      font-size: 0.95rem;
      font-weight: 500;
      letter-spacing: 0.2px;
      line-height: 1.5;
      color: var(--text);
      cursor: pointer;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
      width: 100%;
   }
   
   .camera-select:hover {
      border-color: var(--primary);
      box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
      transform: translateY(-1px);
   }
   
   .camera-select:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1), 0 4px 12px rgba(102, 126, 234, 0.2);
      transform: translateY(-1px);
   }
   
   [data-theme="dark"] .camera-select {
      background: var(--card);
      border-color: var(--border);
      color: var(--text);
   }
   
   [data-theme="dark"] .camera-select:hover {
      border-color: var(--primary);
      box-shadow: 0 4px 12px rgba(139, 180, 255, 0.2);
   }
   
   [data-theme="dark"] .camera-select:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 4px rgba(139, 180, 255, 0.15), 0 4px 12px rgba(139, 180, 255, 0.25);
   }
   
   [data-theme="dark"] .btn-outline-primary {
      border-color: var(--primary) !important;
      color: var(--primary) !important;
      background-color: transparent !important;
   }
   
   [data-theme="dark"] .btn-check:checked + .btn-outline-primary {
      background-color: var(--primary) !important;
      border-color: var(--primary) !important;
      color: #ffffff !important;
   }
   
   /* Card Background untuk Dark Mode */
   [data-theme="dark"] .card {
      background: var(--card) !important;
   }
   
   [data-theme="dark"] .card[style*="background: linear-gradient"] {
      background: linear-gradient(135deg, var(--bg-accent) 0%, var(--card) 100%) !important;
   }
   
   /* Preview Parent untuk Dark Mode */
   [data-theme="dark"] .previewParent {
      background: var(--bg-accent) !important;
      border-color: var(--border) !important;
   }
   
   [data-theme="dark"] .previewParent::after {
      background: rgba(0, 0, 0, 0.8);
      color: var(--text);
   }
   
   /* Alert untuk Dark Mode */
   [data-theme="dark"] .alert {
      background-color: var(--bg-accent) !important;
      border-color: var(--border) !important;
      color: var(--text) !important;
   }
   
   [data-theme="dark"] .alert-info {
      background-color: rgba(96, 165, 250, 0.15) !important;
      border-color: var(--info) !important;
      color: var(--text) !important;
   }
   
   /* Select border untuk Dark Mode */
   [data-theme="dark"] select#pilihKamera {
      border-color: var(--border) !important;
   }
   
   [data-theme="dark"] input#usbScanInput {
      border-color: var(--border) !important;
      background: var(--card) !important;
      color: var(--text) !important;
   }
   
   [data-theme="dark"] input#usbScanInput::placeholder {
      color: var(--text-muted) !important;
   }
   
   /* Spinner untuk Dark Mode */
   [data-theme="dark"] .spinner-border.text-primary {
      color: var(--primary) !important;
      border-color: var(--primary) !important;
   }
   
   /* Button Switch Dark Mode Hover */
   .btn-switch-dark:hover {
      background: rgba(255, 255, 255, 0.35) !important;
      border-color: rgba(255, 255, 255, 0.45) !important;
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
   }
   
   /* Card Header Gradient */
   .card-header-gradient {
      position: relative;
      overflow: hidden;
   }
   
   .card-header-gradient::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, transparent 100%);
      pointer-events: none;
   }
   
   /* Improved spacing and alignment */
   .card-body {
      padding: 2rem !important;
   }
   
   @media (max-width: 768px) {
      .card-header-gradient {
         padding: 1.25rem !important;
      }
      
      .card-header-gradient h3 {
         font-size: 1.75rem !important;
      }
      
      .card-header-gradient h4 {
         font-size: 1.25rem !important;
      }
      
      .btn-switch-dark {
         padding: 8px 12px !important;
         font-size: 0.85rem !important;
      }
   }
   .scan-header {
      margin-top: 2rem;
      margin-bottom: 2rem;
      padding: 2rem;
      background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(118, 75, 162, 0.08) 100%);
      border-radius: 16px;
      border-left: 4px solid var(--primary);
   }
   
   [data-theme="dark"] .scan-header {
      background: linear-gradient(135deg, rgba(139, 180, 255, 0.15) 0%, rgba(118, 75, 162, 0.2) 100%);
      border-left-color: var(--primary);
   }
   
   [data-theme="dark"] hr {
      border-color: var(--border) !important;
      opacity: 0.5;
   }
   
   .scan-header h2 {
      font-size: 2.25rem;
      font-weight: 800;
      line-height: 1.3;
      margin-bottom: 0.5rem;
      color: var(--text);
      letter-spacing: 0.3px;
   }
   
   .scan-header p {
      font-size: 1.05rem;
      font-weight: 400;
      margin-bottom: 0;
      color: var(--text-muted);
      line-height: 1.5;
      letter-spacing: 0.1px;
   }
   
   /* Memastikan garis tidak bertabrakan */
   .scan-header + hr {
      margin-left: 1.5rem;
      margin-right: 1.5rem;
      margin-top: 2rem;
      margin-bottom: 0;
   }
   
   /* Memastikan tidak bertabrakan dengan sidebar */
   .container-fluid {
      margin-left: auto;
      margin-right: auto;
      padding-left: 1rem;
      padding-right: 1rem;
      max-width: 1400px;
   }
   
   /* Mobile-first improvements */
   .previewParent {
      position: relative;
      overflow: hidden;
      border-radius: 8px;
   }
   
   .previewParent::before {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 200px;
      height: 200px;
      border: 2px solid #007bff;
      border-radius: 8px;
      pointer-events: none;
      z-index: 10;
      opacity: 0.7;
   }
   
   .previewParent::after {
      content: 'Arahkan kamera ke QR Code';
      position: absolute;
      bottom: 10px;
      left: 50%;
      transform: translateX(-50%);
      background: rgba(0, 0, 0, 0.7);
      color: white;
      padding: 5px 10px;
      border-radius: 4px;
      font-size: 0.8rem;
      pointer-events: none;
      z-index: 10;
   }
   
   /* Responsive Design */
   @media (max-width: 1200px) {
      .col-xl-4 {
         flex: 0 0 50%;
         max-width: 50%;
      }
   }
   
   @media (max-width: 992px) {
      .col-lg-3, .col-lg-6 {
         flex: 0 0 100%;
         max-width: 100%;
         margin-bottom: 1rem;
      }
      
      .card-body {
         padding: 1rem;
      }
   }
   
   @media (max-width: 768px) {
      .scan-header h2 {
         font-size: 1.5rem;
      }
      
      .scan-header {
         margin-top: 1rem;
         margin-bottom: 1.5rem;
         padding-top: 1rem;
         padding-bottom: 1rem;
         flex-direction: column;
         align-items: flex-start !important;
      }
      
      .scan-header .btn {
         margin-top: 0.5rem;
         align-self: flex-start;
      }
      
      .container-fluid {
         padding-left: 0.5rem;
         padding-right: 0.5rem;
      }
      
      .scan-header + hr {
         margin-left: 1rem;
         margin-right: 1rem;
         margin-top: 1.5rem;
      }
      
      .card-header .row {
         flex-direction: column;
         align-items: flex-start !important;
      }
      
      .card-header .col-auto {
         margin-top: 0.5rem;
         width: 100%;
      }
      
      .card-header .btn {
         width: 100%;
      }
      
      .previewParent {
         height: 250px !important;
      }
      
      .previewParent::before {
         width: 150px;
         height: 150px;
      }
      
      #preview {
         height: 250px !important;
      }
      
      .form-select {
         font-size: 0.9rem;
      }
   }
   
   @media (max-width: 576px) {
      .scan-header h2 {
         font-size: 1.25rem;
      }
      
      .scan-header p {
         font-size: 0.9rem;
      }
      
      .card-title {
         font-size: 1.1rem;
      }
      
      .card-category {
         font-size: 0.85rem;
      }
      
      .previewParent {
         height: 200px !important;
      }
      
      .previewParent::before {
         width: 120px;
         height: 120px;
      }
      
      .previewParent::after {
         font-size: 0.7rem;
         padding: 3px 8px;
      }
      
      #preview {
         height: 200px !important;
      }
      
      .notification-floating {
         top: 5px;
         right: 5px;
         left: 5px;
         max-width: none;
         min-width: auto;
         font-size: 0.9rem;
      }
      
      .notification-header {
         padding: 10px 15px;
      }
      
      .notification-body {
         padding: 10px 15px;
      }
   }

   /* Floating Notification Styles */
   .notification-floating {
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 9999;
      max-width: 420px;
      min-width: 320px;
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
      border-radius: 16px;
      animation: slideInRight 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      overflow: hidden;
   }

   .notification-content {
      background: var(--card);
      border-radius: 16px;
      overflow: hidden;
   }

   .notification-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 18px 24px;
      border-bottom: 1px solid rgba(0, 0, 0, 0.05);
      position: relative;
   }

   .notification-header::before {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      bottom: 0;
      width: 4px;
   }

   .notification-header h5 {
      margin: 0;
      font-weight: 700;
      font-size: 1.1rem;
      display: flex;
      align-items: center;
      gap: 10px;
   }

   .notification-header h5::before {
      content: '';
      width: 8px;
      height: 8px;
      border-radius: 50%;
      display: inline-block;
   }

   .notification-body {
      padding: 20px 24px;
      background: var(--bg-accent);
   }

   .notification-body p {
      margin-bottom: 0.5rem;
      font-size: 0.95rem;
      color: var(--text-muted);
   }

   .notification-body p strong {
      color: var(--text);
      font-weight: 600;
   }

   .notification-success .notification-header {
      background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
      color: #065f46;
   }

   .notification-success .notification-header::before {
      background: #10b981;
   }

   .notification-success .notification-header h5::before {
      background: #10b981;
   }

   .notification-error .notification-header {
      background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
      color: #991b1b;
   }

   .notification-error .notification-header::before {
      background: #ef4444;
   }

   .notification-error .notification-header h5::before {
      background: #ef4444;
   }

   .btn-close {
      background: none;
      border: none;
      font-size: 1.2rem;
      cursor: pointer;
      padding: 0;
      width: 20px;
      height: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
   }

   @keyframes slideInRight {
      from {
         transform: translateX(100%);
         opacity: 0;
      }
      to {
         transform: translateX(0);
         opacity: 1;
      }
   }

   @media (max-width: 768px) {
      .notification-floating {
         top: 10px;
         right: 10px;
         left: 10px;
         max-width: none;
         min-width: auto;
      }
   }
   </style>
</head>
<body>

<?php
   $oppBtn = '';

   $waktu == 'Masuk' ? $oppBtn = 'pulang' : $oppBtn = 'masuk';
   ?>
<div class="container-fluid">
         <!-- Header dengan Button Kembali -->
         <div class="row mb-4">
            <div class="col-12">
               <div class="d-flex justify-content-between align-items-center scan-header">
                  <div>
                    <br>
                     <h2><b>Absensi Karyawan dan Admin Berbasis QR Code</b></h2>
                     <p class="text-muted">Sistem absensi menggunakan QR Code</p>
                  </div>
                  <div class="d-flex gap-2 align-items-center">
                     <button class="theme-toggle-btn" type="button" onclick="toggleTheme()" aria-label="Toggle theme">
                        <i class="material-icons" id="themeIcon">dark_mode</i>
                        <span id="themeText">Gelap</span>
                     </button>
                     <a href="<?= base_url('scan'); ?>" class="btn btn-secondary">
                        <i class="material-icons mr-2">arrow_back</i>
                        Kembali
                     </a>
                  </div>
               </div>
               <hr class="mt-3">
            </div>
         </div>
         
         <div class="row g-4 justify-content-center">
            <div class="col-lg-3 col-xl-4">
               <div class="card shadow-sm border-0" style="border-radius: 16px; background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);">
                  <div class="card-body">
                     <h4 class="mb-4" style="font-weight: 700; color: var(--text); font-size: 1.25rem; letter-spacing: 0.2px; line-height: 1.4;">
                        <i class="material-icons mr-2" style="vertical-align: middle; color: var(--success); line-height: 1;">lightbulb</i>
                        Tips Penggunaan
                     </h4>
                     <div class="mb-3">
                        <div class="d-flex align-items-start mb-3 p-3 tip-item-dark" style="background: var(--card); border-radius: 12px; border-left: 4px solid var(--success);">
                           <i class="material-icons text-success mr-3" style="font-size: 24px; margin-top: 2px; color: var(--success); line-height: 1;">visibility</i>
                           <div>
                              <strong style="color: var(--text); display: block; margin-bottom: 6px; font-weight: 600; font-size: 0.95rem; letter-spacing: 0.2px; line-height: 1.4;">Tunjukkan QR Code dengan jelas</strong>
                              <small class="text-muted" style="font-size: 0.875rem; line-height: 1.5; letter-spacing: 0.1px;">Pastikan QR Code terlihat jelas di kamera</small>
                           </div>
                        </div>
                        <div class="d-flex align-items-start p-3 tip-item-dark" style="background: var(--card); border-radius: 12px; border-left: 4px solid var(--success);">
                           <i class="material-icons text-success mr-3" style="font-size: 24px; margin-top: 2px; color: var(--success); line-height: 1;">center_focus_strong</i>
                           <div>
                              <strong style="color: var(--text); display: block; margin-bottom: 6px; font-weight: 600; font-size: 0.95rem; letter-spacing: 0.2px; line-height: 1.4;">Posisikan dengan benar</strong>
                              <small class="text-muted" style="font-size: 0.875rem; line-height: 1.5; letter-spacing: 0.1px;">Jaga jarak optimal antara QR Code dan kamera</small>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-lg-6 col-xl-4">
               <div class="card shadow-sm border-0" style="border-radius: 16px;">
                  <div class="card-header card-header-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 16px 16px 0 0; padding: 2rem;">
                     <div class="text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                           <i class="material-icons mr-3" style="font-size: 36px; color: white; opacity: 0.95; line-height: 1;">qr_code_scanner</i>
                           <h3 class="card-title mb-0" style="font-weight: 800; font-size: 2.5rem; color: white; line-height: 1.2; letter-spacing: 0.5px;">
                              Absen <?= $waktu; ?>
                           </h3>
                        </div>
                        <p class="mb-4" style="font-size: 1rem; color: rgba(255, 255, 255, 0.95); font-weight: 400; line-height: 1.5;">
                           Silahkan tunjukkan QR Code anda
                        </p>
                        <div class="text-center">
                           <a href="<?= base_url("scan/$oppBtn"); ?>" class="btn btn-light btn-sm btn-switch-dark" style="border-radius: 12px; font-weight: 600; background: rgba(255, 255, 255, 0.25); border: 1px solid rgba(255, 255, 255, 0.35); color: white; padding: 12px 24px; white-space: nowrap; transition: all 0.3s ease; font-size: 0.95rem; letter-spacing: 0.3px; display: inline-flex; align-items: center; justify-content: center; margin: 0 auto;">
                              <i class="material-icons mr-2" style="font-size: 20px; vertical-align: middle; line-height: 1;">swap_horiz</i>
                              Absen <?= $oppBtn; ?>
                           </a>
                        </div>
                     </div>
                  </div>
                  <div class="card-body" style="padding: 2rem;">
                     <!-- Toggle Scan Mode -->
                     <div class="mb-4">
                        <label class="form-label d-flex align-items-center mb-3" style="font-weight: 600; color: var(--text); font-size: 1.05rem; letter-spacing: 0.2px;">
                           <i class="material-icons mr-2" style="font-size: 22px; color: var(--text); line-height: 1;">settings</i>
                           <span>Mode Scan</span>
                        </label>
                        <div class="scan-mode-group" role="group">
                           <input type="radio" class="btn-check" name="scanMode" id="cameraMode" value="camera" checked>
                           <label class="scan-mode-btn" for="cameraMode">
                              <i class="material-icons">camera_alt</i>
                              <span>Kamera</span>
                           </label>
                           
                           <input type="radio" class="btn-check" name="scanMode" id="usbMode" value="usb">
                           <label class="scan-mode-btn" for="usbMode">
                              <i class="material-icons">usb</i>
                              <span>USB Scanner</span>
                           </label>
                        </div>
                     </div>

                     <!-- Camera Mode Section -->
                     <div id="cameraModeSection">
                        <div class="mb-4">
                           <label class="form-label d-flex align-items-center mb-3" style="font-weight: 600; color: var(--text); font-size: 1.05rem; letter-spacing: 0.2px;">
                              <i class="material-icons mr-2" style="font-size: 22px; color: var(--text); line-height: 1;">videocam</i>
                              <span>Pilih Kamera</span>
                           </label>
                           <div class="camera-select-wrapper">
                              <select id="pilihKamera" class="camera-select" aria-label="Pilih kamera">
                                 <option selected>Pilih kamera yang tersedia</option>
                              </select>
                           </div>
                        </div>

                        <div class="mb-3">
                           <div class="previewParent border rounded" style="background: var(--bg-accent); border-radius: 16px; overflow: hidden; border: 2px solid var(--border) !important; min-height: 400px; display: flex; align-items: center; justify-content: center;">
                              <div class="text-center py-5 w-100" id="searching">
                                 <div class="spinner-border text-primary mb-4" role="status" style="width: 3.5rem; height: 3.5rem; border-width: 4px;">
                                    <span class="visually-hidden">Loading...</span>
                                 </div>
                                 <p class="mt-3 mb-0 d-flex align-items-center justify-content-center" style="font-weight: 600; color: var(--text-muted); font-size: 1.05rem; letter-spacing: 0.2px; line-height: 1.5;">
                                    <i class="material-icons mr-2" style="font-size: 24px; color: var(--text-muted); line-height: 1;">search</i>
                                    <span>Mencari kamera...</span>
                                 </p>
                              </div>
                              <video id="preview" class="w-100 rounded" style="height: 400px; object-fit: cover; display: none;"></video>
                           </div>
                        </div>
                     </div>

                     <!-- USB Scanner Mode Section -->
                     <div id="usbModeSection" style="display: none;">
                        <div class="mb-4">
                           <label class="form-label d-flex align-items-center mb-3" style="font-weight: 600; color: var(--text); font-size: 1.05rem; letter-spacing: 0.2px;">
                              <i class="material-icons mr-2" style="font-size: 22px; color: var(--text); line-height: 1;">keyboard</i>
                              <span>Scan QR Code dengan USB Scanner</span>
                           </label>
                           <input type="text" id="usbScanInput" class="form-control form-control-lg" placeholder="Arahkan USB Scanner ke QR Code dan scan..." autofocus style="font-size: 1.05rem; padding: 16px 18px; border-radius: 12px; border: 2px solid var(--border); font-weight: 500; letter-spacing: 0.2px; line-height: 1.5;">
                           <small class="text-muted d-flex align-items-center mt-3" style="font-size: 0.875rem; line-height: 1.5; letter-spacing: 0.1px;">
                              <i class="material-icons mr-2" style="font-size: 18px; vertical-align: middle; color: var(--text-muted); line-height: 1;">info</i>
                              <span>Klik pada kolom input ini, lalu scan QR Code dengan USB scanner Anda</span>
                           </small>
                        </div>
                        <div class="alert alert-info d-flex align-items-start" style="border-radius: 12px; padding: 16px; margin-bottom: 0; line-height: 1.6;">
                           <i class="material-icons mr-2" style="font-size: 20px; margin-top: 2px; color: var(--info); line-height: 1;">lightbulb</i>
                           <div>
                              <strong style="color: var(--text); display: block; margin-bottom: 6px; font-weight: 600; letter-spacing: 0.2px;">Petunjuk:</strong>
                              <span style="color: var(--text-muted); font-size: 0.9rem; letter-spacing: 0.1px; line-height: 1.6;">Pastikan kursor ada di kolom input, lalu arahkan USB scanner ke QR Code. Sistem akan otomatis memproses setelah scan.</span>
                           </div>
                        </div>
                     </div>

                     <form id="formAbsen" action="<?= base_url('scan/cek'); ?>" method="post">
                        <input type="hidden" name="unique_code" id="unique_code">
                        <input type="hidden" name="waktu" value="<?= strtolower($waktu); ?>">
                     </form>

                     <!-- Floating Notification -->
                     <div id="notification" class="notification-floating" style="display: none;">
                        <div class="notification-content">
                           <div class="notification-header">
                              <h5 id="notification-title"></h5>
                              <button type="button" class="btn-close" onclick="hideNotification()"></button>
                           </div>
                           <div class="notification-body" id="notification-body">
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-lg-3 col-xl-4">
               <div class="card shadow-sm border-0" style="border-radius: 16px; background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);">
                  <div class="card-body">
                     <h4 class="mb-4" style="font-weight: 700; color: var(--text); font-size: 1.25rem; letter-spacing: 0.2px; line-height: 1.4;">
                        <i class="material-icons mr-2" style="vertical-align: middle; color: var(--info); line-height: 1;">info</i>
                        Informasi
                     </h4>
                     <div class="mb-4">
                        <div class="d-flex align-items-start mb-3 p-3 info-item-dark" style="background: var(--card); border-radius: 12px; border-left: 4px solid var(--info);">
                           <i class="material-icons text-info mr-3" style="font-size: 24px; margin-top: 2px; color: var(--info); line-height: 1;">check_circle</i>
                           <div>
                              <strong style="color: var(--text); display: block; margin-bottom: 6px; font-weight: 600; font-size: 0.95rem; letter-spacing: 0.2px; line-height: 1.4;">QR Code dalam kondisi baik</strong>
                              <small class="text-muted" style="font-size: 0.875rem; line-height: 1.5; letter-spacing: 0.1px;">Pastikan QR Code tidak rusak atau terlipat</small>
                           </div>
                        </div>
                        <div class="d-flex align-items-start mb-3 p-3 info-item-dark" style="background: var(--card); border-radius: 12px; border-left: 4px solid var(--info);">
                           <i class="material-icons text-info mr-3" style="font-size: 24px; margin-top: 2px; color: var(--info); line-height: 1;">wifi</i>
                           <div>
                              <strong style="color: var(--text); display: block; margin-bottom: 6px; font-weight: 600; font-size: 0.95rem; letter-spacing: 0.2px; line-height: 1.4;">Koneksi internet stabil</strong>
                              <small class="text-muted" style="font-size: 0.875rem; line-height: 1.5; letter-spacing: 0.1px;">Pastikan koneksi internet berjalan dengan baik</small>
                           </div>
                        </div>
                        <div class="d-flex align-items-start p-3 info-item-dark" style="background: var(--card); border-radius: 12px; border-left: 4px solid var(--info);">
                           <i class="material-icons text-info mr-3" style="font-size: 24px; margin-top: 2px; color: var(--info); line-height: 1;">support_agent</i>
                           <div>
                              <strong style="color: var(--text); display: block; margin-bottom: 6px; font-weight: 600; font-size: 0.95rem; letter-spacing: 0.2px; line-height: 1.4;">Butuh bantuan?</strong>
                              <small class="text-muted" style="font-size: 0.875rem; line-height: 1.5; letter-spacing: 0.1px;">Hubungi admin jika mengalami masalah</small>
                           </div>
                        </div>
                     </div>
                     
                     <!-- Button Logout untuk User -->
                     <?php if (session()->get('logged_in')): ?>
                     <div class="d-grid">
                        <a href="<?= base_url('scan/logout'); ?>" class="btn btn-danger" style="border-radius: 12px; font-weight: 600; padding: 12px; box-shadow: 0 4px 6px rgba(239, 68, 68, 0.2);">
                           <i class="material-icons mr-2" style="vertical-align: middle;">logout</i>
                           Logout
                        </a>
                     </div>
                     <?php endif; ?>
                  </div>
               </div>
            </div>
         </div>

<script type="text/javascript" src="<?= base_url('assets/js/core/jquery-3.5.1.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/plugins/zxing/zxing.min.js') ?>"></script>
<script type="text/javascript">
   let selectedDeviceId = null;
   let audio = new Audio("<?= base_url('assets/audio/beep.mp3'); ?>");
   const codeReader = new ZXing.BrowserMultiFormatReader();
   const sourceSelect = $('#pilihKamera');
   let currentMode = 'camera';

   // Toggle between Camera and USB Scanner mode
   $(document).on('change', 'input[name="scanMode"]', function() {
      currentMode = $(this).val();
      
      if (currentMode === 'camera') {
         // Show camera section, hide USB section
         $('#cameraModeSection').show();
         $('#usbModeSection').hide();
         
         // Stop any existing camera stream first
         if (codeReader) {
            codeReader.reset();
         }
         
         // Reinitialize scanner
         if (navigator.mediaDevices) {
            initScanner();
         }
      } else {
         // Show USB section, hide camera section
         $('#cameraModeSection').hide();
         $('#usbModeSection').show();
         
         // Stop camera
         if (codeReader) {
            codeReader.reset();
         }
         
         // Focus on USB input
         $('#usbScanInput').focus();
      }
   });

   // Handle USB Scanner Input
   let usbScanBuffer = '';
   let usbScanTimeout = null;
   
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

   // Handle Enter key for USB scanner
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

   function processUSBScan(code) {
      console.log('USB Scanner detected code:', code);
      audio.play();
      cekData(code);
      
      // Re-focus input for next scan after delay
      setTimeout(() => {
         $('#usbScanInput').focus();
      }, 2500);
   }

   $(document).on('change', '#pilihKamera', function() {
      selectedDeviceId = $(this).val();
      if (codeReader) {
         codeReader.reset();
         initScanner();
      }
   })

   const previewParent = document.getElementById('previewParent');
   const preview = document.getElementById('preview');

   function initScanner() {
      codeReader.listVideoInputDevices()
         .then(videoInputDevices => {
            videoInputDevices.forEach(device =>
               console.log(`${device.label}, ${device.deviceId}`)
            );

            if (videoInputDevices.length < 1) {
               alert("Camera not found!");
               return;
            }

            if (selectedDeviceId == null) {
               if (videoInputDevices.length <= 1) {
                  selectedDeviceId = videoInputDevices[0].deviceId
               } else {
                  selectedDeviceId = videoInputDevices[1].deviceId
               }
            }

            if (videoInputDevices.length >= 1) {
               sourceSelect.html('');
               videoInputDevices.forEach((element) => {
                  const sourceOption = document.createElement('option')
                  sourceOption.text = element.label
                  sourceOption.value = element.deviceId
                  if (element.deviceId == selectedDeviceId) {
                     sourceOption.selected = 'selected';
                  }
                  sourceSelect.append(sourceOption)
               })
            }

            $('#previewParent').removeClass('unpreview');
            $('#preview').show();
            $('#searching').hide();

            codeReader.decodeOnceFromVideoDevice(selectedDeviceId, 'preview')
               .then(result => {
                  console.log(result.text);
                  audio.play();
                  cekData(result.text);

                  $('#preview').hide();
                  $('#previewParent').addClass('unpreview');
                  $('#searching').show();

                  if (codeReader) {
                     codeReader.reset();

                     // delay 2,5 detik setelah berhasil meng-scan
                     setTimeout(() => {
                        initScanner();
                     }, 2500);
                  }
               })
               .catch(err => console.error(err));

         })
         .catch(err => console.error(err));
   }

   if (navigator.mediaDevices) {
      initScanner();
   } else {
      alert('Cannot access camera.');
   }

   async function cekData(code) {
      try {
         const response = await fetch("<?= base_url('scan/cek'); ?>", {
            method: 'POST',
            headers: {
               'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
               'unique_code': code,
               'waktu': '<?= strtolower($waktu); ?>'
            })
         });

         const result = await response.json();
         
         if (result.success) {
            showSuccessNotification(result);
         } else {
            showErrorNotification(result);
         }
      } catch (error) {
         console.error('Error:', error);
         showErrorNotification({
            success: false,
            message: 'Terjadi kesalahan saat memproses data'
         });
      }
   }

   function showSuccessNotification(data) {
      const notification = document.getElementById('notification');
      const title = document.getElementById('notification-title');
      const body = document.getElementById('notification-body');
      
      // Set title
      title.textContent = data.message;
      
      // Set body content dengan design yang lebih profesional
      let bodyContent = '<div style="background: white; border-radius: 12px; padding: 1rem; margin-bottom: 1rem;">';
      bodyContent += '<div class="row g-3">';
      bodyContent += '<div class="col-md-6">';
      bodyContent += '<div style="background: #f9fafb; padding: 1rem; border-radius: 10px; border-left: 3px solid #10b981;">';
      bodyContent += '<p style="margin: 0; font-size: 0.75rem; color: #6b7280; text-transform: uppercase; font-weight: 600; margin-bottom: 0.5rem;">Data Karyawan</p>';
      
      // Tampilkan data karyawan/admin
      if (data.data) {
         if (data.type === 'Karyawan' && data.data.nama_karyawan) {
            bodyContent += `<p style="margin: 0 0 0.5rem 0; font-size: 1rem; color: #1f2937;"><strong style="color: #374151;">Nama:</strong> ${data.data.nama_karyawan || '-'}</p>`;
            bodyContent += `<p style="margin: 0 0 0.5rem 0; font-size: 1rem; color: #1f2937;"><strong style="color: #374151;">NIS:</strong> ${data.data.nis || '-'}</p>`;
            const dept = data.data.departemen || '';
            const jab = data.data.jabatan || '';
            const deptJab = `${dept} ${jab}`.trim();
            bodyContent += `<p style="margin: 0; font-size: 1rem; color: #1f2937;"><strong style="color: #374151;">Departemen:</strong> ${deptJab || '-'}</p>`;
         } else if (data.type === 'Admin' && data.data.nama_admin) {
            bodyContent += `<p style="margin: 0 0 0.5rem 0; font-size: 1rem; color: #1f2937;"><strong style="color: #374151;">Nama:</strong> ${data.data.nama_admin || '-'}</p>`;
            bodyContent += `<p style="margin: 0 0 0.5rem 0; font-size: 1rem; color: #1f2937;"><strong style="color: #374151;">NUPTK:</strong> ${data.data.nuptk || '-'}</p>`;
            bodyContent += `<p style="margin: 0; font-size: 1rem; color: #1f2937;"><strong style="color: #374151;">No HP:</strong> ${data.data.no_hp || '-'}</p>`;
         }
      }
      
      bodyContent += '</div>';
      bodyContent += '</div>';
      bodyContent += '<div class="col-md-6">';
      bodyContent += '<div style="background: #f9fafb; padding: 1rem; border-radius: 10px; border-left: 3px solid #3b82f6;">';
      bodyContent += '<p style="margin: 0; font-size: 0.75rem; color: #6b7280; text-transform: uppercase; font-weight: 600; margin-bottom: 0.5rem;">Waktu Absensi</p>';
      if (data.presensi) {
         bodyContent += `<p style="margin: 0 0 0.5rem 0; font-size: 1rem; color: #1f2937;"><strong style="color: #374151;">Jam masuk:</strong> <span style="color: #3b82f6; font-weight: 600;">${data.presensi.jam_masuk || '-'}</span></p>`;
         bodyContent += `<p style="margin: 0; font-size: 1rem; color: #1f2937;"><strong style="color: #374151;">Jam pulang:</strong> <span style="color: #3b82f6; font-weight: 600;">${data.presensi.jam_keluar || '-'}</span></p>`;
      } else {
         bodyContent += `<p style="margin: 0 0 0.5rem 0; font-size: 1rem; color: #1f2937;"><strong style="color: #374151;">Jam masuk:</strong> <span style="color: #9ca3af;">-</span></p>`;
         bodyContent += `<p style="margin: 0; font-size: 1rem; color: #1f2937;"><strong style="color: #374151;">Jam pulang:</strong> <span style="color: #9ca3af;">-</span></p>`;
      }
      bodyContent += '</div>';
      bodyContent += '</div>';
      bodyContent += '</div>';
      bodyContent += '</div>';
      
      // Tambahkan tombol untuk scan selanjutnya dengan design yang lebih menarik
      bodyContent += '<div class="text-center" style="padding-top: 0.5rem;">';
      bodyContent += '<button class="btn btn-success" onclick="prepareNextScan()" style="border-radius: 12px; padding: 12px 24px; font-weight: 600; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.2);">';
      bodyContent += '<i class="material-icons mr-2" style="vertical-align: middle; font-size: 20px;">refresh</i>';
      bodyContent += 'Scan Karyawan Selanjutnya';
      bodyContent += '</button>';
      bodyContent += '</div>';
      
      body.innerHTML = bodyContent;
      
      // Set notification class
      notification.className = 'notification-floating notification-success';
      notification.style.display = 'block';
      
      // Auto hide after 8 seconds dan auto refresh
      setTimeout(() => {
         hideNotification();
         prepareNextScan();
      }, 8000);
   }

   function showErrorNotification(data) {
      const notification = document.getElementById('notification');
      const title = document.getElementById('notification-title');
      const body = document.getElementById('notification-body');
      
      // Set title
      title.textContent = data.message;
      
      // Set body content
      let bodyContent = '';
      if (data.data) {
         bodyContent += '<div class="row">';
         bodyContent += '<div class="col">';
         
         if (data.type === 'Karyawan') {
            bodyContent += `<p><strong>Nama:</strong> ${data.data.nama_karyawan}</p>`;
            bodyContent += `<p><strong>NIS:</strong> ${data.data.nis}</p>`;
            bodyContent += `<p><strong>Departemen:</strong> ${data.data.departemen} ${data.data.jabatan}</p>`;
         } else if (data.type === 'Admin') {
            bodyContent += `<p><strong>Nama:</strong> ${data.data.nama_admin}</p>`;
            bodyContent += `<p><strong>NUPTK:</strong> ${data.data.nuptk}</p>`;
            bodyContent += `<p><strong>No HP:</strong> ${data.data.no_hp}</p>`;
         }
         
         bodyContent += '</div>';
         if (data.presensi) {
            bodyContent += '<div class="col">';
            bodyContent += `<p><strong>Jam masuk:</strong> <span class="text-info">${data.presensi.jam_masuk || '-'}</span></p>`;
            bodyContent += `<p><strong>Jam pulang:</strong> <span class="text-info">${data.presensi.jam_keluar || '-'}</span></p>`;
            bodyContent += '</div>';
         }
         bodyContent += '</div>';
      }
      
      body.innerHTML = bodyContent;
      
      // Set notification class
      notification.className = 'notification-floating notification-error';
      notification.style.display = 'block';
      
      // Auto hide after 5 seconds
      setTimeout(() => {
         hideNotification();
      }, 5000);
   }

   function hideNotification() {
      const notification = document.getElementById('notification');
      notification.style.display = 'none';
   }

   function prepareNextScan() {
      // Hide notification
      hideNotification();
      
      // Reset scanner state
      $('#previewParent').removeClass('unpreview');
      $('#preview').show();
      $('#searching').hide();
      
      // Clear any previous results
      clearData();
      
      // Restart scanner
      if (codeReader) {
         codeReader.reset();
         setTimeout(() => {
            initScanner();
         }, 500);
      }
   }

   function clearData() {
      $('#hasilScan').html('');
   }
   
   // Theme Toggle Function
   function toggleTheme() {
      var current = document.documentElement.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
      var next = current === 'dark' ? 'light' : 'dark';
      document.documentElement.setAttribute('data-theme', next);
      
      try {
         localStorage.setItem('ui-theme', next);
      } catch (e) {
         console.error('Error saving theme:', e);
      }
      
      // Update icon and text
      var icon = document.getElementById('themeIcon');
      var text = document.getElementById('themeText');
      
      if (icon && text) {
         if (next === 'dark') {
            icon.textContent = 'light_mode';
            text.textContent = 'Terang';
         } else {
            icon.textContent = 'dark_mode';
            text.textContent = 'Gelap';
         }
      }
   }
   
   // Initialize theme icon on page load
   document.addEventListener('DOMContentLoaded', function() {
      var mode = document.documentElement.getAttribute('data-theme') || 'light';
      var icon = document.getElementById('themeIcon');
      var text = document.getElementById('themeText');
      
      if (icon && text) {
         if (mode === 'dark') {
            icon.textContent = 'light_mode';
            text.textContent = 'Terang';
         } else {
            icon.textContent = 'dark_mode';
            text.textContent = 'Gelap';
         }
      }
   });
</script>

<!-- Core JS Files -->
<script src="<?= base_url('assets/js/plugins.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/core/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('assets/js/core/popper.min.js') ?>"></script>
<script src="<?= base_url('assets/js/core/bootstrap-material-design.min.js') ?>"></script>
<script src="<?= base_url('assets/js/plugins/perfect-scrollbar.jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/js/material-dashboard.js') ?>" type="text/javascript"></script>

</body>
</html>
