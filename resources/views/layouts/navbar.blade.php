<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>@yield('title', 'Sistem Informasi Cagar Budaya') | SIM Cagar Budaya</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('sbadmin/assets/img/favicon.png') }}" />
    <link href="{{ asset('sbadmin/css/styles.css') }}" rel="stylesheet" />

    {{-- CSS Tambahan dari Child View --}}
    @stack('styles')

    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous">
    </script>
</head>

<body class="nav-fixed">
    <nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start navbar-light bg-white"
        id="sidenavAccordion">
        <button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 me-2 ms-lg-2 me-lg-0" id="sidebarToggle"><i
                data-feather="menu"></i></button>
        <a class="navbar-brand pe-3 ps-4 ps-lg-2" href="#">SIM Cagar Budaya</a>

        <ul class="navbar-nav align-items-center ms-auto">
            <li class="nav-item dropdown no-caret dropdown-user me-3 me-lg-4">
                <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage"
                    href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <img class="img-fluid"
                        src="{{ asset('sbadmin/assets/img/illustrations/profiles/profile-1.png') }}" />
                </a>
                <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up"
                    aria-labelledby="navbarDropdownUserImage">
                    <h6 class="dropdown-header d-flex align-items-center">
                        <img class="dropdown-user-img"
                            src="{{ asset('sbadmin/assets/img/illustrations/profiles/profile-1.png') }}" />
                        <div class="dropdown-user-details">
                            <div class="dropdown-user-details-name">{{ auth()->user()->name }}</div>
                            <div class="dropdown-user-details-email">{{ auth()->user()->email }}</div>
                        </div>
                    </h6>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <div class="dropdown-item-icon"><i data-feather="log-out"></i></div> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                </div>
            </li>
        </ul>
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            @include('layouts.partial.sidebar')
        </div>
        <div id="layoutSidenav_content">
            @yield('content')
            <footer class="footer admin-footer mt-auto footer-light">
                <div class="container-xl px-4">
                    <div class="row">
                        <div class="col-md-6 small">Copyright &copy; SIM Cagar Budaya 2026</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.3.min.js" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('sbadmin/js/scripts.js') }}"></script>

    {{-- JS Tambahan dari Child View --}}
    @stack('scripts')
</body>

</html>
