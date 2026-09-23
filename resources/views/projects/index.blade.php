<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects | ProjectFlow</title>

    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3.3 CDN & Bootstrap Icons -->
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

        /* Sidebar Desktop */
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
            z-index: 1040;
            transition: transform 0.3s ease-in-out;
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

        .brand-icon span {
            width: 3.5px;
            background-color: var(--emerald-primary);
            border-radius: 2px;
        }

        .brand-icon span:nth-child(1) { height: 18px; }
        .brand-icon span:nth-child(2) { height: 12px; }
        .brand-icon span:nth-child(3) { height: 18px; }

        .brand-text {
            font-size: 1.35rem;
            font-weight: 700;
            letter-spacing: -0.5px;
            color: #ffffff;
        }

        .sidebar-nav {
            margin-top: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

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

        .sidebar-nav .nav-link-custom:hover {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.05);
        }

        .sidebar-nav .nav-link-custom.active {
            background-color: var(--emerald-primary);
            color: #ffffff;
            box-shadow: 0 6px 18px 0 rgba(5, 150, 105, 0.4);
        }

        /* Workspace Content */
        .workspace-content {
            margin-left: 280px;
            padding: 2.5rem 3rem;
            min-height: 100vh;
            transition: margin-left 0.3s ease-in-out;
        }

        .minimal-card {
            background-color: var(--card-surface);
            border-radius: var(--card-radius);
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(167, 243, 208, 0.35);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .minimal-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 35px -10px rgba(5, 150, 105, 0.12);
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
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-pill-emerald:hover {
            background-color: var(--emerald-hover);
            border-color: var(--emerald-hover);
            color: #ffffff;
        }

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

        .badge-pill-status {
            border-radius: var(--pill-radius);
            padding: 0.35rem 0.85rem;
            font-weight: 500;
            font-size: 0.75rem;
            background-color: var(--emerald-soft);
            color: var(--emerald-hover);
        }

        .progress-pill {
            height: 6px;
            border-radius: var(--pill-radius);
            background-color: #e5e7eb;
        }

        .progress-pill .progress-bar {
            border-radius: var(--pill-radius);
            background-color: var(--emerald-primary);
        }

        /* Mobile Minimal Topbar Matching Screenshot */
        .mobile-header {
            display: none;
            background-color: #ffffff;
            padding: 0.75rem 1.25rem;
            border-bottom: 1px solid #eef2f5;
            position: sticky;
            top: 0;
            z-index: 1030;
        }

        .mobile-toggle-btn {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            width: 42px;
            height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #1e293b;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .mobile-toggle-btn:hover {
            background: #f1f5f9;
        }

        .mobile-title {
            font-size: 1.45rem;
            font-weight: 700;
            color: #1e293b;
            letter-spacing: -0.5px;
            text-decoration: none;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.45);
            backdrop-filter: blur(2px);
            z-index: 1035;
        }

        @media (max-width: 991.98px) {
            .mobile-header {
                display: flex;
                align-items: center;
                gap: 1rem;
            }

            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .sidebar-overlay.show {
                display: block;
            }

            .workspace-content {
                margin-left: 0;
                padding: 1.5rem 1rem;
            }
        }
    </style>
</head>
<body>

<!-- Mobile Header Bar Matching Screenshot -->
<div class="mobile-header">
    <button class="mobile-toggle-btn" id="sidebarToggle" aria-label="Toggle Navigation">
        <i class="bi bi-list fs-4"></i>
    </button>
    <a href="{{ route('projects.index') }}" class="mobile-title">
        ProjectFlow
    </a>
</div>

<!-- Backdrop Overlay for Mobile -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
    <div>
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('projects.index') }}" class="sidebar-brand w-100">
                <div class="brand-icon">
                    <span></span><span></span><span></span>
                </div>
                <span class="brand-text">ProjectFlow</span>
            </a>
            <button class="btn text-white-50 d-lg-none p-0 ps-2" id="sidebarClose">
                <i class="bi bi-x-lg fs-5"></i>
            </button>
        </div>

        <div class="sidebar-nav">
            <a href="{{ route('projects.index') }}" class="nav-link-custom {{ request()->routeIs('projects.*') ? 'active' : '' }}">
                <i class="bi bi-grid fs-5"></i>
                <span>Projects</span>
            </a>
            
            <a href="{{ route('users.index') }}" class="nav-link-custom {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <i class="bi bi-people fs-5"></i>
                <span>Users</span>
            </a>
        </div>
    </div>
</aside>

