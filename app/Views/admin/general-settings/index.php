<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>

<style>
    /* ===================== ULTRA MODERN SETTINGS STYLE ===================== */

    /* Responsive Base Styles */
    * {
        box-sizing: border-box;
    }

    :root {
        --bg: #fafbfc;
        --card: #ffffff;
        --text: #1a202c;
        --text-muted: #718096;
        --primary: #667eea;
        --primary-light: #e6f3ff;
        --success: #48bb78;
        --success-light: #f0fff4;
        --border: #e2e8f0;
        --radius: 12px;
        --radius-lg: 16px;
        --shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 25px 0 rgba(0, 0, 0, 0.1);
        --shadow-xl: 0 20px 40px 0 rgba(0, 0, 0, 0.15);
        --gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --gradient-success: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
    }

    html[data-theme="dark"] {
        --bg: #1a202c;
        --card: #2d3748;
        --text: #f7fafc;
        --text-muted: #a0aec0;
        --primary: #667eea;
        --primary-light: #2d3748;
        --success: #48bb78;
        --success-light: #2d3748;
        --border: #4a5568;
    }

    .content {
        background: var(--bg);
        min-height: 100vh;
        padding: 32px 0 48px !important;
        position: relative;
        width: 100%;
        box-sizing: border-box;
        overflow-x: hidden;
    }

    .content::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 200px;
        background: var(--gradient);
        opacity: 0.05;
        z-index: 0;
    }

    .content .page-wrap {
        max-width: 900px;
        margin: 0 auto;
        padding: 0 32px;
        position: relative;
        z-index: 1;
        width: 100%;
        box-sizing: border-box;
    }

    .content .toolbar {
        text-align: center;
        margin-bottom: 48px;
        padding: 48px 0;
        position: relative;
        width: 100%;
        box-sizing: border-box;
    }

    .content .toolbar::before {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 20px;
        height: 20px;
        background: var(--gradient);
        border-radius: 4px;
        transform: translateX(-50%) rotate(45deg);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .content .toolbar::after {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 8px;
        height: 8px;
        background: var(--primary);
        border-radius: 50%;
        margin-top: 24px;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.2);
    }

    /* Responsive Geometric Elements */
    @media (min-width: 1400px) {
        .content .toolbar::before {
            width: 24px;
            height: 24px;
            box-shadow: 0 6px 16px rgba(102, 126, 234, 0.4);
        }

        .content .toolbar::after {
            width: 10px;
            height: 10px;
            margin-top: 28px;
            box-shadow: 0 3px 10px rgba(102, 126, 234, 0.3);
        }
    }

    @media (max-width: 1024px) and (min-width: 769px) {
        .content .toolbar::before {
            width: 18px;
            height: 18px;
            box-shadow: 0 3px 10px rgba(102, 126, 234, 0.3);
        }

        .content .toolbar::after {
            width: 7px;
            height: 7px;
            margin-top: 22px;
            box-shadow: 0 2px 6px rgba(102, 126, 234, 0.2);
        }
    }

    @media (max-width: 768px) and (min-width: 577px) {
        .content .toolbar::before {
            width: 16px;
            height: 16px;
            box-shadow: 0 3px 8px rgba(102, 126, 234, 0.3);
        }

        .content .toolbar::after {
            width: 6px;
            height: 6px;
            margin-top: 20px;
            box-shadow: 0 2px 5px rgba(102, 126, 234, 0.2);
        }
    }

    @media (max-width: 576px) {
        .content .toolbar::before {
            width: 14px;
            height: 14px;
            box-shadow: 0 2px 6px rgba(102, 126, 234, 0.3);
        }

        .content .toolbar::after {
            width: 5px;
            height: 5px;
            margin-top: 18px;
            box-shadow: 0 1px 4px rgba(102, 126, 234, 0.2);
        }
    }

    @media (max-width: 480px) {
        .content .toolbar::before {
            width: 12px;
            height: 12px;
            box-shadow: 0 2px 5px rgba(102, 126, 234, 0.3);
        }

        .content .toolbar::after {
            width: 4px;
            height: 4px;
            margin-top: 16px;
            box-shadow: 0 1px 3px rgba(102, 126, 234, 0.2);
        }
    }

    @media (max-width: 360px) {
        .content .toolbar::before {
            width: 10px;
            height: 10px;
            box-shadow: 0 1px 4px rgba(102, 126, 234, 0.3);
        }

        .content .toolbar::after {
            width: 3px;
            height: 3px;
            margin-top: 14px;
            box-shadow: 0 1px 2px rgba(102, 126, 234, 0.2);
        }
    }

    .content .toolbar h3 {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--text);
        margin: 24px 0 12px 0;
        letter-spacing: -0.02em;
        background: var(--gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        word-wrap: break-word;
        overflow-wrap: break-word;
        hyphens: auto;
        line-height: 1.2;
        min-width: 0;
        flex-shrink: 0;
        flex: 0 0 auto;
    }

    .content .toolbar p {
        color: var(--text-muted);
        font-size: 1.1rem;
        margin: 0;
        font-weight: 400;
        word-wrap: break-word;
        overflow-wrap: break-word;
        line-height: 1.4;
        min-width: 0;
        flex-shrink: 0;
        flex: 0 0 auto;
    }

    .content .form-card {
        background: var(--card);
        border: none;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-xl);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        padding: 48px;
        margin: 0 auto;
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
        position: relative;
        overflow: hidden;
        word-wrap: break-word;
        overflow-wrap: break-word;
        min-width: 0;
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        flex: 0 0 auto;
    }

    .content .form-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--gradient);
    }

    .content .form-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 25px 50px 0 rgba(0, 0, 0, 0.2);
    }

    .content .form-group {
        margin-bottom: 36px;
        position: relative;
        width: 100%;
        box-sizing: border-box;
        min-width: 0;
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        flex: 0 0 auto;
    }

    .content .form-group:last-of-type {
        margin-bottom: 48px;
    }

    .content .form-group label {
        display: block;
        margin-bottom: 16px;
        font-weight: 700;
        color: var(--text);
        font-size: 1rem;
        letter-spacing: -0.01em;
        position: relative;
        word-wrap: break-word;
        overflow-wrap: break-word;
        line-height: 1.3;
        min-width: 0;
        flex-shrink: 0;
        flex: 0 0 auto;
    }

    .content .form-group label::after {
        content: '';
        position: absolute;
        bottom: -4px;
        left: 0;
        width: 30px;
        height: 2px;
        background: var(--gradient);
        border-radius: 1px;
    }

    .content .form-control {
        width: 100%;
        padding: 18px 24px;
        border: 2px solid var(--border);
        border-radius: var(--radius);
        background: var(--card);
        color: var(--text);
        font-size: 1rem;
        font-weight: 500;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-sizing: border-box;
        min-height: 56px;
        display: block;
        margin: 0;
        position: relative;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        resize: vertical;
        min-width: 0;
        flex-shrink: 0;
        flex: 1;
    }

    .content .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        transform: translateY(-1px);
    }

    .content .form-control.is-invalid {
        border-color: #e53e3e;
        box-shadow: 0 0 0 4px rgba(229, 62, 62, 0.1);
    }

    .content .invalid-feedback {
        display: block;
        width: 100%;
        margin-top: 12px;
        font-size: 0.875rem;
        color: #e53e3e;
        background: #fed7d7;
        padding: 12px 16px;
        border-radius: var(--radius);
        border-left: 4px solid #e53e3e;
        font-weight: 500;
        word-wrap: break-word;
        overflow-wrap: break-word;
        line-height: 1.4;
        min-width: 0;
        flex-shrink: 0;
        flex: 0 0 auto;
    }

    .content .logo-section {
        background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
        border: 2px dashed var(--border);
        border-radius: var(--radius-lg);
        padding: 40px;
        text-align: center;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
        word-wrap: break-word;
        overflow-wrap: break-word;
        min-width: 0;
        flex-shrink: 0;
        flex: 0 0 auto;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .content .logo-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: var(--gradient);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .content .logo-section:hover {
        border-color: var(--primary);
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .content .logo-section:hover::before {
        opacity: 0.05;
    }

    .content .logo-preview {
        max-width: 200px;
        max-height: 200px;
        border-radius: var(--radius);
        box-shadow: var(--shadow-lg);
        margin-bottom: 24px;
        transition: all 0.3s ease;
        position: relative;
        z-index: 1;
        width: 100%;
        height: auto;
        object-fit: contain;
        display: block;
        margin-left: auto;
        margin-right: auto;
        min-width: 0;
        flex-shrink: 0;
        flex: 0 0 auto;
    }

    .content .logo-section:hover .logo-preview {
        transform: scale(1.05);
    }

    .content .file-upload-btn {
        background: var(--gradient);
        color: white;
        border: none;
        padding: 14px 28px;
        border-radius: var(--radius);
        font-size: 0.95rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-flex;
        align-items: center;
        gap: 10px;
        position: relative;
        z-index: 1;
        letter-spacing: 0.02em;
        min-height: 48px;
        touch-action: manipulation;
        -webkit-tap-highlight-color: transparent;
        user-select: none;
        min-width: 0;
        white-space: nowrap;
        flex-shrink: 0;
        flex: 0 0 auto;
    }

    .content .file-upload-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px 0 rgba(102, 126, 234, 0.4);
    }

    .content .file-info {
        font-size: 0.875rem;
        color: var(--text-muted);
        margin-top: 12px;
        font-weight: 500;
        position: relative;
        z-index: 1;
        word-wrap: break-word;
        overflow-wrap: break-word;
        line-height: 1.4;
        min-width: 0;
        flex-shrink: 0;
        flex: 0 0 auto;
    }

    .content .btn-save {
        background: var(--gradient-success);
        color: white;
        border: none;
        padding: 18px 48px;
        border-radius: var(--radius);
        font-size: 1.1rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 48px auto 0;
        box-shadow: 0 8px 25px 0 rgba(72, 187, 120, 0.3);
        letter-spacing: 0.02em;
        position: relative;
        overflow: hidden;
        min-height: 56px;
        touch-action: manipulation;
        -webkit-tap-highlight-color: transparent;
        user-select: none;
        min-width: 0;
        white-space: nowrap;
        flex-shrink: 0;
        flex: 0 0 auto;
    }

    .content .btn-save::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .content .btn-save:hover::before {
        left: 100%;
    }

    .content .btn-save:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px 0 rgba(72, 187, 120, 0.4);
    }

    .content .alert {
        border-radius: var(--radius);
        border: none;
        padding: 20px 24px;
        margin-bottom: 32px;
        box-shadow: var(--shadow-lg);
        font-weight: 500;
        word-wrap: break-word;
        overflow-wrap: break-word;
        line-height: 1.4;
        min-width: 0;
        flex-shrink: 0;
        flex: 0 0 auto;
    }

    .content .alert-success {
        background: var(--success-light);
        color: #2f855a;
        border-left: 4px solid var(--success);
    }

    .content .alert-danger {
        background: #fed7d7;
        color: #c53030;
        border-left: 4px solid #e53e3e;
    }

    /* ===================== RESPONSIVE DESIGN ===================== */

    /* Large Desktop */
    @media (min-width: 1400px) {
        .content .page-wrap {
            max-width: 1000px;
            padding: 0 48px;
        }

        .content .toolbar {
            margin-bottom: 64px;
            padding: 64px 0;
        }

        .content .toolbar h3 {
            font-size: 3.5rem;
        }

        .content .toolbar p {
            font-size: 1.25rem;
        }

        .content .form-card {
            padding: 64px;
        }

        .content .form-group {
            margin-bottom: 48px;
        }

        .content .form-group label {
            font-size: 1.1rem;
        }

        .content .form-control {
            padding: 22px 28px;
            font-size: 1.1rem;
            min-height: 64px;
        }

        .content .logo-preview {
            max-width: 280px;
            max-height: 280px;
        }

        .content .logo-section {
            padding: 48px;
        }

        .content .btn-save {
            padding: 22px 56px;
            font-size: 1.2rem;
        }
    }

    /* Ultra Wide Screens */
    @media (min-width: 1920px) {
        .content .page-wrap {
            max-width: 1200px;
            padding: 0 64px;
        }

        .content .form-card {
            padding: 80px;
        }

        .content .toolbar h3 {
            font-size: 4rem;
        }

        .content .toolbar p {
            font-size: 1.35rem;
        }
    }

    /* Desktop & Tablet Landscape */
    @media (min-width: 1025px) and (max-width: 1399px) {
        .content .page-wrap {
            max-width: 900px;
            padding: 0 40px;
        }

        .content .toolbar {
            margin-bottom: 56px;
            padding: 56px 0;
        }

        .content .toolbar h3 {
            font-size: 3rem;
        }

        .content .toolbar p {
            font-size: 1.15rem;
        }

        .content .form-card {
            padding: 56px;
        }

        .content .form-group {
            margin-bottom: 40px;
        }

        .content .form-group label {
            font-size: 1.05rem;
        }

        .content .form-control {
            padding: 20px 26px;
            font-size: 1.05rem;
            min-height: 60px;
        }

        .content .logo-preview {
            max-width: 250px;
            max-height: 250px;
        }

        .content .logo-section {
            padding: 44px;
        }

        .content .btn-save {
            padding: 20px 52px;
            font-size: 1.15rem;
        }
    }

    /* Tablet Portrait */
    @media (max-width: 1024px) and (min-width: 769px) {
        .content {
            padding: 28px 0 40px !important;
        }

        .content .page-wrap {
            max-width: 100%;
            padding: 0 32px;
        }

        .content .toolbar {
            margin-bottom: 48px;
            padding: 40px 0;
        }

        .content .toolbar h3 {
            font-size: 2.5rem;
        }

        .content .toolbar p {
            font-size: 1.1rem;
        }

        .content .form-card {
            padding: 40px;
        }

        .content .form-group {
            margin-bottom: 32px;
        }

        .content .form-group label {
            font-size: 1rem;
        }

        .content .form-control {
            padding: 18px 24px;
            font-size: 1rem;
            min-height: 56px;
        }

        .content .logo-preview {
            max-width: 220px;
            max-height: 220px;
        }

        .content .logo-section {
            padding: 36px;
        }

        .content .btn-save {
            padding: 18px 48px;
            font-size: 1.1rem;
        }
    }

    /* Mobile Landscape & Small Tablet */
    @media (max-width: 768px) and (min-width: 577px) {
        .content {
            padding: 24px 0 36px !important;
        }

        .content .page-wrap {
            padding: 0 24px;
        }

        .content .toolbar {
            margin-bottom: 40px;
            padding: 32px 0;
        }

        .content .toolbar h3 {
            font-size: 2.25rem;
        }

        .content .toolbar p {
            font-size: 1.05rem;
        }

        .content .form-card {
            padding: 32px;
        }

        .content .form-group {
            margin-bottom: 28px;
        }

        .content .form-group label {
            font-size: 0.98rem;
        }

        .content .form-control {
            padding: 16px 22px;
            font-size: 0.98rem;
            min-height: 54px;
        }

        .content .logo-preview {
            max-width: 200px;
            max-height: 200px;
        }

        .content .logo-section {
            padding: 32px 28px;
        }

        .content .btn-save {
            padding: 16px 44px;
            font-size: 1.05rem;
        }
    }

    /* Mobile Portrait */
    @media (max-width: 576px) {
        .content {
            padding: 20px 0 32px !important;
        }

        .content .page-wrap {
            padding: 0 20px;
        }

        .content .toolbar {
            margin-bottom: 32px;
            padding: 24px 0;
        }

        .content .toolbar h3 {
            font-size: 2rem;
            line-height: 1.2;
        }

        .content .toolbar p {
            font-size: 1rem;
            line-height: 1.4;
        }

        .content .form-card {
            padding: 24px;
            margin: 0 -4px;
            border-radius: 16px;
        }

        .content .form-group {
            margin-bottom: 24px;
        }

        .content .form-group label {
            font-size: 0.95rem;
            margin-bottom: 12px;
        }

        .content .form-control {
            padding: 16px 20px;
            font-size: 0.95rem;
            min-height: 52px;
            border-radius: 12px;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        .content .form-control:focus {
            transform: none;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
        }

        .content .logo-preview {
            max-width: 180px;
            max-height: 180px;
            border-radius: 12px;
        }

        .content .btn-save {
            width: 100%;
            justify-content: center;
            padding: 18px 24px;
            font-size: 1rem;
            min-height: 56px;
            border-radius: 12px;
            touch-action: manipulation;
        }

        .content .logo-section {
            padding: 28px 20px;
            border-radius: 16px;
        }

        .content .file-upload-btn {
            padding: 14px 28px;
            font-size: 0.9rem;
            min-height: 48px;
            border-radius: 12px;
            touch-action: manipulation;
            -webkit-tap-highlight-color: transparent;
        }

        .content .file-upload-btn:active {
            transform: scale(0.98);
        }

        .content .invalid-feedback {
            font-size: 0.8rem;
            padding: 10px 14px;
            margin-top: 8px;
        }
    }

    /* Small Mobile */
    @media (max-width: 480px) {
        .content {
            padding: 16px 0 28px !important;
        }

        .content .page-wrap {
            padding: 0 16px;
        }

        .content .toolbar {
            margin-bottom: 28px;
            padding: 20px 0;
        }

        .content .toolbar h3 {
            font-size: 1.75rem;
            line-height: 1.1;
        }

        .content .toolbar p {
            font-size: 0.95rem;
            line-height: 1.3;
        }

        .content .form-card {
            padding: 20px;
            margin: 0 -2px;
            border-radius: 14px;
        }

        .content .form-group {
            margin-bottom: 20px;
        }

        .content .form-group label {
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .content .form-control {
            padding: 14px 18px;
            font-size: 0.9rem;
            min-height: 48px;
            border-radius: 10px;
        }

        .content .logo-preview {
            max-width: 160px;
            max-height: 160px;
            border-radius: 10px;
        }

        .content .logo-section {
            padding: 24px 16px;
            border-radius: 14px;
        }

        .content .btn-save {
            padding: 16px 20px;
            font-size: 0.95rem;
            min-height: 52px;
            border-radius: 10px;
        }

        .content .file-upload-btn {
            padding: 12px 24px;
            font-size: 0.85rem;
            min-height: 44px;
            border-radius: 10px;
        }

        .content .invalid-feedback {
            font-size: 0.75rem;
            padding: 8px 12px;
            margin-top: 6px;
        }
    }

    /* Extra Small Mobile */
    @media (max-width: 360px) {
        .content {
            padding: 12px 0 24px !important;
        }

        .content .page-wrap {
            padding: 0 12px;
        }

        .content .toolbar {
            margin-bottom: 24px;
            padding: 16px 0;
        }

        .content .toolbar h3 {
            font-size: 1.5rem;
            line-height: 1.1;
        }

        .content .toolbar p {
            font-size: 0.9rem;
            line-height: 1.3;
        }

        .content .form-card {
            padding: 16px;
            margin: 0 -1px;
            border-radius: 12px;
        }

        .content .form-group {
            margin-bottom: 18px;
        }

        .content .form-group label {
            font-size: 0.85rem;
            margin-bottom: 8px;
        }

        .content .form-control {
            padding: 12px 16px;
            font-size: 0.85rem;
            min-height: 44px;
            border-radius: 8px;
        }

        .content .logo-preview {
            max-width: 140px;
            max-height: 140px;
            border-radius: 8px;
        }

        .content .logo-section {
            padding: 20px 12px;
            border-radius: 12px;
        }

        .content .btn-save {
            padding: 14px 16px;
            font-size: 0.9rem;
            min-height: 48px;
            border-radius: 8px;
        }

        .content .file-upload-btn {
            padding: 10px 20px;
            font-size: 0.8rem;
            min-height: 40px;
            border-radius: 8px;
        }

        .content .invalid-feedback {
            font-size: 0.7rem;
            padding: 6px 10px;
            margin-top: 4px;
        }
    }

    /* Landscape Mobile */
    @media (max-height: 500px) and (orientation: landscape) {
        .content {
            padding: 12px 0 20px !important;
        }

        .content .toolbar {
            margin-bottom: 20px;
            padding: 12px 0;
        }

        .content .toolbar h3 {
            font-size: 1.8rem;
            margin: 12px 0 8px 0;
        }

        .content .toolbar p {
            font-size: 0.9rem;
        }

        .content .form-card {
            padding: 20px;
        }

        .content .form-group {
            margin-bottom: 16px;
        }

        .content .logo-section {
            padding: 20px;
        }

        .content .logo-preview {
            max-width: 120px;
            max-height: 120px;
        }
    }
</style>

<div class="content">
    <div class="page-wrap">
        <div class="toolbar">
            <h3>Pengaturan Umum</h3>
            <p>Kelola pengaturan sistem dan informasi perusahaan dengan mudah</p>
        </div>

        <?= view('admin/_messages'); ?>

        <div class="form-card">
            <form action="<?= base_url('admin/general-settings/update'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="company_name">Nama Perusahaan</label>
                    <input type="text" id="company_name" class="form-control <?= invalidFeedback('company_name') ? 'is-invalid' : ''; ?>" name="company_name" placeholder="Masukkan nama perusahaan" value="<?= $generalSettings->company_name; ?>" required>
                    <div class="invalid-feedback">
                        <?= invalidFeedback('company_name'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="company_year">Tahun Ajaran</label>
                    <input type="text" id="company_year" class="form-control <?= invalidFeedback('company_year') ? 'is-invalid' : ''; ?>" name="company_year" placeholder="2024/2025" value="<?= $generalSettings->company_year; ?>" required>
                    <div class="invalid-feedback">
                        <?= invalidFeedback('company_year'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="copyright">Copyright</label>
                    <input type="text" id="copyright" class="form-control <?= invalidFeedback('copyright') ? 'is-invalid' : ''; ?>" name="copyright" placeholder="© 2024 All Rights Reserved" value="<?= $generalSettings->copyright; ?>" required>
                    <div class="invalid-feedback">
                        <?= invalidFeedback('copyright'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="logo">Logo Perusahaan</label>
                    <div class="logo-section">
                        <img id="logo" src="<?= getLogo(); ?>" alt="Logo Perusahaan" class="logo-preview">
                        <div>
                            <button type="button" onclick="$('#logo-upload').trigger('click');" class="file-upload-btn">
                                Pilih Logo Baru
                            </button>
                            <input type="file" id="logo-upload" name="logo" style="display: none;" accept="image/jpg,image/jpeg,image/png,image/gif,image/svg+xml" onchange="previewLogo(this);">
                            <div class="file-info">
                                Format yang didukung: PNG, JPG, JPEG, GIF, SVG
                            </div>
                            <span id="upload-file-info1" class="file-info"></span>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-save">
                    Simpan Pengaturan
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function previewLogo(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('logo').src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
            document.getElementById('upload-file-info1').textContent = input.files[0].name;
        }
    }
</script>

<?= $this->endSection() ?>