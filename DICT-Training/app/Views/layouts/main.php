<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Task Manager') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 260px;
            --topbar-height: 56px;
            --sidebar-bg: #1a2236;
            --sidebar-hover: #243047;
            --sidebar-active: #2d3c57;
            --sidebar-border: rgba(255,255,255,0.06);
            --sidebar-text: #a8b4cc;
            --sidebar-text-active: #fff;
            --topbar-bg: #fff;
            --body-bg: #f0f2f5;
            --accent: #3b82f6;
            --accent-hover: #2563eb;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: var(--body-bg);
            font-size: 0.9rem;
        }

        /* ── Sidebar ── */
        #sidebar {
            position: fixed;
            top: 0; left: 0; bottom: 0;
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            z-index: 1000;
            transition: transform 0.25s ease;
        }

        .sidebar-brand {
            height: var(--topbar-height);
            display: flex;
            align-items: center;
            gap: 0.65rem;
            padding: 0 1.25rem;
            border-bottom: 1px solid var(--sidebar-border);
            text-decoration: none;
            flex-shrink: 0;
        }

        .brand-icon {
            width: 32px; height: 32px;
            background: var(--accent);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
            color: #fff;
            flex-shrink: 0;
        }

        .brand-name {
            font-size: 0.95rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: -0.01em;
        }

        .sidebar-section-label {
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: rgba(168,180,204,0.45);
            padding: 1.25rem 1.25rem 0.4rem;
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 0.5rem 0.75rem 1rem;
        }

        .sidebar-nav::-webkit-scrollbar { width: 4px; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 4px; }

        .nav-item-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.55rem 0.75rem;
            border-radius: 8px;
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.15s;
            margin-bottom: 2px;
        }

        .nav-item-link i {
            font-size: 1rem;
            width: 20px;
            text-align: center;
            flex-shrink: 0;
        }

        .nav-item-link:hover {
            background: var(--sidebar-hover);
            color: var(--sidebar-text-active);
        }

        .nav-item-link.active {
            background: var(--accent);
            color: #fff;
        }

        .nav-item-link .nav-badge {
            margin-left: auto;
            background: rgba(255,255,255,0.15);
            color: #fff;
            font-size: 0.65rem;
            font-weight: 700;
            padding: 0.15rem 0.5rem;
            border-radius: 99px;
        }

        .nav-item-link.active .nav-badge {
            background: rgba(255,255,255,0.25);
        }

        .sidebar-footer {
            padding: 1rem 0.75rem;
            border-top: 1px solid var(--sidebar-border);
            flex-shrink: 0;
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            transition: background 0.15s;
        }

        .sidebar-user:hover { background: var(--sidebar-hover); }

        .user-avatar {
            width: 34px; height: 34px;
            border-radius: 50%;
            background: var(--accent);
            display: flex; align-items: center; justify-content: center;
            font-size: 0.8rem;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
            text-transform: uppercase;
        }

        .user-info { flex: 1; overflow: hidden; }

        .user-name {
            font-size: 0.83rem;
            font-weight: 600;
            color: #fff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-role {
            font-size: 0.72rem;
            color: var(--sidebar-text);
        }

        .sidebar-user .logout-btn {
            color: var(--sidebar-text);
            font-size: 1rem;
            text-decoration: none;
            transition: color 0.15s;
        }

        .sidebar-user .logout-btn:hover { color: #f87171; }

        /* ── Topbar ── */
        #topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--topbar-height);
            background: var(--topbar-bg);
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            gap: 1rem;
            z-index: 900;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
            transition: left 0.25s ease;
        }

        #sidebar-toggle {
            background: none;
            border: none;
            cursor: pointer;
            color: #6b7280;
            font-size: 1.2rem;
            padding: 0.3rem;
            border-radius: 6px;
            display: flex;
            transition: all 0.15s;
        }

        #sidebar-toggle:hover { background: #f3f4f6; color: #111; }

        .topbar-breadcrumb {
            font-size: 0.83rem;
            color: #9ca3af;
        }

        .topbar-breadcrumb span { color: #374151; font-weight: 600; }

        .topbar-right {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .topbar-btn {
            position: relative;
            width: 36px; height: 36px;
            border-radius: 8px;
            background: none;
            border: none;
            cursor: pointer;
            color: #6b7280;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.05rem;
            transition: all 0.15s;
            text-decoration: none;
        }

        .topbar-btn:hover { background: #f3f4f6; color: #111; }

        .topbar-badge {
            position: absolute;
            top: 4px; right: 4px;
            width: 8px; height: 8px;
            background: #ef4444;
            border-radius: 50%;
            border: 2px solid #fff;
        }

        .topbar-divider {
            width: 1px; height: 24px;
            background: #e5e7eb;
            margin: 0 0.25rem;
        }

        /* ── Main Content ── */
        #main-content {
            margin-left: var(--sidebar-width);
            padding-top: var(--topbar-height);
            min-height: 100vh;
            transition: margin-left 0.25s ease;
        }

        .content-wrapper {
            padding: 1.5rem;
        }

        /* ── Page Header ── */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .page-header-left {}

        .page-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #111827;
            margin: 0 0 0.1rem;
        }

        .page-subtitle {
            font-size: 0.8rem;
            color: #9ca3af;
            margin: 0;
        }

        /* ── Flash alerts ── */
        .flash-zone { margin-bottom: 1.25rem; }

        .flash-zone .alert {
            border: none;
            border-radius: 10px;
            font-size: 0.875rem;
            border-left: 4px solid;
        }

        .alert-success { border-left-color: #22c55e; background: #f0fdf4; color: #166534; }
        .alert-danger  { border-left-color: #ef4444; background: #fef2f2; color: #991b1b; }

        /* ── Sidebar collapsed ── */
        body.sidebar-collapsed #sidebar { transform: translateX(calc(-1 * var(--sidebar-width))); }
        body.sidebar-collapsed #topbar  { left: 0; }
        body.sidebar-collapsed #main-content { margin-left: 0; }

        /* ── Mobile overlay ── */
        #sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.4);
            z-index: 999;
        }

        @media (max-width: 768px) {
            #sidebar { transform: translateX(calc(-1 * var(--sidebar-width))); }
            #topbar { left: 0; }
            #main-content { margin-left: 0; }
            body.sidebar-open #sidebar { transform: translateX(0); }
            body.sidebar-open #sidebar-overlay { display: block; }
        }

        /* ── Auth layout (no sidebar) ── */
        body.auth-page #sidebar,
        body.auth-page #topbar,
        body.auth-page #sidebar-overlay { display: none; }

        body.auth-page #main-content {
            margin-left: 0;
            padding-top: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: var(--body-bg);
        }

        body.auth-page .content-wrapper {
            width: 100%;
            max-width: 420px;
            padding: 2rem 1.5rem;
        }

        .auth-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            padding: 2.25rem 2rem;
        }

        .auth-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            margin-bottom: 1.75rem;
        }

        .auth-logo .brand-icon {
            width: 36px; height: 36px;
            font-size: 1.1rem;
        }

        .auth-logo .brand-name {
            font-size: 1.1rem;
            font-weight: 700;
            color: #111827;
            letter-spacing: -0.02em;
        }
    </style>
