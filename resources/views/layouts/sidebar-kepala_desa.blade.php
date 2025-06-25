<!-- Sidebar -->
<ul class="navbar-nav bg-main sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('kepala_desa.dashboard') }}">
        <img
            src="{{ asset('storage/foto_profil/logo.png') }}">
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Menu Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('kepala_desa.dashboard') }}">
            <i class="fas fa-fw fa-home"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Menu Pengaduan -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('kepala_desa.pengaduan.index') }}">
            <i class="fas fa-fw fa-inbox"></i>
            <span>Daftar Pengaduan</span></a>
    </li>

    <!-- Logout -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Keluar</span></a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </li>
</ul>
<!-- End of Sidebar -->
