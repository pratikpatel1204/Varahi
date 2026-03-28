
<?php $__env->startSection('title', config('app.name') . ' || My Leaves'); ?>
<?php $__env->startSection('content'); ?>
    <div class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0">Leaves List</h3>
                <br>
                <form method="GET" class="row g-2">
                    <div class="col-md-3">
                        <select name="month" class="form-control">
                            <option value="">Month</option>
                            <?php for($i = 1; $i <= 12; $i++): ?>
                                <option value="<?php echo e($i); ?>" <?php echo e($month == $i ? 'selected' : ''); ?>>
                                    <?php echo e(date('F', mktime(0, 0, 0, $i, 1))); ?>

                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="year" class="form-control">
                            <option value="">Year</option>
                            <?php for($y = date('Y'); $y >= 2020; $y--): ?>
                                <option value="<?php echo e($y); ?>" <?php echo e($year == $y ? 'selected' : ''); ?>>
                                    <?php echo e($y); ?>

                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-control">
                            <option value="">Status</option>
                            <option value="Pending" <?php echo e(request('status') == 'Pending' ? 'selected' : ''); ?>>Pending</option>
                            <option value="Approved" <?php echo e(request('status') == 'Approved' ? 'selected' : ''); ?>>Approved
                            </option>
                            <option value="Rejected" <?php echo e(request('status') == 'Rejected' ? 'selected' : ''); ?>>Rejected
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button class="btn btn-primary w-100">Filter</button>
                        <a href="<?php echo e(route('employee.my.leaves')); ?>" class="btn btn-light w-100">
                            Clear
                        </a>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="leavetable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Leave Type</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Days</th>
                            <th>Status</th>
                            <th>Reason</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $leaves; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $leave): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($k + 1); ?></td>
                                <td><?php echo e($leave->leaveType->name ?? '-'); ?></td>
                                <td><?php echo e(\Carbon\Carbon::parse($leave->from_date)->format('d M Y')); ?></td>
                                <td><?php echo e(\Carbon\Carbon::parse($leave->to_date)->format('d M Y')); ?></td>
                                <td><?php echo e($leave->days); ?></td>
                                <td>
                                    <?php if($leave->status == 'Approved'): ?>
                                        <span class="badge bg-success">Approved</span>
                                    <?php elseif($leave->status == 'Rejected'): ?>
                                        <span class="badge bg-danger">Rejected</span><br>
                                        <span class="text-dark"><?php echo e($leave->comment ?? ''); ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($leave->reason); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="text-center">No leaves found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Varahi\resources\views/employee/leaves/index.blade.php ENDPATH**/ ?>