</head>

<body class="<?= !session()->get('logged_in') ? 'auth-page' : '' ?>">

<!-- Sidebar Overlay (mobile) -->
<div id="sidebar-overlay" onclick="toggleSidebar()"></div>

<!-- ── Sidebar ── -->
<aside id="sidebar">
    <a class="sidebar-brand" href="/">
        <div class="brand-icon"><i class="bi bi-check2-square"></i></div>
        <span class="brand-name">Task Manager</span>
    </a>

    <nav class="sidebar-nav">
        <div class="sidebar-section-label">Main</div>

        <a href="/tasks" class="nav-item-link <?= (uri_string() === 'tasks') ? 'active' : '' ?>">
            <i class="bi bi-list-task"></i>
            Tasks
        </a>

        <a href="/tasks/create" class="nav-item-link <?= (uri_string() === 'tasks/create') ? 'active' : '' ?>">
            <i class="bi bi-plus-circle"></i>
            New Task
        </a>

        <div class="sidebar-section-label" style="margin-top: 0.5rem;">Account</div>

        <?php if (session()->get('logged_in')): ?>
            <a href="/logout" class="nav-item-link">
                <i class="bi bi-box-arrow-right"></i>
                Logout
            </a>
        <?php else: ?>
            <a href="/login" class="nav-item-link <?= (uri_string() === 'login') ? 'active' : '' ?>">
                <i class="bi bi-box-arrow-in-right"></i>
                Login
            </a>
            <a href="/register" class="nav-item-link <?= (uri_string() === 'register') ? 'active' : '' ?>">
                <i class="bi bi-person-plus"></i>
                Register
            </a>
        <?php endif; ?>
    </nav>

    <?php if (session()->get('logged_in')): ?>
    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="user-avatar"><?= esc(substr(session()->get('user_name'), 0, 2)) ?></div>
            <div class="user-info">
                <div class="user-name"><?= esc(session()->get('user_name')) ?></div>
                <div class="user-role">Member</div>
            </div>
            <a href="/logout" class="logout-btn" title="Logout"><i class="bi bi-power"></i></a>
        </div>
    </div>
    <?php endif; ?>
