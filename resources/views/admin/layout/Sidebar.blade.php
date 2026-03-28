<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <!-- Logo -->
    <div class="sidebar-logo">
        <a href="{{ route('admin.dashboard') }}" class="logo logo-normal text-center">
            <img src="{{ asset('admin/img/logo.png') }}" alt="Logo" style="height:50px; width:auto;">
        </a>
        <a href="{{ route('admin.dashboard') }}" class="logo-small">
            <img src="{{ asset('admin/img/logo-small.png') }}" alt="Logo">
        </a>
        <a href="{{ route('admin.dashboard') }}" class="dark-logo">
            <img src="{{ asset('admin/img/logo-white.png') }}" alt="Logo">
        </a>
    </div>
    <!-- /Logo -->
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                @can('View dashboard')
                    <li>
                        <ul class="m-0">
                            <li>
                                <a href="{{ route('admin.dashboard') }}" class="px-2">
                                    <i class="ti ti-smart-home"></i><span> Dashboard</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('Employee dashboard')
                    <li>
                        <ul class="m-0">
                            <li>
                                <a href="{{ route('admin.dashboard') }}" class="px-2">
                                    <i class="ti ti-smart-home"></i><span> Dashboard</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @canany(['View Roles', 'View Permissions'])
                    <li>
                        <ul class="m-0">
                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <i class="ti ti-shield"></i><span>Roles & Permissions</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    @can('View Roles')
                                        <li><a href="{{ route('admin.roles.list') }}">Role List</a></li>
                                    @endcan
                                    @can('View Permissions')
                                        <li><a href="{{ route('admin.permissions.list') }}">Permission List</a></li>
                                    @endcan
                                </ul>
                            </li>
                        </ul>
                    </li>
                @endcanany

                {{-- ================= COMPANY MASTER ================= --}}
                @canany(['View Working Days', 'View Leaves', 'View Years', 'View Salary Types', 'View PF', 'View ESIC',
                    'View Monthly Working'])
                    <li>
                        <ul class="m-0">
                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <i class="ti ti-building-bank"></i>
                                    <span>Company Master</span>
                                    <span class="menu-arrow"></span>
                                </a>

                                <ul>

                                    @can('View Working Days')
                                        <li>
                                            <a href="{{ route('admin.designation-working-days.index') }}">
                                                <i class="ti ti-calendar-time"></i>
                                                <span>Assign Working Days</span>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('View Leaves')
                                        <li>
                                            <a href="{{ route('admin.designation.leaves.index') }}">
                                                <i class="ti ti-calendar-off"></i>
                                                <span>Assign Leaves</span>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('View Years')
                                        <li>
                                            <a href="{{ route('admin.years.index') }}">
                                                <i class="ti ti-calendar-time"></i>
                                                <span>Year Master</span>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('View Salary Types')
                                        <li>
                                            <a href="{{ route('admin.salary-types.index') }}">
                                                <i class="ti ti-currency-dollar"></i>
                                                <span>Salary Types</span>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('View PF')
                                        <li>
                                            <a href="{{ route('admin.pf.index') }}">
                                                <i class="ti ti-building-bank"></i>
                                                <span>PF Settings</span>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('View ESIC')
                                        <li>
                                            <a href="{{ route('admin.esic.index') }}">
                                                <i class="ti ti-building-bank"></i>
                                                <span>Employer ESIC Settings</span>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('View Monthly Working')
                                        <li>
                                            <a href="{{ route('admin.monthly_working.create') }}">
                                                <i class="ti ti-calendar"></i>
                                                <span>Monthly Working Days</span>
                                            </a>
                                        </li>
                                    @endcan

                                </ul>
                            </li>
                        </ul>
                    </li>
                @endcanany

                {{-- ================= EMPLOYEE MASTER ================= --}}
                @canany([
                    'View Departments',
                    'View Sub Departments',
                    'View Designations',
                    'View Blood Groups',
                    'View
                    Holidays',
                    'View Leave Types',
                    'View Qualification',
                    'Working Days Master',
                    'View Courses',
                    ])
                    <li>
                        <ul class="m-0">
                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <i class="ti ti-users"></i>
                                    <span>Employee Master</span>
                                    <span class="menu-arrow"></span>
                                </a>

                                <ul>
                                    @can('View Departments')
                                        <li>
                                            <a href="{{ route('admin.departments.index') }}">
                                                <i class="ti ti-building"></i>
                                                <span>Department Master</span>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('View Sub Departments')
                                        <li>
                                            <a href="{{ route('admin.sub-departments.index') }}">
                                                <i class="ti ti-building-arch"></i>
                                                <span>Sub Department</span>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('View Designations')
                                        <li><a href="{{ route('admin.designations.index') }}">
                                                <i class="ti ti-id-badge"></i>
                                                <span>Designation</span>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('View Blood Groups')
                                        <li>
                                            <a href="{{ route('admin.blood-groups.index') }}">
                                                <i class="ti ti-droplet"></i>
                                                <span>Blood Group</span>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('View Holidays')
                                        <li>
                                            <a href="{{ route('admin.holidays.index') }}">
                                                <i class="ti ti-calendar-event"></i>
                                                <span>Holiday</span>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('View Leave Types')
                                        <li>
                                            <a href="{{ route('admin.leave-types.index') }}">
                                                <i class="ti ti-calendar"></i>
                                                <span>Leave Types</span>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('View Qualification')
                                        <li>
                                            <a href="{{ route('admin.qualification.areas.index') }}">
                                                <i class="ti ti-school"></i>
                                                <span>Qualification Area</span>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('Working Days Master')
                                        <li>
                                            <a href="{{ route('admin.working.days.index') }}">
                                                <i class="ti ti-calendar-stats"></i>
                                                <span>Working Days</span>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('View Courses')
                                        <li>
                                            <a href="{{ route('admin.courses.index') }}">
                                                <i class="ti ti-book"></i>
                                                <span>Courses</span>
                                            </a>
                                        </li>
                                    @endcan

                                </ul>
                            </li>
                        </ul>
                    </li>
                @endcanany
                @can('View Employees')
                    <li>
                        <ul class="m-0">
                            <li>
                                <a href="{{ route('admin.employees.index') }}">
                                    <i class="ti ti-users"></i>
                                    <span>Employee Management</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @canany(['View Assets', 'Assign Assets', 'View Asset History'])
                    <li>
                        <ul class="m-0">
                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <i class="ti ti-device-laptop"></i>
                                    <span>Assets Management</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    @can('View Assets')
                                        <li><a href="{{ route('admin.assets.index') }}">
                                                <i class="ti ti-box"></i>
                                                <span>Assets Master</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('Assign Assets')
                                        <li>
                                            <a href="{{ route('admin.assign.assets.index') }}">
                                                <i class="ti ti-share"></i>
                                                <span>Assign Assets</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('View Asset History')
                                        <li>
                                            <a href="{{ route('admin.assets.history') }}">
                                                <i class="ti ti-history"></i>
                                                <span>Asset History</span>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        </ul>
                    </li>
                @endcanany

                @can('Employee Profile')
                    <li>
                        <ul class="m-0">
                            <li>
                                <a href="{{ route('employee.profile') }}" class="px-2">
                                    <i class="ti ti-user"></i>
                                    <span>Profile</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('Employee My Leaves')
                    <li>
                        <ul class="m-0">
                            <li>
                                <a href="{{ route('employee.my.leaves') }}" class="px-2">
                                    <i class="ti ti-calendar"></i>
                                    <span>My Leaves</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('Employee Leaves Request')
                    <li>
                        <ul class="m-0">
                            <li>
                                <a href="{{ route('employee.leave.requests') }}" class="px-2">
                                    <i class="ti ti-file-text"></i>
                                    <span>Leaves Request</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('Attendance Management')
                    <li>
                        <ul class="m-0">
                            <li>
                                <a href="{{ route('employee.leave.requests') }}" class="px-2">
                                    <i class="ti ti-file-text"></i>
                                    <span>Attendance Management</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('My Attendance')
                    <li>
                        <ul class="m-0">
                            <li>
                                <a href="{{ route('employee.my.attendance') }}" class="px-2">
                                    <i class="ti ti-calendar"></i>
                                    <span>My Attendance</span>
                                </a>
                            </li>

                        </ul>
                    </li>
                @endcan
                @can('Attendance Request')
                    <li>
                        <ul class="m-0">
                            <li>
                                <a href="{{ route('employee.attendance.request') }}" class="px-2">
                                    <i class="ti ti-file-text"></i>
                                    <span>Attendance Request</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('Loan Management')
                    <li>
                        <ul class="m-0">
                            <li>
                                <a href="{{ route('admin.loan.request') }}" class="px-2">
                                    <i class="ti ti-send"></i>
                                    <span>Loan Management</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('Expense Reimbursement')
                    <li>
                        <ul class="m-0">
                            <li>
                                <a href="{{ route('admin.expense.reimbursement.list') }}" class="px-2">
                                    <i class="ti ti-receipt"></i>
                                    <span>Expense/Reimbursement</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('Process Salary')
                    <li>
                        <ul class="m-0">
                            <li>
                                <a href="{{ route('admin.salary.Processing') }}" class="px-2">
                                    <i class="ti ti-cash"></i>
                                    <span>Process Salary</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('Category Master')
                    <li>
                        <ul class="m-0">
                            <li>
                                <a href="{{ route('admin.category.list') }}" class="px-2">
                                    <i class="ti ti-list"></i>
                                    <span>Category Master</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('Product Master')
                    <li>
                        <ul class="m-0">
                            <li>
                                <a href="{{ route('employee.product.list') }}" class="px-2">
                                    <i class="ti ti-package"></i>
                                    <span>Product Master</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('Product Inquiry')
                    <li>
                        <ul class="m-0">
                            <li>
                                <a href="{{ route('employee.inquiry.list') }}" class="px-2">
                                    <i class="ti ti-search"></i>
                                    <span>Product Inquiry</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->
