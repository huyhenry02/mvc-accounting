@php use App\Models\User; @endphp
<div class="main-header">
    <div class="main-header-logo">
        <!-- Logo Header -->
        <div class="logo-header">
            <a href="#" class="logo">
                <img
                    src="/assets/img/LOGO.png"
                    alt="navbar brand"
                    class="navbar-brand"
                />
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <!-- Navbar Header -->
    <nav
        class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom"
        style="background-color: #0a5a97"
    >
        <div class="container-fluid">
            @php
                use Illuminate\Support\Facades\Route;
                $routeName = Route::currentRouteName();
            @endphp
            <nav
                class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex"
                style="color: #fff"
            >
                <h3 style="color: #fff">
                    @switch( $routeName )
                        @case('general_catalog.showIndexDepartment')
                            Danh sách phòng ban
                            @break
                        @case('general_catalog.showIndexPosition')
                            Danh sách chức vụ
                            @break
                        @case('general_catalog.showIndexEmployee')
                            Danh sách nhân viên
                            @break
                        @case('general_catalog.showUpdateEmployee')
                            Cập nhật nhân viên
                            @break
                        @case('allowance_deduction.showIndexDeduction')
                            Bảng tổng hợp trích nộp
                            @break
                        @case('allowance_deduction.showIndexAllowance')
                            Bảng tổng hợp phụ cấp
                            @break
                        @case('attendance.showDetailAttendance')
                            Bảng công chi tiết
                            @break
                        @case('attendance.showSummary')
                            Tổng hợp bảng công
                            @break
                        @case('attendance.showOvertime')
                            Danh sách ca làm thêm
                            @break
                        @case('accounting.showEmployeeBonus')
                            Thương nhân viên
                            @break
                        @case('accounting.showIndex')
                            Bảng lương
                            @break
                        @case('accounting.showPayment')
                            Bảng thanh toán lương
                            @break
                    @endswitch
                </h3>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="#">
                            <i class="icon-home" style="color: #fff"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item" style="color: #fff">
                        @if ( Route::currentRouteName() === 'general_catalog.showIndexEmployee')
                            <a href="{{ route('general_catalog.showIndexEmployee') }}" style="color: #fff">Quản lý nhân viên</a>
                        @elseif ( Route::currentRouteName() === 'general_catalog.showIndexDepartment')
                            <a href="{{ route('general_catalog.showIndexDepartment') }}" style="color: #fff">Quản lý phòng ban</a>
                        @elseif ( Route::currentRouteName() === 'general_catalog.showIndexPosition')
                            <a href="{{ route('general_catalog.showIndexPosition') }}" style="color: #fff">Quản lý chức vụ</a>
                        @elseif ( Str::startsWith($routeName, 'allowance_deduction'))
                            <a href="{{ route('allowance_deduction.showIndexDeduction') }}" style="color: #fff">Trích nộp và phụ cấp</a>
                        @elseif ( Str::startsWith($routeName, 'attendance'))
                            <a href="{{ route('attendance.showDetailAttendance') }}" style="color: #fff"> Quản lý chấm công </a>
                        @elseif ( Str::startsWith($routeName, 'accounting'))
                            <a href="{{ route('accounting.showIndex') }}" style="color: #fff"> Tính lương và thanh toán </a>
                        @endif
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        @switch( $routeName )
                            @case('general_catalog.showIndexDepartment')
                                <a href="{{ route('general_catalog.showIndexDepartment') }}" style="color: #fff">Phòng ban</a>
                                @break
                            @case('general_catalog.showIndexPosition')
                                <a href="{{ route('general_catalog.showIndexPosition') }}" style="color: #fff">Chức vụ</a>
                                @break
                            @case('general_catalog.showIndexEmployee')
                            @case('general_catalog.showUpdateEmployee')
                                <a href="{{ route('general_catalog.showIndexEmployee') }}" style="color: #fff">Nhân viên</a>
                                @break
                            @case('allowance_deduction.showIndexDeduction')
                                <a href="{{ route('allowance_deduction.showIndexDeduction') }}" style="color: #fff">Trích nộp</a>
                                @break
                            @case('allowance_deduction.showIndexAllowance')
                                <a href="{{ route('allowance_deduction.showIndexAllowance') }}" style="color: #fff">Phụ cấp</a>
                                @break
                            @case('attendance.showDetailAttendance')
                                <a href="{{ route('attendance.showDetailAttendance') }}" style="color: #fff">Chi tiết</a>
                                @break
                            @case('attendance.showSummary')
                                <a href="#" style="color: #fff">Tổng hợp</a>
                                @break
                            @case('attendance.showOvertime')
                                <a href="#" style="color: #fff">Làm thêm giờ</a>
                                @break
                            @case('accounting.showIndex')
                            @case('accounting.showPayment')

                                <a href="#" style="color: #fff">Lương </a>
                                @break
                            @case('accounting.showEmployeeBonus')
                                <a href="#" style="color: #fff">Thưởng </a>
                                @break
                        @endswitch
                    </li>
                </ul>
            </nav>
            <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <li
                    class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none"
                >
                    <a
                        class="nav-link dropdown-toggle"
                        data-bs-toggle="dropdown"
                        href="#"
                        role="button"
                        aria-expanded="false"
                        aria-haspopup="true"
                    >
                        <i class="fa fa-search"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-search animated fadeIn">
                    </ul>
                </li>

                <li class="nav-item topbar-user dropdown hidden-caret">
                    <a
                        class="dropdown-toggle profile-pic"
                        data-bs-toggle="dropdown"
                        href="#"
                        aria-expanded="false"
                    >
                        <div class="avatar-sm">
                            <img
                                src="/assets/img/profile.jpg"
                                alt="..."
                                class="avatar-img rounded-circle"
                            />
                        </div>
                        <span class="profile-username">
                      <span class="op-7" style="color: #fff">Xin chào,</span>
                      <span class="fw-bold" style="color: #fff">{{ auth()->user()?->employee->full_name ?? '' }}</span>
                    </span>
                    </a>
                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <div class="dropdown-user-scroll scrollbar-outer">
                            <li>
                                <div class="user-box">
                                    <div class="avatar-lg">
                                        <img
                                            src="/assets/img/profile.jpg"
                                            alt="image profile"
                                            class="avatar-img rounded"
                                        />
                                    </div>
                                    <div class="u-text">
                                        <h4>{{ auth()->user()?->employee->full_name ?? '' }}</h4>
                                        <p class="text-muted">{{ auth()->user()?->role ? User::ROLES[auth()->user()?->role] : '' }}</p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('auth.logout') }}">Đăng xuất</a>
                            </li>
                        </div>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</div>
