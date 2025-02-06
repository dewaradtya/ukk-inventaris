<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3"
    id="sidenav-main">
    <div class="sidenav-header d-flex justify-content-center align-items-center position-relative">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="align-items-center d-flex m-0 navbar-brand text-wrap" href="{{ route('dashboard.index') }}">
            <img src="{{ asset('assets/img/logo.png') }}" class="navbar-brand-img h-100" alt="...">
        </a>
    </div>

    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" href="{{ url('dashboard') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-home ps-2 pe-2 text-center text-dark {{ Request::is('dashboard') ? 'text-white' : 'text-dark' }} "
                            aria-hidden="true"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item mt-2">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Pages</h6>
            </li>
           @if (Auth::check() && Auth::user()->level->name === 'Admin')
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('type') ? 'active' : '' }}" href="{{ url('type') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-boxes ps-2 pe-2 text-center text-dark {{ Request::is('type') ? 'text-white' : 'text-dark' }} "
                                aria-hidden="true"></i>
                        </div>
                        <span class="nav-link-text ms-1">Jenis Inventaris</span>
                    </a>
                </li>
            @endif

           @if (Auth::check() && Auth::user()->level->name === 'Admin')
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('room') ? 'active' : '' }}" href="{{ url('room') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-door-open ps-2 pe-2 text-center text-dark {{ Request::is('room') ? 'text-white' : 'text-dark' }} "
                                aria-hidden="true"></i>
                        </div>
                        <span class="nav-link-text ms-1">Ruang Inventaris</span>
                    </a>
                </li>
            @endif

            <li class="nav-item">
                <a class="nav-link {{ Request::is('employee') ? 'active' : '' }}" href="{{ url('employee') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-user-tie ps-2 pe-2 text-center text-dark {{ Request::is('employee') ? 'text-white' : 'text-dark' }} "
                            aria-hidden="true"></i>
                    </div>
                    <span class="nav-link-text ms-1">Pegawai</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Request::is('borrowing') ? 'active' : '' }}" href="{{ url('borrowing') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-book ps-2 pe-2 text-center text-dark {{ Request::is('borrowing') ? 'text-white' : 'text-dark' }} "
                            aria-hidden="true"></i>
                    </div>
                    <span class="nav-link-text ms-1">Peminjaman</span>
                </a>
            </li>

           @if (Auth::check() && Auth::user()->level->name === 'Admin')
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('inventory') ? 'active' : '' }}" href="{{ url('inventory') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-boxes ps-2 pe-2 text-center text-dark {{ Request::is('inventory') ? 'text-white' : 'text-dark' }} "
                                aria-hidden="true"></i>
                        </div>
                        <span class="nav-link-text ms-1">Inventaris</span>
                    </a>
                </li>
            @endif

           @if (Auth::check() && Auth::user()->level->name === 'Admin')
                <li class="nav-item mt-2">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Account Pages</h6>
                </li>
            @endif

           @if (Auth::check() && Auth::user()->level->name === 'Admin')
                <li class="nav-item pb-2">
                    <a class="nav-link {{ Request::is('user-management') ? 'active' : '' }}"
                        href="{{ url('user-management') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i style="font-size: 1rem;"
                                class="fas fa-lg fa-users-gear ps-2 pe-2 text-center text-dark {{ Request::is('user-management') ? 'text-white' : 'text-dark' }} "
                                aria-hidden="true"></i>
                        </div>
                        <span class="nav-link-text ms-1">User Management</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</aside>
