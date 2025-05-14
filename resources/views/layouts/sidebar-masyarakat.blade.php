<!-- Sidebar -->
<div id="wrapper">
    <ul class="navbar-nav bg-main sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('masyarakat.dashboard') }}">
        <img
            src="{{ asset('storage/foto_profil/logo.png') }}">
    </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Menu Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('masyarakat.dashboard') }}">
                <i class="fas fa-fw fa-home"></i>
                <span>Dashboard</span></a>
        </li>

        <!-- Input Pengaduan -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('masyarakat.pengaduan.create') }}">
                <i class="fas fa-fw fa-pen"></i>
                <span>Insert Pengaduan</span></a>
        </li>

        <!-- Menu Pengaduan -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('masyarakat.pengaduan.index') }}">
                <i class="fas fa-fw fa-inbox"></i>
                <span>Data Pengaduan</span></a>
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
</div>
<!-- End of Sidebar -->
