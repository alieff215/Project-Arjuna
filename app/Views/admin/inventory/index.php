<?= $this->extend('templates/admin_page_layout'); ?>

<?= $this->section('content'); ?>
<style>
  /* ===================== MODERN FUTURISTIC THEME (scoped ke .content) ===================== */
  .content {
    --bg: #f8fafc;
    --mesh-1: #e0e7ff40;
    --mesh-2: #cffafe35;
    --mesh-3: #f0fdf430;
    --card: #ffffff95;
    --card-solid: #fff;
    --glass: blur(20px) saturate(150%) brightness(1.1);
    --text: #0f172a;
    --muted: #64748b;
    --border: rgba(15, 23, 42, .08);
    --ring: #3b82f6;
    --primary: #3b82f6;
    --primary-hover: #2563eb;
    --success: #10b981;
    --warning: #f59e0b;
    --danger: #ef4444;
    --radius: 12px;
    --radius-lg: 16px;
    --radius-xl: 24px;
    --gap: 20px;
    --shadow: 0 4px 6px -1px rgba(0, 0, 0, .1), 0 2px 4px -1px rgba(0, 0, 0, .06);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, .1), 0 4px 6px -2px rgba(0, 0, 0, .05);
    --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, .1), 0 10px 10px -5px rgba(0, 0, 0, .04);
    --thead: #1e293b;
    --thead-bg: #f1f5f9;
    --row-hover: rgba(59, 130, 246, .04);
    position: relative;
    padding: 24px 0 40px !important;
    color: var(--text);
    background:
      radial-gradient(ellipse at top left, var(--mesh-1) 0%, transparent 50%),
      radial-gradient(ellipse at top right, var(--mesh-2) 0%, transparent 50%),
      radial-gradient(ellipse at bottom center, var(--mesh-3) 0%, transparent 50%),
      linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    min-height: 100vh;
    width: 100%;
    display: block;
    visibility: visible;
  }

  html[data-theme="dark"] .content {
    --bg: #0f172a;
    --mesh-1: #1e293b40;
    --mesh-2: #0f172a35;
    --mesh-3: #1e40af30;
    --card: #1e293b95;
    --card-solid: #1e293b;
    --text: #f1f5f9;
    --muted: #94a3b8;
    --border: rgba(148, 163, 184, .1);
    --ring: #60a5fa;
    --primary: #60a5fa;
    --primary-hover: #3b82f6;
    --thead: #f1f5f9;
    --thead-bg: #334155;
    --row-hover: rgba(96, 165, 250, .08);
    --shadow: 0 4px 6px -1px rgba(0, 0, 0, .3), 0 2px 4px -1px rgba(0, 0, 0, .2);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, .3), 0 4px 6px -2px rgba(0, 0, 0, .2);
    --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, .3), 0 10px 10px -5px rgba(0, 0, 0, .2);
    background:
      radial-gradient(ellipse at top left, var(--mesh-1) 0%, transparent 50%),
      radial-gradient(ellipse at top right, var(--mesh-2) 0%, transparent 50%),
      radial-gradient(ellipse at bottom center, var(--mesh-3) 0%, transparent 50%),
      linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
  }

  /* Dark Mode Mobile Specific */
  html[data-theme="dark"] .content .toolbar {
    background: #1e293b !important;
    color: #f1f5f9 !important;
  }

  html[data-theme="dark"] .content .toolbar h3 {
    color: #f1f5f9 !important;
  }

  html[data-theme="dark"] .content .card-modern {
    background: #1e293b !important;
    border-color: rgba(148, 163, 184, .1) !important;
  }

  html[data-theme="dark"] .content .card-modern .card-header {
    background: #334155 !important;
    border-bottom-color: rgba(148, 163, 184, .1) !important;
  }


  html[data-theme="dark"] .content .form-select {
    background: #1e293b !important;
    border-color: rgba(148, 163, 184, .1) !important;
    color: #f1f5f9 !important;
  }

  html[data-theme="dark"] .content .form-select:focus {
    border-color: #60a5fa !important;
    box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.1) !important;
  }

  html[data-theme="dark"] .content .btn-secondary {
    background: #334155 !important;
    border-color: rgba(148, 163, 184, .1) !important;
    color: #f1f5f9 !important;
  }

  html[data-theme="dark"] .content .btn-secondary:hover {
    background: #475569 !important;
    border-color: rgba(148, 163, 184, .2) !important;
  }

  html[data-theme="dark"] .content .filter-line label {
    color: #94a3b8 !important;
  }

  html[data-theme="dark"] .content .empty {
    background: #1e293b !important;
    color: #94a3b8 !important;
  }

  .content .page-wrap {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 24px;
    width: 100%;
    display: block;
    visibility: visible;
  }

  /* ===================== TOP BAR ===================== */
  .content .toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 24px;
    padding: 20px 0;
  }

  .content .toolbar h3 {
    margin: 0;
    font-weight: 700;
    font-size: 1.875rem;
    letter-spacing: -0.025em;
    color: var(--text);
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .content .toolbar h3::before {
    content: "📦";
    font-size: 1.5rem;
    filter: grayscale(0.2);
  }

  .content .actions {
    display: inline-flex;
    gap: 12px;
    align-items: center;
    flex-wrap: wrap;
  }

  /* ===================== BUTTONS ===================== */
  .content .btn {
    border-radius: var(--radius);
    line-height: 1.5;
    padding: 12px 20px;
    font-weight: 600;
    font-size: 0.875rem;
    border: 1px solid transparent;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    position: relative;
    overflow: hidden;
  }

  .content .btn:focus-visible {
    outline: 2px solid var(--ring);
    outline-offset: 2px;
  }

  .content .btn:active {
    transform: translateY(1px);
  }

  .content .btn-primary {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
    color: #fff;
    border-color: var(--primary);
    box-shadow: var(--shadow-lg);
  }

  .content .btn-primary:hover {
    background: linear-gradient(135deg, var(--primary-hover) 0%, var(--primary) 100%);
    box-shadow: var(--shadow-xl);
    transform: translateY(-1px);
  }

  .content .btn-primary::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
  }

  .content .btn-primary:hover::before {
    left: 100%;
  }

  .content .btn-secondary {
    background: var(--card-solid);
    color: var(--text);
    border-color: var(--border);
    box-shadow: var(--shadow);
  }

  .content .btn-secondary:hover {
    background: var(--row-hover);
    border-color: var(--primary);
    transform: translateY(-1px);
    box-shadow: var(--shadow-lg);
  }

  .content .btn-info {
    background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
    border-color: #0891b2;
    color: #fff;
    box-shadow: var(--shadow-lg);
  }

  .content .btn-info:hover {
    background: linear-gradient(135deg, #0891b2 0%, #0e7490 100%);
    transform: translateY(-1px);
    box-shadow: var(--shadow-xl);
  }

  .content .btn-sm {
    padding: 8px 16px;
    font-size: 0.75rem;
    border-radius: var(--radius);
  }

  /* ===================== GLASS CARD ===================== */
  .content .card-modern {
    background: var(--card);
    -webkit-backdrop-filter: var(--glass);
    backdrop-filter: var(--glass);
    border: 1px solid var(--border);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-xl);
    overflow: hidden;
    transition: all 0.3s ease;
  }

  .content .card-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
  }

  .content .card-modern .card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    padding: 20px 24px;
    border-bottom: 1px solid var(--border);
    background: linear-gradient(135deg, var(--card-solid) 0%, rgba(255, 255, 255, 0.1) 100%);
    -webkit-backdrop-filter: var(--glass);
    backdrop-filter: var(--glass);
  }

  .content .card-modern .card-body {
    padding: 24px;
  }

  /* ===================== FILTER ===================== */
  .content .filter-line {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
  }

  .content .filter-line label {
    color: var(--muted);
    font-weight: 600;
    font-size: 0.875rem;
    margin: 0;
  }

  .content .form-select {
    height: 44px;
    padding: 10px 16px;
    border-radius: var(--radius);
    border: 1px solid var(--border);
    background: var(--card-solid);
    color: var(--text);
    font-size: 0.875rem;
    transition: all 0.2s ease;
    min-width: 140px;
  }

  .content .form-select:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    outline: none;
  }

  .content .form-select:hover {
    border-color: var(--primary);
  }

  /* ===================== TABLE ===================== */
  .content .table-wrap {
    overflow: auto;
    border-radius: var(--radius-lg);
    border: 1px solid var(--border);
    background: var(--card-solid);
    box-shadow: var(--shadow-lg);
    position: relative;
  }

  .content .table-wrap::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--primary), transparent);
    opacity: 0.3;
  }

  .content table.table {
    margin: 0;
    border-collapse: separate !important;
    border-spacing: 0;
    min-width: 900px;
    color: var(--text);
    width: 100%;
  }

  .content thead {
    position: sticky;
    top: 0;
    z-index: 2;
    background: var(--thead-bg) !important;
    color: var(--thead) !important;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    font-size: 0.8rem;
    font-weight: 700;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
  }

  .content thead th {
    padding: 16px 20px !important;
    border-bottom: 2px solid var(--border) !important;
    font-weight: 700;
    white-space: nowrap;
    position: relative;
  }

  .content thead th:first-child {
    border-top-left-radius: var(--radius-lg);
  }

  .content thead th:last-child {
    border-top-right-radius: var(--radius-lg);
  }

  .content tbody td {
    padding: 18px 20px !important;
    border-top: 1px solid var(--border) !important;
    vertical-align: middle;
    font-size: 0.9rem;
    font-weight: 500;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    line-height: 1.5;
    color: var(--text);
  }

  .content tbody td:first-child {
    font-weight: 600;
    color: var(--muted);
    font-size: 0.85rem;
  }

  .content tbody td:nth-child(2),
  .content tbody td:nth-child(3) {
    font-weight: 600;
    color: var(--text);
  }

  .content tbody td:nth-child(4) {
    font-weight: 500;
  }

  .content tbody td:last-child {
    font-weight: 500;
  }

  .content tbody tr {
    transition: all 0.2s ease;
  }

  .content tbody tr:hover {
    background: var(--row-hover);
    transform: scale(1.01);
  }

  .content tbody tr:first-child td {
    border-top: none !important;
  }

  .content tbody tr:last-child td:first-child {
    border-bottom-left-radius: var(--radius-lg);
  }

  .content tbody tr:last-child td:last-child {
    border-bottom-right-radius: var(--radius-lg);
  }

  /* ===================== PROGRESS – sleek stripe ===================== */
  .content .progress {
    height: 16px !important;
    border-radius: 999px;
    background: var(--border);
    border: 1px solid var(--border);
    overflow: hidden;
    position: relative;
    box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
  }

  .content .progress .progress-bar {
    height: 100%;
    border-radius: 999px;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    font-weight: 700;
    font-size: 0.75rem;
    padding-right: 10px;
    color: #fff;
    position: relative;
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
    background-size: 200% 100%;
    animation: shimmer 3s ease-in-out infinite;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
  }

  .content .progress .progress-bar:hover {
    transform: scale(1.02);
  }

  .content .progress .bg-success {
    background: linear-gradient(135deg, var(--success) 0%, #22c55e 100%);
  }

  @keyframes shimmer {

    0%,
    100% {
      background-position: 0% 50%;
    }

    50% {
      background-position: 100% 50%;
    }
  }

  .content .qty-info {
    display: inline-block;
    margin-top: 6px;
    color: var(--muted);
    font-weight: 600;
    font-size: 0.75rem;
  }

  .content .text-muted {
    color: var(--muted) !important;
    font-style: italic;
  }

  /* ===================== BADGES ===================== */
  .content .badge {
    border-radius: 999px;
    padding: 8px 12px;
    font-weight: 600;
    font-size: 0.75rem;
    border: 1px solid transparent;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: all 0.2s ease;
  }

  .content .badge:hover {
    transform: scale(1.05);
  }

  .content .badge.bg-success {
    background: linear-gradient(135deg, var(--success) 0%, #22c55e 100%);
    color: #fff;
    border-color: var(--success);
    box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);
  }

  .content .badge.bg-warning {
    background: linear-gradient(135deg, var(--warning) 0%, #fbbf24 100%);
    color: #fff;
    border-color: var(--warning);
    box-shadow: 0 2px 4px rgba(245, 158, 11, 0.2);
  }

  /* ===================== EMPTY ===================== */
  .content .empty {
    display: grid;
    place-items: center;
    padding: 48px 24px;
    color: var(--muted);
    font-weight: 600;
    font-size: 1rem;
    text-align: center;
  }

  .content .empty::before {
    content: "📦";
    font-size: 3rem;
    margin-bottom: 16px;
    opacity: 0.5;
  }

  /* Mobile Empty State */
  @media (max-width: 576px) {
    .content .empty {
      padding: 32px 16px !important;
      font-size: 0.9rem !important;
      background: #fff !important;
      border-radius: 12px !important;
      margin: 16px !important;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1) !important;
      width: calc(100% - 32px) !important;
      display: grid !important;
      visibility: visible !important;
    }

    .content .empty::before {
      font-size: 2.5rem !important;
      margin-bottom: 12px !important;
      display: block !important;
      visibility: visible !important;
    }

    /* Dark Mode Empty State Mobile */
    html[data-theme="dark"] .content .empty {
      background: #1e293b !important;
      color: #94a3b8 !important;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3) !important;
    }
  }

  /* ===================== RESPONSIVE ===================== */

  /* Large Desktop */
  @media (min-width: 1400px) {
    .content .page-wrap {
      max-width: 1600px;
    }

    .content table.table {
      min-width: 1000px;
    }
  }

  /* Desktop */
  @media (max-width: 1200px) {
    .content .page-wrap {
      max-width: 100%;
      padding: 0 20px;
    }

    .content table.table {
      min-width: 800px;
    }
  }

  /* Tablet */
  @media (max-width: 992px) {
    .content .page-wrap {
      padding: 0 16px;
    }

    .content .toolbar {
      flex-direction: column;
      align-items: flex-start;
      gap: 16px;
    }

    .content .toolbar h3 {
      font-size: 1.5rem;
    }

    .content .card-modern .card-header {
      flex-direction: column;
      align-items: flex-start;
      gap: 12px;
    }

    .content .filter-line {
      width: 100%;
      justify-content: space-between;
    }

    .content .form-select {
      flex: 1;
      min-width: auto;
    }

    .content .table-wrap {
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
    }

    .content table.table {
      min-width: 700px;
    }

    .content thead th,
    .content tbody td {
      padding: 14px 16px !important;
      font-size: 0.85rem;
    }

    .content tbody td {
      font-size: 0.8rem;
    }
  }

  /* Mobile Large */
  @media (max-width: 768px) {
    .content .page-wrap {
      padding: 0 12px;
    }

    .content .toolbar h3 {
      font-size: 1.25rem;
    }

    .content .btn {
      padding: 10px 16px;
      font-size: 0.8rem;
    }

    .content .table-wrap {
      border-radius: var(--radius);
      margin: 0 -4px;
    }

    .content table.table {
      min-width: 600px;
    }

    .content thead th,
    .content tbody td {
      padding: 12px 14px !important;
      font-size: 0.8rem;
    }

    .content tbody td {
      font-size: 0.75rem;
    }

    .content .progress {
      height: 14px !important;
    }

    .content .badge {
      padding: 6px 10px;
      font-size: 0.7rem;
    }
  }

  /* Mobile */
  @media (max-width: 576px) {
    .content {
      padding: 12px 0 20px !important;
      background: #f8fafc !important;
      width: 100% !important;
      display: block !important;
      visibility: visible !important;
      min-height: 100vh !important;
    }

    /* Dark Mode Mobile */
    html[data-theme="dark"] .content {
      background: #0f172a !important;
    }

    .content .page-wrap {
      padding: 0 12px !important;
      max-width: 100% !important;
      width: 100% !important;
      display: block !important;
      visibility: visible !important;
    }

    .content .toolbar {
      margin-bottom: 20px !important;
      padding: 16px !important;
      background: #fff !important;
      border-radius: 12px !important;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1) !important;
      width: 100% !important;
      display: block !important;
      visibility: visible !important;
    }

    /* Dark Mode Toolbar Mobile */
    html[data-theme="dark"] .content .toolbar {
      background: #1e293b !important;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3) !important;
    }

    .content .toolbar h3 {
      font-size: 1.25rem !important;
      margin-bottom: 12px !important;
      color: #1e293b !important;
      display: flex !important;
      visibility: visible !important;
      width: 100% !important;
    }

    /* Dark Mode Toolbar H3 Mobile */
    html[data-theme="dark"] .content .toolbar h3 {
      color: #f1f5f9 !important;
    }

    .content .toolbar h3::before {
      font-size: 1.5rem;
      margin-right: 8px;
    }

    .content .actions {
      width: 100% !important;
      display: block !important;
      visibility: visible !important;
    }

    .content .btn {
      padding: 12px 16px !important;
      font-size: 0.85rem !important;
      width: 100% !important;
      justify-content: center !important;
      border-radius: 8px !important;
      font-weight: 600 !important;
      display: inline-flex !important;
      visibility: visible !important;
    }

    .content .card-modern {
      border-radius: 12px !important;
      margin: 0 !important;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
      width: 100% !important;
      display: block !important;
      visibility: visible !important;
      background: #fff !important;
    }

    /* Dark Mode Card Modern Mobile */
    html[data-theme="dark"] .content .card-modern {
      background: #1e293b !important;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3) !important;
    }

    .content .card-modern .card-header {
      padding: 16px !important;
      background: #f8fafc !important;
      border-bottom: 1px solid #e2e8f0 !important;
      display: block !important;
      visibility: visible !important;
      width: 100% !important;
    }

    /* Dark Mode Card Header Mobile */
    html[data-theme="dark"] .content .card-modern .card-header {
      background: #334155 !important;
      border-bottom-color: rgba(148, 163, 184, .1) !important;
    }

    .content .card-modern .card-body {
      padding: 0 !important;
      display: block !important;
      visibility: visible !important;
      width: 100% !important;
    }

    .content .filter-line {
      flex-direction: column !important;
      align-items: stretch !important;
      gap: 12px !important;
      width: 100% !important;
      display: flex !important;
      visibility: visible !important;
    }

    .content .filter-line label {
      font-size: 0.9rem !important;
      font-weight: 600 !important;
      color: #374151 !important;
      display: block !important;
      visibility: visible !important;
      width: 100% !important;
    }

    /* Dark Mode Filter Label Mobile */
    html[data-theme="dark"] .content .filter-line label {
      color: #94a3b8 !important;
    }

    .content .form-select {
      height: 48px !important;
      font-size: 0.9rem !important;
      border-radius: 8px !important;
      border: 2px solid #e5e7eb !important;
      background: #fff !important;
      width: 100% !important;
      display: block !important;
      visibility: visible !important;
    }

    /* Dark Mode Form Select Mobile */
    html[data-theme="dark"] .content .form-select {
      background: #1e293b !important;
      border-color: rgba(148, 163, 184, .1) !important;
      color: #f1f5f9 !important;
    }

    .content .form-select:focus {
      border-color: #3b82f6;
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .content .btn-secondary {
      height: 48px !important;
      font-size: 0.9rem !important;
      border-radius: 8px !important;
      background: #f3f4f6 !important;
      border: 2px solid #e5e7eb !important;
      color: #374151 !important;
      width: 100% !important;
      display: inline-flex !important;
      visibility: visible !important;
    }

    /* Dark Mode Button Secondary Mobile */
    html[data-theme="dark"] .content .btn-secondary {
      background: #334155 !important;
      border-color: rgba(148, 163, 184, .1) !important;
      color: #f1f5f9 !important;
    }

    .content .btn-secondary:hover {
      background: #e5e7eb;
      border-color: #d1d5db;
    }
  }

  /* Extra Small Mobile */
  @media (max-width: 400px) {
    .content .page-wrap {
      padding: 0 4px;
    }

    .content .toolbar h3 {
      font-size: 1rem;
    }

    .content .btn {
      padding: 6px 10px;
      font-size: 0.7rem;
    }

    .content table.table {
      min-width: 450px;
    }

    .content thead th,
    .content tbody td {
      padding: 8px 10px !important;
      font-size: 0.7rem;
    }

    .content tbody td {
      font-size: 0.65rem;
    }
  }

  /* Mobile Table Layout - Same as Desktop */
  @media (max-width: 576px) {
    .content .table-wrap {
      overflow-x: auto;
      overflow-y: visible;
      border: 1px solid var(--border);
      background: var(--card-solid);
      box-shadow: var(--shadow-lg);
      border-radius: var(--radius-lg);
      -webkit-overflow-scrolling: touch;
    }

    .content table.table {
      display: table !important;
      min-width: 600px;
      width: 100%;
    }

    .content thead th,
    .content tbody td {
      padding: 12px 14px !important;
      font-size: 0.8rem;
      white-space: nowrap;
    }

    .content tbody td {
      font-size: 0.75rem;
    }

    .content tbody td:nth-child(4) {
      white-space: normal;
      min-width: 120px;
    }

    .content .progress {
      height: 14px !important;
      min-width: 100px;
    }

    .content .badge {
      padding: 6px 10px;
      font-size: 0.7rem;
      white-space: nowrap;
    }

    .content .btn-sm {
      padding: 6px 12px;
      font-size: 0.7rem;
      white-space: nowrap;
    }

    .content .qty-info {
      font-size: 0.7rem;
      white-space: nowrap;
    }
  }
</style>

<div class="content">
  <div class="page-wrap">

    <div class="toolbar">
      <h3>Daftar Inventory</h3>
      <div class="actions">
        <a href="/admin/inventory/create" class="btn btn-primary">
          <span>➕</span>
          Tambah Inventory
        </a>
      </div>
    </div>

    <div class="card-modern" role="region" aria-label="Filter dan Tabel Inventory">
      <div class="card-header">
        <form method="get" class="filter-line" role="search" aria-label="Filter status">
          <label for="status">🔍 Filter Status:</label>
          <select name="status" id="status" class="form-select d-inline-block w-auto">
            <option value="">📋 Semua</option>
            <option value="onprogress" <?= isset($_GET['status']) && $_GET['status'] === 'onprogress' ? 'selected' : '' ?>>⏳ On Progress</option>
            <option value="done" <?= isset($_GET['status']) && $_GET['status'] === 'done' ? 'selected' : '' ?>>✅ Done</option>
          </select>
          <button class="btn btn-secondary btn-sm" type="submit">
            <span>🎯</span>
            Terapkan
          </button>
        </form>
      </div>

      <div class="card-body">
        <!-- Table View -->
        <div class="table-wrap">
          <table class="table table-hover align-middle">
            <thead>
              <tr>
                <th>#</th>
                <th>Brand</th>
                <th>Order</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Progress</th>
                <th>Status</th>
                <th style="min-width:104px">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($inventories)): ?>
                <?php foreach ($inventories as $i => $inv): ?>
                  <?php $pp = (int)($inv['progress_percent'] ?? 0); ?>
                  <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= esc($inv['brand']) ?></td>
                    <td><?= esc($inv['order_name']) ?></td>
                    <td>
                      <?php if (!empty($inv['tanggal_mulai'])): ?>
                        <?= date('d/m/Y', strtotime($inv['tanggal_mulai'])) ?>
                      <?php else: ?>
                        <span class="text-muted">-</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <?php if (!empty($inv['tanggal_selesai'])): ?>
                        <?= date('d/m/Y', strtotime($inv['tanggal_selesai'])) ?>
                      <?php else: ?>
                        <span class="text-muted">-</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <div class="progress" aria-label="Progress <?= $pp; ?>%">
                        <div class="progress-bar <?= ($inv['is_completed'] ?? false) ? 'bg-success' : '' ?>"
                          role="progressbar"
                          style="width: <?= $pp; ?>%;"
                          aria-valuenow="<?= $pp; ?>" aria-valuemin="0" aria-valuemax="100">
                          <?= $pp; ?>%
                        </div>
                      </div>
                      <span class="qty-info">
                        <?= (int)($inv['finishing_qty'] ?? 0) ?> / <?= (int)($inv['total_target'] ?? 0) ?> pcs
                      </span>
                    </td>
                    <td>
                      <?php if ($inv['is_completed'] ?? false): ?>
                        <span class="badge bg-success">✅ Selesai</span>
                      <?php else: ?>
                        <span class="badge bg-warning">⏳ Progress</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <a href="/admin/inventory/detail/<?= $inv['id'] ?>" class="btn btn-sm btn-info">
                        <span>👁️</span>
                        Detail
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="8">
                    <div class="empty">Belum ada data inventory.</div>
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

      </div>
    </div>

  </div>
</div>

<?= $this->endSection(); ?>