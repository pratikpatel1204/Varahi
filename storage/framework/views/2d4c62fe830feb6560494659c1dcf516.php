<?php $__env->startSection('title', config('app.name') . ' || Attendance Requests'); ?>
<?php $__env->startSection('content'); ?>
    <div class="content">
        <div class="card mb-4">
            <div class="card-header">
                <h5>Pending Attendance Requests</h5>
                <form method="GET" class="row g-2 mt-2">
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
                        <a href="<?php echo e(route('employee.attendance.request')); ?>" class="btn btn-light w-100">Clear</a>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="requestTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Employee</th>
                            <th>Punch In</th>
                            <th>Punch Out</th>
                            <th>Total Hours</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $pendingAttendance; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $att): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr id="row_<?php echo e($att->id); ?>">
                                <td><?php echo e($k + 1); ?></td>
                                <td><?php echo e($att->user->name ?? '-'); ?></td>
                                <td><?php echo e($att->punch_in ?? '-'); ?></td>
                                <td><?php echo e($att->punch_out ?? '-'); ?></td>
                                <td><?php echo e($att->total_hours ?? '00:00:00'); ?></td>
                                <td><?php echo e($att->reason ?? '-'); ?></td>
                                <td>
                                    <span class="badge bg-warning">
                                        <?php echo e($att->status); ?>

                                    </span>
                                </td>
                                <td>
                                    <?php if($att->status == 'Pending'): ?>
                                        <button class="btn btn-success btn-sm approveBtn" data-id="<?php echo e($att->id); ?>">
                                            Approve
                                        </button>
                                        <button class="btn btn-danger btn-sm rejectBtn" data-id="<?php echo e($att->id); ?>">
                                            Reject
                                        </button>
                                    <?php else: ?>
                                        <span class="text-muted">No Action</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            $('#requestTable').DataTable();

            $('.approveBtn').click(function() {
                let id = $(this).data('id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to approve this attendance?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Approve!'
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            url: "<?php echo e(route('employee.attendance.request.approve')); ?>", 
                            type: "POST",
                            data: {
                                _token: "<?php echo e(csrf_token()); ?>",
                                id: id
                            },
                            success: function() {
                                toastr.success('Attendance Approved');
                                $('#row_' + id).remove();
                            }
                        });

                    }
                });
            });

            $('.rejectBtn').click(function() {
                let id = $(this).data('id');

                Swal.fire({
                    title: 'Reject Attendance',
                    input: 'textarea',
                    inputLabel: 'Reason for rejection',
                    inputPlaceholder: 'Enter reason...',
                    inputAttributes: {
                        'aria-label': 'Enter reason'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Reject',
                    inputValidator: (value) => {
                        if (!value) {
                            return 'Reason is required!';
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            url: "<?php echo e(route('employee.attendance.request.reject')); ?>",
                            type: "POST",
                            data: {
                                _token: "<?php echo e(csrf_token()); ?>",
                                id: id,
                                reject_comment: result.value 
                            },
                            success: function() {
                                toastr.error('Attendance Rejected');
                                $('#row_' + id).remove();
                            }
                        });

                    }
                });
            });

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Varahi\resources\views/employee/attendance/attendance_requests.blade.php ENDPATH**/ ?>