<!-- Main Workspace Content -->
<main class="workspace-content">
    
    <!-- Top Ribbon -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4 mb-lg-5 pb-2 border-bottom border-light">
        <div>
            <h3 class="fw-bold mb-1 fs-4 fs-sm-3" style="color: var(--text-primary);">Projects Directory</h3>
            <p class="small mb-0" style="color: var(--text-muted);">Overview of active workspace projects, team load, and deliverables</p>
        </div>

        <div class="d-flex align-items-center gap-2 w-100 w-sm-auto justify-content-start justify-content-sm-end">
            <a href="{{ route('projects.create') }}" class="btn-pill-emerald shadow-sm flex-grow-1 flex-sm-grow-0 justify-content-center">
                <i class="bi bi-plus-lg"></i> New Project
            </a>

            <form action="{{ route('logout') }}" method="POST" class="d-inline mb-0">
                @csrf
                <button type="submit" class="btn btn-outline-danger rounded-pill px-3 py-2 d-inline-flex align-items-center gap-2 small shadow-sm">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 bg-white border-start border-4 border-success shadow-sm mb-4" role="alert">
            <i class="bi bi-check2-circle text-success me-2 fs-5"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Search & Quick Metrics -->
    <div class="row g-3 align-items-center mb-4">
        <div class="col-12 col-md-5">
            <form action="{{ url()->current() }}" method="GET">
                <div class="position-relative">
                    <i class="bi bi-search position-absolute top-50 translate-middle-y ms-3" style="color: var(--text-muted);"></i>
                    <input type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        class="form-control form-control-pill ps-5 w-100" 
                        placeholder="Search projects..." 
                        onkeydown="if(event.key === 'Enter') this.form.submit();">
                </div>
            </form>
        </div>
        <div class="col-12 col-md-7 text-start text-md-end small" style="color: var(--text-muted);">
            <span>Total Projects: <strong style="color: var(--text-primary);">{{ $projects->count() }}</strong></span>
            <span class="mx-2">•</span>
            <span>Active: <strong style="color: var(--text-primary);">{{ $projects->where('project_status', '!=', 'completed')->count() }}</strong></span>
        </div>
    </div>

    <!-- Projects Grid -->
    <div class="row g-3 g-lg-4">
        @forelse($projects as $project)
            @php
                $totalTasks = $project->tasks ? $project->tasks->count() : 0;
                $completedTasks = $project->tasks ? $project->tasks->where('status', 'completed')->count() : 0;
                $progress = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
            @endphp
            <div class="col-12 col-md-6 col-lg-4">
                <div class="minimal-card p-3 p-sm-4 h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge-pill-status">
                                {{ ucfirst($project->project_status ?? 'Active') }}
                            </span>
                            <span class="small" style="color: var(--text-muted);">
                                <i class="bi bi-clock me-1"></i>{{ $project->created_at ? $project->created_at->format('M d') : 'Recent' }}
                            </span>
                        </div>

                        <h5 class="fw-bold mb-2 text-truncate">
                            <a href="{{ route('projects.show', $project) }}" class="text-decoration-none" style="color: var(--text-primary);">
                                {{ $project->project_name ?? $project->title }}
                            </a>
                        </h5>
                        <p class="small mb-4" style="color: var(--text-muted); min-height: 40px;">
                            {{ Str::limit($project->description, 90, '...') }}
                        </p>
                    </div>

                    <div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center small mb-2" style="color: var(--text-muted);">
                                <span style="font-size: 0.8rem; font-weight: 500;">Progress</span>
                                <span class="fw-semibold" style="color: var(--text-primary);">{{ $progress }}%</span>
                            </div>
                            <div class="progress progress-pill">
                                <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%"></div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center pt-3 border-top border-light">
                            <span class="small fw-medium" style="color: var(--text-muted);">
                                <i class="bi bi-check2-circle me-1" style="color: var(--emerald-primary);"></i> {{ $completedTasks }}/{{ $totalTasks }} Tasks
                            </span>

                            <div class="d-flex align-items-center gap-2">
                                <a href="{{ route('projects.show', $project) }}" class="btn-pill-emerald py-1 px-3 d-inline-flex align-items-center text-decoration-none" style="font-size: 0.82rem;">
                                    <span>Manage</span>
                                    <i class="bi bi-arrow-right ms-1"></i>
                                </a>

                                <form action="{{ route('projects.destroy', $project) }}" method="POST" class="m-0" onsubmit="return confirm('Delete Project?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light text-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" title="Delete Project">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 py-5 text-center">
                <div class="minimal-card p-4 p-sm-5 mx-auto" style="max-width: 480px;">
                    <i class="bi bi-folder-plus fs-1 d-block mb-3" style="color: var(--emerald-primary);"></i>
                    <h5 class="fw-bold" style="color: var(--text-primary);">No Projects Available</h5>
                    <p class="small mb-4" style="color: var(--text-muted);">Start creating projects to assign tasks and track team activities.</p>
                    <a href="{{ route('projects.create') }}" class="btn-pill-emerald">Create First Project</a>
                </div>
            </div>
        @endforelse
    </div>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const toggleBtn = document.getElementById('sidebarToggle');
    const closeBtn = document.getElementById('sidebarClose');

    function toggleMenu() {
        sidebar.classList.toggle('show');
        overlay.classList.toggle('show');
    }

    if(toggleBtn) toggleBtn.addEventListener('click', toggleMenu);
    if(closeBtn) closeBtn.addEventListener('click', toggleMenu);
    if(overlay) overlay.addEventListener('click', toggleMenu);
</script>
</body>
</html>