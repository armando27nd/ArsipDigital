<style>
/* Lebar sidebar sedikit diperbesar, tetap proporsional */
.main-sidebar {
    width: 240px;
    /* Default biasanya sekitar 250px */
}

/* sidebar.blade.php */
.sidebar {
    /* height: calc(100vh - 95px); Mengatur tinggi div sidebar */
    /* overflow-y: auto !important; Memaksa scrollbar vertikal muncul jika perlu */
    padding-bottom: 40px; /*Memberi sedikit ruang di bawah item terakhir*/
}
/* Sesuaikan brand/logo */
.brand-link {
    height: 95px;
    font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
    padding: 4 2rem;
    display: flex;
    align-items: center;
}

/* Ukuran logo yang proporsional */
.brand-link img {
    width: 55px;
    height: 50px;
    margin-right: 10px;
}

/* Font menu sedang, tidak terlalu besar */
.nav-sidebar>.nav-item>.nav-link {
    font-size: 1.25rem;
    padding: 1.2rem 1.6rem;
}

/* Ukuran ikon sedikit lebih besar, tapi tidak oversized */
.nav-sidebar .nav-icon {
    font-size: 2.2rem;
    width: 2.5rem;
}

/* Margin teks */
.nav-sidebar .nav-link p {
    margin-left: 10px;
    font-weight: 550;
}
</style>

<aside class="main-sidebar sidebar-dark elevation-4">
    <a href="{{ url('/') }}" class="brand-link">
<img src="{{ asset('img-pemkab.png') }}" alt="Logo"
        class="brand-image elevation-3">
    <span class="brand-text font-weight-light">Arsip Disnaker</span>
</a>

    <!-- Sidebar -->
    <div class="sidebar">
        @auth
        @php
        $role = auth()->user()->role;
        @endphp

        @if(in_array($role, ['admin', 'user']))
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>BERANDA</p>
                    </a>
                </li>

                <!-- Manajemen Pengguna khusus admin -->
                @if($role === 'admin')
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}"
                        class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>PENGGUNA</p>
                    </a>
                </li>
                @endif

                <li class="nav-item">
                    <a href="{{ route('surat-keluar.index') }}"
                        class="nav-link {{ request()->routeIs('surat-keluar.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-paper-plane"></i>
                        <p>SURAT KELUAR</p>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="{{ route('surat-masuk.index') }}"
                        class="nav-link {{ request()->routeIs('surat-masuk.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-envelope"></i>
                        <p>SURAT MASUK</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('agenda.index') }}"
                        class="nav-link {{ request()->routeIs('agenda.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-calendar-alt"></i>
                        <p>AGENDA</p>
                    </a>
                </li>


                @php
    // Logika untuk menentukan apakah menu induk Laporan harus aktif/terbuka
    $isLaporanMenuActive = request()->routeIs('arsip.*') || request()->routeIs('jadwal-kegiatan.*');
@endphp

<li class="nav-item {{ $isLaporanMenuActive ? 'menu-open' : '' }}">
    {{-- Link Induk / Parent --}}
    <a href="#" class="nav-link {{ $isLaporanMenuActive ? 'active' : '' }}">
        <i class="nav-icon fas fa-file-alt"></i>
        <p>LAPORAN</p>
        <i class="right fas fa-angle-left"></i>
    </a>
    {{-- Sub-menu --}}
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ url('/arsip') }}" class="nav-link {{ request()->routeIs('arsip.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>ARSIP</p>
            </a>
        </li>
        <li class="nav-item">
            {{-- Pastikan Anda sudah membuat route untuk URL ini di routes/web.php --}}
            <a href="{{ url('/laporan') }}" class="nav-link {{ request()->routeIs('jadwal-kegiatan.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p style="font-size: 75%;">JADWAL KEGIATAN HARIAN</p>
            </a>
        </li>
    </ul>
</li>

                <li class="nav-item">
                    {{-- Logika langsung dimasukkan ke dalam href, menggunakan variabel $role yang sudah ada --}}
                    <a href="{{ $role === 'admin' ? route('admin.disposisi.index') : route('user.disposisi.index') }}"
                        class="nav-link {{ request()->routeIs('admin.disposisi.*') || request()->routeIs('user.disposisi.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-signature"></i>
                        <p>DISPOSISI</p>
                    </a>
                </li>
            </ul>
        </nav>
        @else
        <p class="text-white text-center mt-3">Sidebar tidak tersedia untuk role ini.</p>
        @endif
        @endauth



    </div>
    <!-- /.sidebar -->
</aside>