</aside>

<!-- ── Topbar ── -->
<header id="topbar">
    <button id="sidebar-toggle" onclick="toggleSidebar()" title="Toggle sidebar">
        <i class="bi bi-list"></i>
    </button>

    <span class="topbar-breadcrumb">
        Task Manager &rsaquo; <span><?= esc($title ?? 'Dashboard') ?></span>
    </span>

    <div class="topbar-right">
        <a href="/tasks/create" class="topbar-btn" title="New Task">
            <i class="bi bi-plus-lg"></i>
        </a>
        <div class="topbar-divider"></div>
        <?php if (session()->get('logged_in')): ?>
            <a href="/logout" class="topbar-btn" title="Logout">
                <i class="bi bi-box-arrow-right"></i>
            </a>
        <?php else: ?>
            <a href="/login" class="topbar-btn" title="Login">
                <i class="bi bi-person"></i>
            </a>
        <?php endif; ?>
    </div>
</header>

<!-- ── Main Content ── -->
<main id="main-content">
    <div class="content-wrapper">

        <!-- Flash Messages -->
        <div class="flash-zone">
            <?php if (session()->getFlashdata('message')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    <?= session()->getFlashdata('message') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <ul class="mb-0 mt-1">
                        <?php foreach (session()->getFlashdata('errors') as $err): ?>
                            <li><?= esc($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
        </div>

        <?php if (!session()->get('logged_in')): ?>
        <div class="auth-card">
            <div class="auth-logo">
                <div class="brand-icon"><i class="bi bi-check2-square"></i></div>
                <span class="brand-name">Task Manager</span>
            </div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>

        <?php if (!session()->get('logged_in')): ?>
        </div>
        <?php endif; ?>

    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleSidebar() {
        if (window.innerWidth <= 768) {
            document.body.classList.toggle('sidebar-open');
        } else {
            document.body.classList.toggle('sidebar-collapsed');
            localStorage.setItem('sidebar-collapsed', document.body.classList.contains('sidebar-collapsed'));
        }
    }

    // Restore collapse state on desktop
    if (window.innerWidth > 768 && localStorage.getItem('sidebar-collapsed') === 'true') {
        document.body.classList.add('sidebar-collapsed');
    }
</script>
</body>
</html>