<!-- begin::side menu -->
<div class="side-menu">
    <div class="side-menu-body">
        <ul>
            <li class="side-menu-divider">فهرست</li>
            <li><a href="{{ route('admin.dashboard') }}"><i class="icon ti-home"></i> <span>داشبورد</span> </a></li>
            <li><a href="{{ route('insurances.list') }}"><i class="icon ti-rocket"></i> <span>بیمه ها</span> </a></li>
            <li><a href="{{ route('customers.list') }}"><i class="icon ti-user"></i> <span>مشتریان</span> </a></li>
            <li><a href="#"><i class="icon ti-money"></i> <span>فروش</span> </a>
                <ul>
                    <li><a href="{{ route('sales.index') }}">فروش بیمه </a></li>
                    <li><a href="{{ route('payments.index') }}">لیست پرداخت ها</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
<!-- end::side menu -->
