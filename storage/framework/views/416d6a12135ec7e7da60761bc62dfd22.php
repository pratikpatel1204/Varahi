<?php $__env->startSection('title', config('app.name') . ' || Loan Requests'); ?>
<?php $__env->startSection('content'); ?> 
    <div class="content">
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Loan Requests</h5>
                <a href="<?php echo e(route('admin.loans.create')); ?>" class="btn btn-primary">
                    <i class="ti ti-plus"></i> Add Loan
                </a>
            </div>
            <div class="card-body">
                <form method="GET">
                    <div class="row g-2">
                        <div class="col-md-3">
                            <label>Month</label>
                            <select name="month" class="form-control">
                                <?php for($m = 1; $m <= 12; $m++): ?>
                                    <option value="<?php echo e($m); ?>" <?php echo e($month == $m ? 'selected' : ''); ?>>
                                        <?php echo e(date('F', mktime(0, 0, 0, $m, 1))); ?>

                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Year</label>
                            <select name="year" class="form-control">
                                <?php for($y = now()->year; $y >= now()->year - 5; $y--): ?>
                                    <option value="<?php echo e($y); ?>" <?php echo e($year == $y ? 'selected' : ''); ?>>
                                        <?php echo e($y); ?>

                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="">All</option>
                                <option value="Pending" <?php echo e(request('status') == 'Pending' ? 'selected' : ''); ?>>Pending
                                </option>
                                <option value="Approved" <?php echo e(request('status') == 'Approved' ? 'selected' : ''); ?>>Approved
                                </option>
                                <option value="Rejected" <?php echo e(request('status') == 'Rejected' ? 'selected' : ''); ?>>Rejected
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button class="btn btn-primary w-100">Filter</button>
                            <a href="<?php echo e(route('admin.loan.request')); ?>" class="btn btn-light w-100">Clear</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php if($pendingLoans->count()): ?>
            <div class="card mb-3">
                <div class="card-header bg-primary">
                    <strong>Pending Loan Requests</strong>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered" id="loadPendingtable">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>ID</th>
                                <th>Employee</th>
                                <th>Manager</th>
                                <th>Amount</th>
                                <th>Interest</th>
                                <th>Total</th>
                                <th>EMI</th>
                                <th>No EMI</th>
                                <th>Start</th>
                                <th>End</th>
                                <th>Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $pendingLoans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <button class="btn btn-success btn-sm approveBtn" data-id="<?php echo e($loan->id); ?>">
                                            Approve
                                        </button>

                                        <button class="btn btn-danger btn-sm rejectBtn" data-id="<?php echo e($loan->id); ?>">
                                            Reject
                                        </button>
                                    </td>
                                    <td><?php echo e($loan->id); ?></td>
                                    <td><?php echo e($loan->employee->name ?? '-'); ?></td>
                                    <td><?php echo e($loan->reportingManager->name ?? '-'); ?></td>
                                    <td>₹<?php echo e(number_format($loan->loan_amount, 2)); ?></td>
                                    <td><?php echo e($loan->interest_rate); ?>%</td>
                                    <td>₹<?php echo e(number_format($loan->loan_amount_with_interest, 2)); ?></td>
                                    <td>₹<?php echo e(number_format($loan->emi_amount, 2)); ?></td>
                                    <td><?php echo e($loan->no_of_emi); ?></td>
                                    <td><?php echo e($loan->emi_start_date); ?></td>
                                    <td><?php echo e($loan->emi_end_date); ?></td>
                                    <td><?php echo e(\Carbon\Carbon::parse($loan->created_at)->format('d-m-Y')); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
        <div class="card">
            <div class="card-header">
                <strong>All Loan Requests</strong>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered" id="allloadtable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Employee</th>
                            <th>Manager</th>
                            <th>Amount</th>
                            <th>Interest</th>
                            <th>Total</th>
                            <th>EMI</th>
                            <th>No EMI</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Status</th>
                            <th>Approved By</th>
                            <th>Remarks</th>
                            <th>Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $allLoans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($loan->id); ?></td>
                                <td><?php echo e($loan->employee->name ?? '-'); ?></td>
                                <td><?php echo e($loan->reportingManager->name ?? '-'); ?></td>
                                <td>₹<?php echo e(number_format($loan->loan_amount, 2)); ?></td>
                                <td><?php echo e($loan->interest_rate); ?>%</td>
                                <td>₹<?php echo e(number_format($loan->loan_amount_with_interest, 2)); ?></td>
                                <td>₹<?php echo e(number_format($loan->emi_amount, 2)); ?></td>
                                <td><?php echo e($loan->no_of_emi); ?></td>
                                <td><?php echo e($loan->emi_start_date); ?></td>
                                <td><?php echo e($loan->emi_end_date); ?></td>
                                <td>
                                    <?php if(strtolower($loan->status) == 'pending'): ?>
                                        <span class="badge bg-warning">Pending</span>
                                    <?php elseif(strtolower($loan->status) == 'approved'): ?>
                                        <span class="badge bg-success">Approved</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Rejected</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($loan->approvedBy->name ?? '-'); ?></td>
                                <td><?php echo e($loan->remarks ?? '-'); ?></td>
                                <td><?php echo e(\Carbon\Carbon::parse($loan->created_at)->format('d-m-Y')); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            function initDataTable(id) {
                if ($(id).length && $(id + ' tbody tr').length > 0) {
                    $(id).DataTable({
                        pageLength: 10,
                        ordering: true,
                        responsive: true
                    });
                }
            }
            initDataTable('#loadPendingtable');
            initDataTable('#allloadtable');

            $(document).on('click', '.approveBtn', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Approve Loan?',
                    icon: 'question',
                    showCancelButton: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        updateStatus(id, 'approved');
                    }
                });
            });

            $(document).on('click', '.rejectBtn', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Reject Loan',
                    input: 'text',
                    inputPlaceholder: 'Enter reason',
                    showCancelButton: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        updateStatus(id, 'rejected', result.value);
                    }
                });
            });

            function updateStatus(id, status, reason = '') {
                $.ajax({
                    url: "<?php echo e(route('admin.loans.update.status')); ?>",
                    type: 'POST',
                    data: {
                        _token: "<?php echo e(csrf_token()); ?>",
                        status: status,
                        remarks: reason,
                        id:id,
                    },
                    success: function(res) {
                        if (res.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Status updated successfully'
                            }).then(() => {
                                location.reload();
                            });
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Something went wrong', 'error');
                    }
                });
            }
        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Varahi\resources\views/admin/loans/requests.blade.php ENDPATH**/ ?>