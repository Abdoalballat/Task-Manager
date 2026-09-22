<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') | ProjectFlow</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --bg-canvas: #f2f7f5;
            --card-surface: #ffffff;
            --text-primary: #132a24;
            --text-muted: #5a7369;
            --sidebar-bg: #0b1f1a;
            --sidebar-border: rgba(255, 255, 255, 0.08);
            --emerald-primary: #059669;
            --emerald-hover: #047857;
            --emerald-soft: #d1fae5;
            --pill-radius: 9999px;
            --card-radius: 24px;
            --shadow-soft: 0 12px 30px -10px rgba(5, 150, 105, 0.08);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-canvas);
            color: var(--text-primary);
            margin: 0;
            overflow-x: hidden;
        }

        .sidebar {
            width: 280px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: var(--sidebar-bg);
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            z-index: 1050;
            transition: transform 0.3s ease;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            text-decoration: none;
            color: #ffffff;
            padding-bottom: 1.25rem;
            border-bottom: 1px solid var(--sidebar-border);
        }

        .brand-icon {
            width: 38px;
            height: 38px;
            border: 2px solid var(--emerald-primary);
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 3px;
        }

        .brand-icon span { width: 3.5px; background-color: var(--emerald-primary); border-radius: 2px; }
        .brand-icon span:nth-child(1) { height: 18px; }
        .brand-icon span:nth-child(2) { height: 12px; }
        .brand-icon span:nth-child(3) { height: 18px; }

        .brand-text { font-size: 1.35rem; font-weight: 700; color: #ffffff; }

        .sidebar-nav { margin-top: 1.5rem; display: flex; flex-direction: column; gap: 0.5rem; }
        .sidebar-nav .nav-link-custom {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            padding: 0.85rem 1.2rem;
            border-radius: 14px;
            font-weight: 500;
            font-size: 0.95rem;
            text-decoration: none;
            color: #8da59d;
            transition: all 0.2s ease;
        }

        .sidebar-nav .nav-link-custom:hover { color: #ffffff; background-color: rgba(255, 255, 255, 0.05); }
        .sidebar-nav .nav-link-custom.active {
            background-color: var(--emerald-primary);
            color: #ffffff;
            box-shadow: 0 6px 18px 0 rgba(5, 150, 105, 0.4);
        }

        .workspace-content {
            margin-left: 280px;
            padding: 2.5rem 3rem;
            min-height: 100vh;
            transition: margin 0.3s ease;
        }

        .minimal-card {
            background-color: var(--card-surface);
            border-radius: var(--card-radius);
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(167, 243, 208, 0.35);
        }

        .btn-pill-emerald {
            background-color: var(--emerald-primary);
            color: #ffffff;
            border-radius: var(--pill-radius);
            padding: 0.65rem 1.4rem;
            font-weight: 500;
            font-size: 0.88rem;
            border: 1px solid var(--emerald-primary);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-pill-emerald:hover { background-color: var(--emerald-hover); border-color: var(--emerald-hover); color: #ffffff; }

        .form-control-pill {
            border-radius: var(--pill-radius);
            background-color: #ffffff;
            border: 1px solid #d1fae5;
            padding: 0.65rem 1.4rem;
            font-size: 0.88rem;
            color: var(--text-primary);
        }

        .form-control-pill:focus {
            border-color: var(--emerald-primary);
            box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.15);
            outline: none;
        }

        /* Mobile Adjustments */
        @media (max-width: 991.98px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.active { transform: translateX(0); }
            .workspace-content { margin-left: 0; padding: 1.5rem 1rem; }
            .mobile-header { display: flex !important; }
        }
        .mobile-header { display: none; }
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1040;
        }
        .sidebar-overlay.active { display: block; }
    </style>
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- Mobile Toggle Bar -->
<div class="mobile-header justify-content-between align-items-center p-3 bg-white border-bottom">
    <div class="d-flex align-items-center gap-2">
        <button class="btn btn-sm btn-light" id="sidebarToggle"><i class="bi bi-list fs-4"></i></button>
        <span class="fw-bold fs-5 text-dark">ProjectFlow</span>
    </div>
    @auth
        <span class="badge bg-light text-dark border">{{ Auth::user()->user_name }}</span>
    @endauth
</div>

<!-- Left Sidebar -->
<aside class="sidebar" id="sidebar">
    <div>
        <a href="{{ route('projects.index') }}" class="sidebar-brand">
            <div class="brand-icon">
                <span></span><span></span><span></span>
            </div>
            <span class="brand-text">ProjectFlow</span>
        </a>
        @if (Auth::user()?->role ==='admin')
        <div class="sidebar-nav">
            <a href="{{ route('projects.index') }}" class="nav-link-custom {{ request()->routeIs('projects.*') ? 'active' : '' }}">
                <i class="bi bi-grid fs-5"></i>
                <span>Projects</span>
            </a>
            
            <a href="{{ route('users.index') }}" class="nav-link-custom {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <i class="bi bi-people fs-5" ></i>
                <span>Users</span>
            </a>
        </div>
        @elseif(Auth::user()?->role ==='employee')
            <div class="sidebar-nav">

                <a href="{{ route('my_tasks') }}" class="nav-link-custom active">
                <i class="bi bi-people fs-5" ></i>
                <span>My tasks</span>
                </a>
                </div>
        @endif
    </div>

</aside>

<!-- Main Body -->
<main class="workspace-content">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 bg-white border-start border-4 border-success shadow-sm mb-4" role="alert">
            <i class="bi bi-check2-circle text-success me-2 fs-5"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const toggleBtn = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');

    if(toggleBtn) {
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        });
        overlay.addEventListener('click', () => {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        });
    }
        document.addEventListener('DOMContentLoaded', () => {
const alertElement = document.getElementById('auto-dismiss-alert');

if (alertElement) {
    setTimeout(() => {
      // Initialize or get the Bootstrap Alert instance
    const bsAlert = bootstrap.Alert.getOrCreateInstance(alertElement);
      // Triggers the fade out and removes the element from DOM
    bsAlert.close();
    }, 3000); // 3000ms = 3 seconds
}
});
</script>
</body>
</html>