
<?php $__env->startSection('title', config('app.name') . ' || Salary Slip'); ?>
<?php $__env->startSection('content'); ?>
    <style>
        @media print {
            .card {
                height: 90%;
            }
        }

        @media print {

            body {
                margin: 0;
                padding: 0;
            }

            .card {
                page-break-after: always;
                break-after: page;
                border: none !important;
                box-shadow: none !important;
            }

            .card:last-child {
                page-break-after: auto;
            }

            .container,
            .content {
                width: 100% !important;
            }

            .btn {
                display: none !important;
            }
        }

        @media print {
            .no-print {
                display: none !important;
            }
            .mobile-user-menu{                
                display: none !important;
            }
            .header{            
                display: none !important;
            }
            .footer{            
                display: none !important;
            }
        }
    </style>
    <div class="content">
        <div class="card mb-3 no-print">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Salary Slip</h4>
                <h4 class="mb-0">
                    <?php echo e(request()->month); ?> / <?php echo e(request()->year); ?>

                </h4>
                <button onclick="window.print()" class="btn btn-primary">
                    <i class="fa fa-print"></i> Print
                </button>
            </div>
        </div>
        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empId => $details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $emp = \App\Models\User::with(['profile', 'department', 'designation'])->find($empId);

                $attendance = $details->where('category', 'attendance')->pluck('value', 'type');
                $earnings = $details->where('category', 'earning');
                $deductions = $details->where('category', 'deduction');
                $net = $details->where('category', 'net');
                $netSalary = $net->first()->value;
            ?>
            <div class="card mb-4 shadow-sm print-page">
                <div class="card-body">
                    <div class="row justify-content-between align-items-center border-bottom mb-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="mb-2">
                                    <img src="<?php echo e(asset('admin/img/logo.png')); ?>" class="img-fluid" alt="logo">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class=" text-end mb-3">
                                <h5 class="text-gray mb-1">Salary Month :
                                    <span class="text-primary"><?php echo e(request()->month); ?> <?php echo e(request()->year); ?></span>
                                </h5>
                            </div>
                        </div>
                    </div>
                    <div class="row border-bottom mb-3">
                        <div class="col-md-8 mb-3">
                            <h4>Employee Information</h4>
                        </div>
                        <div class="col-md-4 mb-3">
                            <h4>Attendance Details</h4>
                        </div>
                        <div class="col-md-4 mb-3">
                            <p class="mb-1 d-flex">
                                <span style="width: 100px;">Name</span>
                                <span>:</span>
                                <span class="ms-2 text-dark"><?php echo e($emp->name ?? '-'); ?></span>
                            </p>
                            <p class="mb-1 d-flex">
                                <span style="width: 100px;">ID</span>
                                <span>:</span>
                                <span class="ms-2 text-dark"><?php echo e($emp->employee_code ?? '-'); ?></span>
                            </p>
                            <p class="mb-1 d-flex">
                                <span style="width: 100px;">Department</span>
                                <span>:</span>
                                <span class="ms-2 text-dark">
                                    <?php echo e(optional($emp->department)->name ?? '-'); ?>

                                </span>
                            </p>
                            <p class="mb-1 d-flex">
                                <span style="width: 100px;">Designation</span>
                                <span>:</span>
                                <span class="ms-2 text-dark">
                                    <?php echo e(optional($emp->designation)->name ?? '-'); ?>

                                </span>
                            </p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <p class="mb-1 d-flex">
                                <span style="width: 100px;">UAN Number</span>
                                <span>:</span>
                                <span class="ms-2 text-dark">
                                    <?php echo e(optional($emp->profile)->uan_number ?? '-'); ?>

                                </span>
                            </p>
                            <p class="mb-1 d-flex">
                                <span style="width: 100px;">PF Number</span>
                                <span>:</span>
                                <span class="ms-2 text-dark">
                                    <?php echo e(optional($emp->profile)->pf_account_number ?? '-'); ?>

                                </span>
                            </p>
                            <p class="mb-1 d-flex">
                                <span style="width: 100px;">IFSC Code</span>
                                <span>:</span>
                                <span class="ms-2 text-dark">
                                    <?php echo e(optional($emp->profile)->ifsc_code ?? '-'); ?>

                                </span>
                            </p>
                            <p class="mb-1 d-flex">
                                <span style="width: 100px;">ESIC Number</span>
                                <span>:</span>
                                <span class="ms-2 text-dark">
                                    <?php echo e(optional($emp->profile)->esic_number ?? '-'); ?>

                                </span>
                            </p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <p class="mb-1 d-flex">
                                <span style="width: 100px;">Working Days</span>
                                <span>:</span>
                                <span class="ms-2 text-dark"><?php echo e($attendance['month_days'] ?? 0); ?></span>
                            </p>
                            <p class="mb-1 d-flex">
                                <span style="width: 100px;">Present Days</span>
                                <span>:</span>
                                <span class="ms-2 text-dark"><?php echo e($attendance['present'] ?? 0); ?></span>
                            </p>
                            <p class="mb-1 d-flex">
                                <span style="width: 100px;">Week Off</span>
                                <span>:</span>
                                <span class="ms-2 text-dark"><?php echo e($attendance['weekends'] ?? 0); ?></span>
                            </p>
                            <p class="mb-1 d-flex">
                                <span style="width: 100px;">Holidays</span>
                                <span>:</span>
                                <span class="ms-2 text-dark"><?php echo e($attendance['holidays'] ?? 0); ?></span>
                            </p>
                            <p class="mb-1 d-flex">
                                <span style="width: 100px;">Leave</span>
                                <span>:</span>
                                <span class="ms-2 text-dark"><?php echo e($attendance['leaves'] ?? 0); ?></span>
                            </p>
                            <p class="mb-1 d-flex">
                                <span style="width: 100px;">Absents</span>
                                <span>:</span>
                                <span class="ms-2 text-dark"><?php echo e($attendance['absents'] ?? 0); ?></span>
                            </p>
                            <p class="mb-1 d-flex">
                                <span style="width: 100px;">Payable Days</span>
                                <span>:</span>
                                <span class="ms-2 text-dark"><?php echo e($attendance['paybled_days'] ?? 0); ?></span>
                            </p>
                        </div>
                    </div>

                    <div>
                        <h5 class="text-center mb-4">Salary Slip for Month of <?php echo e(request()->month); ?> -
                            <?php echo e(request()->year); ?></h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="list-group mb-3">
                                    <div class="list-group-item bg-light p-3 border-bottom-0">
                                        <h6>Earnings</h6>
                                    </div>
                                    <?php $__currentLoopData = $earnings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="list-group-item">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <p class="mb-0"><?php echo e($item->type); ?></p>
                                                <h6 class="fw-medium"><?php echo e(number_format($item->value, 2)); ?></h6>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="list-group mb-3">
                                    <div class="list-group-item bg-light p-3 border-bottom-0">
                                        <h6>Deductions</h6>
                                    </div>
                                    <?php $__currentLoopData = $deductions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="list-group-item">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <p class="mb-0"><?php echo e($item->type); ?></p>
                                                <h6 class="fw-medium"><?php echo e(number_format($item->value, 2)); ?></h6>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="list-group mb-3">
                                <div class="list-group-item bg-light">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h6 class="mb-0">Net Salary</h6>
                                        <h6 class="fw-medium">
                                            ₹ <?php echo e(number_format($netSalary, 2)); ?>

                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Varahi\resources\views/admin/salary/generate_slip.blade.php ENDPATH**/ ?>