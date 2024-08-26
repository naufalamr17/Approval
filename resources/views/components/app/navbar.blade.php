<nav class="navbar navbar-main navbar-expand-lg mx-5 px-0 shadow-none rounded" id="navbarBlur" navbar-scroll="true">
    <div class="container-fluid py-1 px-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-1 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Travel Management System</a></li>
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page">
                    {{ __(str_replace('-', ' ', ucfirst(Route::currentRouteName()))) }}
                </li>
            </ol>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            </div>
            <div class="mb-0 font-weight-bold breadcrumb-text text-white">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="logout" onclick="event.preventDefault();
                this.closest('form').submit();">
                        <button class="btn btn-sm btn-white mb-0 me-1" type="submit">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </a>
                </form>
            </div>
            <ul class="navbar-nav  justify-content-end">
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </li>
                <!-- <li class="nav-item ps-2 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0">
                        <img src="../assets/img/team-2.jpg" class="avatar avatar-sm" alt="avatar" />
                    </a>
                </li> -->
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->