<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DSS Kurir GoTo - @yield('title')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #1a237e 0%, #283593 100%);
        }
        .sidebar .nav-link {
            color: #fff;
            padding: 12px 20px;
            margin: 2px 0;
        }
        .sidebar .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
        }
        .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            border-left: 4px solid #4fc3f7;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .stat-card {
            border-left: 4px solid;
        }
        .stat-card.bg-primary { border-left-color: #1a237e; }
        .stat-card.bg-success { border-left-color: #2e7d32; }
        .stat-card.bg-warning { border-left-color: #f57c00; }
        .stat-card.bg-info { border-left-color: #0288d1; }
    </style>
</head>

<body>
<div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
        <nav class="col-md-2 d-md-block sidebar p-0">
            <div class="position-sticky pt-3">
                <div class="text-center py-4">
                    <h4 class="text-white">
                        <i class="fas fa-truck-fast"></i> DSS Kurir GoTo
                    </h4>
                    <small class="text-light">Sistem Pendukung Keputusan</small>
                </div>

                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}"
                           href="{{ route('dashboard') }}">
                            <i class="fas fa-home me-2"></i> Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('kurir*') ? 'active' : '' }}"
                           href="{{ route('kurir.index') }}">
                            <i class="fas fa-users me-2"></i> Data Kurir
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('kriteria*') ? 'active' : '' }}"
                           href="{{ route('kriteria.index') }}">
                            <i class="fas fa-list-check me-2"></i> Kriteria & Bobot
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('perhitungan*') ? 'active' : '' }}"
                           href="{{ route('perhitungan.index') }}">
                            <i class="fas fa-calculator me-2"></i> Perhitungan SMART
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('ranking*') ? 'active' : '' }}"
                           href="{{ route('ranking.index') }}">
                            <i class="fas fa-trophy me-2"></i> Ranking Kurir
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('laporan*') ? 'active' : '' }}"
                           href="{{ route('laporan.index') }}">
                            <i class="fas fa-file-pdf me-2"></i> Laporan
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('periode*') ? 'active' : '' }}"
                           href="{{ route('periode.index') }}">
                            <i class="fas fa-file-pdf me-2"></i> Periode
                        </a>
                    </li>

                    {{-- @if(auth()->user()->role === 'admin' || auth()->user()->role === 'manager')
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('users*') ? 'active' : '' }}"
                           href="{{ route('users.index') }}">
                            <i class="fas fa-user-shield me-2"></i> Pengguna & Akses
                        </a>
                    </li>
                    @endif --}}
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="col-md-10 ms-sm-auto px-md-4">

            <!-- Top Navbar -->
            <nav class="navbar navbar-light bg-white border-bottom py-3">
                <div class="container-fluid d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">@yield('title')</h4>

                    <div class="d-flex align-items-center gap-2">
                        <!-- Periode -->
                        <span class="badge bg-primary">
                            <i class="fas fa-calendar-alt me-1"></i>
                            Periode: {{ date('F Y') }}
                        </span>

                        <!-- User Dropdown -->
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle"
                                    type="button"
                                    data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-1"></i>
                                {{ auth()->user()->name }}
                            </button>

                            <ul class="dropdown-menu dropdown-menu-end">
                                <li class="dropdown-item text-muted">
                                    Role: {{ auth()->user()->role }}
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-1"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Content -->
            <div class="container-fluid py-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
