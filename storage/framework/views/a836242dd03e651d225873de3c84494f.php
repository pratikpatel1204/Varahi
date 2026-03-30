<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <!-- Logo -->
    <div class="sidebar-logo">
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="logo logo-normal text-center">
            <img src="<?php echo e(asset('admin/img/logo.png')); ?>" alt="Logo" style="height:50px; width:auto;">
        </a>
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="logo-small">
            <img src="<?php echo e(asset('admin/img/logo-small.png')); ?>" alt="Logo">
        </a>
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="dark-logo">
            <img src="<?php echo e(asset('admin/img/logo-white.png')); ?>" alt="Logo">
        </a>
    </div>
    <!-- /Logo -->
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View dashboard')): ?>
                    <li>
                        <ul class="m-0">
                            <li>
                                <a href="<?php echo e(route('admin.dashboard')); ?>" class="px-2">
                                    <i class="ti ti-smart-home"></i><span> Dashboard</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Employee dashboard')): ?>
                    <li>
                        <ul class="m-0">
                            <li>
                                <a href="<?php echo e(route('admin.dashboard')); ?>" class="px-2">
                                    <i class="ti ti-smart-home"></i><span> Dashboard</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['View Roles', 'View Permissions'])): ?>
                    <li>
                        <ul class="m-0">
                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <i class="ti ti-shield"></i><span>Roles & Permissions</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Roles')): ?>
                                        <li><a href="<?php echo e(route('admin.roles.list')); ?>">Role List</a></li>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Permissions')): ?>
                                        <li><a href="<?php echo e(route('admin.permissions.list')); ?>">Permission List</a></li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['View Working Days', 'View Leaves', 'View Years', 'View Salary Types', 'View PF', 'View ESIC',
                    'View Monthly Working'])): ?>
                    <li>
                        <ul class="m-0">
                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <i class="ti ti-building-bank"></i>
                                    <span>Company Master</span>
                                    <span class="menu-arrow"></span>
                                </a>

                                <ul>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Working Days')): ?>
                                        <li>
                                            <a href="<?php echo e(route('admin.designation-working-days.index')); ?>">
                                                <i class="ti ti-calendar-time"></i>
                                                <span>Assign Working Days</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Leaves')): ?>
                                        <li>
                                            <a href="<?php echo e(route('admin.designation.leaves.index')); ?>">
                                                <i class="ti ti-calendar-off"></i>
                                                <span>Assign Leaves</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Years')): ?>
                                        <li>
                                            <a href="<?php echo e(route('admin.years.index')); ?>">
                                                <i class="ti ti-calendar-time"></i>
                                                <span>Year Master</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Salary Types')): ?>
                                        <li>
                                            <a href="<?php echo e(route('admin.salary-types.index')); ?>">
                                                <i class="ti ti-currency-dollar"></i>
                                                <span>Salary Types</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View PF')): ?>
                                        <li>
                                            <a href="<?php echo e(route('admin.pf.index')); ?>">
                                                <i class="ti ti-building-bank"></i>
                                                <span>PF Settings</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View ESIC')): ?>
                                        <li>
                                            <a href="<?php echo e(route('admin.esic.index')); ?>">
                                                <i class="ti ti-building-bank"></i>
                                                <span>Employer ESIC Settings</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Monthly Working')): ?>
                                        <li>
                                            <a href="<?php echo e(route('admin.monthly_working.create')); ?>">
                                                <i class="ti ti-calendar"></i>
                                                <span>Monthly Working Days</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                </ul>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any([
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
                    ])): ?>
                    <li>
                        <ul class="m-0">
                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <i class="ti ti-users"></i>
                                    <span>Employee Master</span>
                                    <span class="menu-arrow"></span>
                                </a>

                                <ul>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Departments')): ?>
                                        <li>
                                            <a href="<?php echo e(route('admin.departments.index')); ?>">
                                                <i class="ti ti-building"></i>
                                                <span>Department Master</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Sub Departments')): ?>
                                        <li>
                                            <a href="<?php echo e(route('admin.sub-departments.index')); ?>">
                                                <i class="ti ti-building-arch"></i>
                                                <span>Sub Department</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Designations')): ?>
                                        <li><a href="<?php echo e(route('admin.designations.index')); ?>">
                                                <i class="ti ti-id-badge"></i>
                                                <span>Designation</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Blood Groups')): ?>
                                        <li>
                                            <a href="<?php echo e(route('admin.blood-groups.index')); ?>">
                                                <i class="ti ti-droplet"></i>
                                                <span>Blood Group</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Holidays')): ?>
                                        <li>
                                            <a href="<?php echo e(route('admin.holidays.index')); ?>">
                                                <i class="ti ti-calendar-event"></i>
                                                <span>Holiday</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Leave Types')): ?>
                                        <li>
                                            <a href="<?php echo e(route('admin.leave-types.index')); ?>">
                                                <i class="ti ti-calendar"></i>
                                                <span>Leave Types</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Qualification')): ?>
                                        <li>
                                            <a href="<?php echo e(route('admin.qualification.areas.index')); ?>">
                                                <i class="ti ti-school"></i>
                                                <span>Qualification Area</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Working Days Master')): ?>
                                        <li>
                                            <a href="<?php echo e(route('admin.working.days.index')); ?>">
                                                <i class="ti ti-calendar-stats"></i>
                                                <span>Working Days</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Courses')): ?>
                                        <li>
                                            <a href="<?php echo e(route('admin.courses.index')); ?>">
                                                <i class="ti ti-book"></i>
                                                <span>Courses</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                </ul>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Employees')): ?>
                    <li>
                        <ul class="m-0">
                            <li>
                                <a href="<?php echo e(route('admin.employees.index')); ?>">
                                    <i class="ti ti-users"></i>
                                    <span>Employee Management</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>



                            <li>
                        <ul class="m-0">
                            <li class="submenu">
                                <a href="javascript:void(0);">
        <i class="ti ti-id-badge"></i>
                                    <span>ID Card</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Assets')): ?>
                                        <li><a href="<?php echo e(route('admin.id.cards.index')); ?>">
                <i class="ti ti-credit-card"></i>
                                                <span>Generate ID Card</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Assign Assets')): ?>
                                        <li>
                                            <a href="<?php echo e(route('admin.id.cards.report')); ?>">
                <i class="ti ti-report"></i>
                                                <span>Already Generated ID Cards</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Asset History')): ?>
                                        <li>
                                            <a href="<?php echo e(route('admin.id.card.template.index')); ?>">
                <i class="ti ti-template"></i>
                                                <span>ID Card Template</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        </ul>
                    </li>


                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['View Assets', 'Assign Assets', 'View Asset History'])): ?>

                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Employee Profile')): ?>
                    <li>
                        <ul class="m-0">
                            <li>
                                <a href="<?php echo e(route('employee.profile')); ?>" class="px-2">
                                    <i class="ti ti-user"></i>
                                    <span>Profile</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Employee My Leaves')): ?>
                    <li>
                        <ul class="m-0">
                            <li>
                                <a href="<?php echo e(route('employee.my.leaves')); ?>" class="px-2">
                                    <i class="ti ti-calendar"></i>
                                    <span>My Leaves</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Employee Leaves Request')): ?>
                    <li>
                        <ul class="m-0">
                            <li>
                                <a href="<?php echo e(route('employee.leave.requests')); ?>" class="px-2">
                                    <i class="ti ti-file-text"></i>
                                    <span>Leaves Request</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Attendance Management')): ?>
                    <li>
                        <ul class="m-0">
                            <li>
                                <a href="<?php echo e(route('employee.leave.requests')); ?>" class="px-2">
                                    <i class="ti ti-file-text"></i>
                                    <span>Attendance Management</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('My Attendance')): ?>
                    <li>
                        <ul class="m-0">
                            <li>
                                <a href="<?php echo e(route('employee.my.attendance')); ?>" class="px-2">
                                    <i class="ti ti-calendar"></i>
                                    <span>My Attendance</span>
                                </a>
                            </li>

                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Attendance Request')): ?>
                    <li>
                        <ul class="m-0">
                            <li>
                                <a href="<?php echo e(route('employee.attendance.request')); ?>" class="px-2">
                                    <i class="ti ti-file-text"></i>
                                    <span>Attendance Request</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Loan Management')): ?>
                    <li>
                        <ul class="m-0">
                            <li>
                                <a href="<?php echo e(route('admin.loan.request')); ?>" class="px-2">
                                    <i class="ti ti-send"></i>
                                    <span>Loan Management</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Expense Reimbursement')): ?>
                    <li>
                        <ul class="m-0">
                            <li>
                                <a href="<?php echo e(route('admin.expense.reimbursement.list')); ?>" class="px-2">
                                    <i class="ti ti-receipt"></i>
                                    <span>Expense/Reimbursement</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Process Salary')): ?>
                    <li>
                        <ul class="m-0">
                            <li>
                                <a href="<?php echo e(route('admin.salary.Processing')); ?>" class="px-2">
                                    <i class="ti ti-cash"></i>
                                    <span>Process Salary</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Category Master')): ?>
                    <li>
                        <ul class="m-0">
                            <li>
                                <a href="<?php echo e(route('admin.category.list')); ?>" class="px-2">
                                    <i class="ti ti-list"></i>
                                    <span>Category Master</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Product Master')): ?>
                    <li>
                        <ul class="m-0">
                            <li>
                                <a href="<?php echo e(route('employee.product.list')); ?>" class="px-2">
                                    <i class="ti ti-package"></i>
                                    <span>Product Master</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Product Inquiry')): ?>
                    <li>
                        <ul class="m-0">
                            <li>
                                <a href="<?php echo e(route('employee.inquiry.list')); ?>" class="px-2">
                                    <i class="ti ti-search"></i>
                                    <span>Product Inquiry</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Site setting')): ?>
                    <li>
                        <ul class="m-0">
                            <li>
                                <a href="<?php echo e(route('admin.site-settings.index')); ?>" class="px-2">
                                       <i class=" ti ti-building"></i>
                                   <span>Site Setting</span>

                                </a>
                            </li>
                        </ul>
                    </li>

    <?php endif; ?>

            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->
<?php /**PATH C:\Varahi\resources\views/admin/layout/Sidebar.blade.php ENDPATH**/ ?>