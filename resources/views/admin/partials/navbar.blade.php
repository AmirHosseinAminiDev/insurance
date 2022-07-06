<!-- begin::navbar -->
<nav class="navbar">
    <div class="container-fluid">

        <div class="header-logo">
            <a href="#">
                <img src="{{ asset('logo.png') }}" alt="...">
            </a>
        </div>

        <div class="header-body">
            <ul class="navbar-nav">
                <li class="nav-item dropdown d-none d-lg-block">
                    <a href="#" class="nav-link" data-toggle="dropdown">
                        <i class="fa fa-th-large"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-nav-grid">
                        <div class="dropdown-menu-title">منوی سریع</div>
                        <div class="dropdown-menu-body">
                            <div class="nav-grid">
                                <div class="nav-grid-row">
                                    <a href="{{ route('sales.index') }}" class="nav-grid-item">
                                        <i class="fa fa-money"></i>
                                        <span>فروش</span>
                                    </a>
                                    <a href="{{ route('insurances.list') }}" class="nav-grid-item">
                                        <i class="fa fa-rocket"></i>
                                        <span>بیمه ها</span>
                                    </a>
                                </div>
                                <div class="nav-grid-row">
                                    <a href="{{ route('customers.list') }}" class="nav-grid-item">
                                        <i class="fa fa-user"></i>
                                        <span>مشتریان</span>
                                    </a>
                                    <a href="{{ route('admin.dashboard') }}" class="nav-grid-item">
                                        <i class="fa fa-dashboard"></i>
                                        <span>داشبورد</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="#" class="d-lg-none d-sm-block nav-link search-panel-open">
                        <i class="fa fa-search"></i>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" data-toggle="dropdown">
                        <figure class="avatar avatar-sm avatar-state-success">
                            <img class="rounded-circle" src="{{ asset('admin/assets/media/image/avatar.jpg') }}" alt="...">
                        </figure>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="{{ route('profile.show') }}" class="dropdown-item">پروفایل</a>
                        <div class="dropdown-divider"></div>
                        <form action="{{ route('logout') }}" method="post" id="logoutForm">
                            @csrf
                        </form>
                        <a href="#" class="text-danger dropdown-item" onclick="return confirm('آیا میخواهید خارج شوید؟')?logout():'';">خروج</a>
                    </div>
                </li>
                <li class="nav-item d-lg-none d-sm-block">
                    <a href="#" class="nav-link side-menu-open">
                        <i class="ti-menu"></i>
                    </a>
                </li>
            </ul>
        </div>

    </div>
</nav>
<!-- end::navbar -->

<script>
function logout()
{
    document.getElementById('logoutForm').submit();
}
</script>
