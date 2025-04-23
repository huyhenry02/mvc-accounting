<?php
$routesGeneralCatalog = [
    'general_catalog.showIndexEmployee',
];
$isActiveGeneralCatalog = collect($routesGeneralCatalog)->contains(fn($route) => request()->routeIs($route));

$routesDepartment = [
    'general_catalog.showIndexDepartment',
];
$isActiveDepartment = collect($routesDepartment)->contains(fn($route) => request()->routeIs($route));

$routesPosition = [
    'general_catalog.showIndexPosition',
];
$isActivePosition = collect($routesPosition)->contains(fn($route) => request()->routeIs($route));

$routesDepartmentPosition = [
    'general_catalog.showIndexDepartment',
    'general_catalog.showIndexPosition',
];
$isActiveDepartmentPosition = collect($routesDepartmentPosition)->contains(fn($route) => request()->routeIs($route));

$routesAllowanceDeduction = [
    'allowance_deduction.showIndexDeduction',
    'allowance_deduction.showIndexAllowance',
];
$isActiveAllowanceDeduction = collect($routesAllowanceDeduction)->contains(fn($route) => request()->routeIs($route));

$routesAttendance = [
    'attendance.showDetailAttendance',
    'attendance.showSummary',
    'attendance.showOvertime',
    'attendance.detail-attendance.load',
];
$isActiveAttendance = collect($routesAttendance)->contains(fn($route) => request()->routeIs($route));

$routesAccounting = [
    'accounting.showIndex',
    'accounting.showEmployeeBonus',
    'accounting.showPayment',
];
$isActiveAccounting = collect($routesAccounting)->contains(fn($route) => request()->routeIs($route));
?>
<div class="sidebar">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" style="background-color: #0a5a97">
            <a href="#" class="logo">
                <img
                    src="/assets/img/LOGO.png"
                    alt="navbar brand"
                    class="navbar-brand"
                    height="60"
                    style=" margin-left: 10px;"
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
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item {{ $isActiveGeneralCatalog ? 'active' : '' }}">
                    <a
                        data-bs-toggle="collapse"
                        href="#general_catalog"
                        class="collapsed"
                        aria-expanded="false"
                    >
                        <i class="fas fa-list-alt"></i>
                        <p>Quản lý nhân viên </p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ $isActiveGeneralCatalog ? 'show' : '' }}" id="general_catalog">
                        <ul class="nav nav-collapse">
                            <li class="{{ request()->routeIs([
                                        'general_catalog.showIndexEmployee',
                                        ]) ? 'active' : '' }}"
                            >
                                <a href="{{ route('general_catalog.showIndexEmployee') }}">
                                    <span class="sub-item">Danh sách nhân viên</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item {{ $isActiveDepartment ? 'active' : '' }}">
                    <a
                        data-bs-toggle="collapse"
                        href="#department"
                        class="collapsed"
                        aria-expanded="false"
                    >
                        <i class="fas fa-list-alt"></i>
                        <p>Quản lý phòng ban </p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ $isActiveDepartment ? 'show' : '' }}" id="department">
                        <ul class="nav nav-collapse">
                            <li class="{{ request()->routeIs([
                                        'general_catalog.showIndexDepartment',
                                        ]) ? 'active' : '' }}"
                            >
                                <a href="{{ route('general_catalog.showIndexDepartment') }}">
                                    <span class="sub-item">Danh sách phòng ban</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item {{ $isActivePosition ? 'active' : '' }}">
                    <a
                        data-bs-toggle="collapse"
                        href="#position"
                        class="collapsed"
                        aria-expanded="false"
                    >
                        <i class="fas fa-list-alt"></i>
                        <p>Quản lý chức vụ</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ $isActivePosition ? 'show' : '' }}" id="position">
                        <ul class="nav nav-collapse">
                            <li class="{{ request()->routeIs([
                                        'general_catalog.showIndexPosition',
                                        ]) ? 'active' : '' }}"
                            >
                                <a href="{{ route('general_catalog.showIndexPosition') }}">
                                    <span class="sub-item">Danh sách chức vụ</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item {{ $isActiveAttendance ? 'active' : '' }}">
                    <a
                        data-bs-toggle="collapse"
                        href="#attendance"
                        class="collapsed"
                        aria-expanded="false"
                    >
                        <i class="fas fa-clock"></i>
                        <p>Quản lý chấm công</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ $isActiveAttendance ? 'show' : '' }}" id="attendance">
                        <ul class="nav nav-collapse">
                            <li class="{{ request()->routeIs([
                                        'attendance.showSummary',
                                        ]) ? 'active' : '' }}">
                                @php
                                    $month = date('Y-m');
                                 @endphp
                                <a href="{{ route('attendance.showSummary', ['month' => $month]) }}">
                                    <span class="sub-item">Tổng hợp bảng công</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs([
                                        'attendance.showOvertime',
                                        ]) ? 'active' : '' }}">
                                <a href="{{ route('attendance.showOvertime', ['month' => $month]) }}">
                                    <span class="sub-item">Làm thêm giờ</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs([
                                        'attendance.showDetailAttendance',
                                        ]) ? 'active' : '' }}">
                                <a href="{{ route('attendance.showDetailAttendance') }}">
                                    <span class="sub-item">Bảng công chi tiết</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item {{ $isActiveAllowanceDeduction ? 'active' : '' }}">
                    <a
                        data-bs-toggle="collapse"
                        href="#deduction_allowance"
                        class="collapsed"
                        aria-expanded="false"
                    >
                        <i class="fas fa-wallet"></i>
                        <p>Trích nộp và phụ cấp</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ $isActiveAllowanceDeduction ? 'show' : '' }}" id="deduction_allowance">
                        <ul class="nav nav-collapse">
                            <li class="{{ request()->routeIs([
                                        'allowance_deduction.showIndexDeduction',
                                        ]) ? 'active' : '' }}">
                                <a href="{{ route('allowance_deduction.showIndexDeduction') }}">
                                    <span class="sub-item">Bảng tổng hợp trích nộp</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs([
                                        'allowance_deduction.showIndexAllowance',
                                        ]) ? 'active' : '' }}">
                                <a href="{{ route('allowance_deduction.showIndexAllowance') }}">
                                    <span class="sub-item">Bảng tổng hợp phụ cấp</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item {{ $isActiveAccounting ? 'active' : '' }}">
                    <a
                        data-bs-toggle="collapse"
                        href="#accounting"
                        class="collapsed"
                        aria-expanded="false"
                    >
                        <i class="fas fa-calculator"></i>
                        <p>Tính lương và thanh toán</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ $isActiveAccounting ? 'show' : '' }}" id="accounting">
                        <ul class="nav nav-collapse">
                            <li class="{{ request()->routeIs([
                                        'accounting.showIndex',
                                        ]) ? 'active' : '' }}">
                                <a href="{{ route('accounting.showIndex') }}">
                                    <span class="sub-item">Bảng lương</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs([
                                        'accounting.showEmployeeBonus',
                                        ]) ? 'active' : '' }}">
                                <a href="{{ route('accounting.showEmployeeBonus') }}">
                                    <span class="sub-item">Thưởng nhân viên</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs([
                                        'accounting.showPayment',
                                        ]) ? 'active' : '' }}">
                                <a href="{{ route('accounting.showPayment') }}">
                                    <span class="sub-item">Bảng thanh toán lương</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
