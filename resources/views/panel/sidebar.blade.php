<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="/"><i class="icon-speedometer"></i> Dashboard </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('jabatan.index')}}"><i class="fa fa-list"></i> Jabatan </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('jenis-tunjangan.index')}}"><i class="fa fa-book"></i> Jenis
                    Tunjangan </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('karyawan.index')}}"><i class="fa fa-user"></i> Karyawan </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('tunjangan-jabatan.index')}}"><i class="fa fa-book"></i> Tunjangan
                    Jabatan </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('absensi.index')}}"><i class="fa fa-newspaper-o"></i> Absensi </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('gaji.index')}}"><i class="fa fa-sticky-note"></i> Struck Gaji </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('users.index')}}"><i class="fa fa-user"></i> Admin </a>
            </li>

            <li class="nav-title">
                Logout
            </li>
            <li class="nav-item">
                <a class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                <i class="fa fa-lock"></i> Logout </a>
            </li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
              </form>
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
