
<?php $__env->startSection('title', config('app.name') . ' || Loan Deduction'); ?>
<?php $__env->startSection('content'); ?>
    <div class="content">
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    Loan Deduction - <?php echo e($monthName); ?> / <?php echo e($yearName); ?>

                </h5>
                <a href="<?php echo e(route('admin.salary.Processing', ['year' => $year, 'month' => $month])); ?>" class="btn btn-secondary btn-sm">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
            <div class="card-body">
                <form id="loanForm">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="year" value="<?php echo e($year); ?>">
                    <input type="hidden" name="month" value="<?php echo e($month); ?>">
                    <?php if($loans->count() == 0): ?>
                        <div class="alert alert-info">
                            No active loans found for this month.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Employee</th>
                                        <th>Loan Amount</th>
                                        <th>Interest (%)</th>
                                        <th>Total EMI</th>
                                        <th>EMI Amount</th>
                                        <th>Deduction</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php $__currentLoopData = $loans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <?php echo e($loan->employee->name ?? 'N/A'); ?>

                                            </td>

                                            <td><?php echo e($loan->loan_amount); ?></td>

                                            <td><?php echo e($loan->interest_rate); ?>%</td>

                                            <td><?php echo e($loan->no_of_emi); ?></td>

                                            <td><?php echo e(round($loan->emi_amount, 2)); ?></td>

                                            <td>
                                                <input type="number" name="loan[<?php echo e($loan->employee_id); ?>][amount]"
                                                    value="<?php echo e(round($loan->emi_amount, 2)); ?>" class="form-control">

                                                <input type="hidden" name="loan[<?php echo e($loan->employee_id); ?>][loan_id]"
                                                    value="<?php echo e($loan->id); ?>">
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                    <button type="button" id="submitLoanBtn"class="btn mt-3 w-auto <?php echo e($loanVerified ? 'btn-warning' : 'btn-success'); ?>">
                        <span class="btn-text">
                            <?php echo e($loanVerified ? 'Already Verified (Click to Re-Verify)' : 'Verify Loan Deduction'); ?>

                        </span>
                        <span class="btn-loader d-none">
                            <span class="spinner-border spinner-border-sm"></span> Processing...
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('submitLoanBtn').addEventListener('click', function() {

            let btn = this;
            let loader = btn.querySelector('.btn-loader');
            let text = btn.querySelector('.btn-text');

            // Disable + loader
            btn.disabled = true;
            loader.classList.remove('d-none');
            text.classList.add('d-none');

            let formData = new FormData(document.getElementById('loanForm'));

            fetch("<?php echo e(route('admin.salary.loan.verify')); ?>", {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': "<?php echo e(csrf_token()); ?>"
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {

                    btn.disabled = false;
                    loader.classList.add('d-none');
                    text.classList.remove('d-none');

                    if (data.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: data.message || 'Loan verified successfully!'
                        }).then(() => location.reload());
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Something went wrong'
                        });
                    }
                })
                .catch(() => {

                    btn.disabled = false;
                    loader.classList.add('d-none');
                    text.classList.remove('d-none');

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong!'
                    });
                });

        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Varahi\resources\views/admin/salary/loan_preview.blade.php ENDPATH**/ ?>