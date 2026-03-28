
<?php $__env->startSection('title', config('app.name') . ' || Expense Verification'); ?>
<?php $__env->startSection('content'); ?>
    <div class="content">
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    Expense Verification - <?php echo e($month); ?> / <?php echo e($year); ?>

                </h5>
                <a href="<?php echo e(route('admin.salary.Processing', ['year' => $year, 'month' => $month])); ?>"
                    class="btn btn-secondary btn-sm">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
            <div class="card-body">
                <form method="POST" id="ExpenseForm">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="year" value="<?php echo e($year); ?>">
                    <input type="hidden" name="month" value="<?php echo e($month); ?>">
                    <?php if($expenses->count() == 0): ?>
                        <div class="alert alert-info text-center">
                            No expense entries found for this month.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Employee</th>
                                        <th>Type</th>
                                        <th>Description</th>
                                        <th>Original Amount</th>
                                        <th>Approved Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($index + 1); ?></td>
                                            <td>
                                                <?php echo e($expense->employee->name ?? 'EMP-' . $expense->employee_id); ?>

                                            </td>
                                            <td><?php echo e($expense->entry_type); ?></td>
                                            <td><?php echo e($expense->description); ?></td>
                                            <td>
                                                <input type="text" class="form-control" value="<?php echo e($expense->amount); ?>"
                                                    readonly>
                                            </td>
                                            <td>
                                                <input type="number" step="0.01" min="0"
                                                    name="expense[<?php echo e($expense->id); ?>]" value="<?php echo e($expense->amount); ?>"
                                                    class="form-control">
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                    <button type="button" id="submitExpenseBtn"
                        class="btn mt-3 w-auto <?php echo e($expenseVerified ? 'btn-warning' : 'btn-success'); ?>">

                        <span class="btn-text">
                            <?php echo e($expenseVerified ? 'Already Verified (Click to Re-Verify)' : 'Verify Expense'); ?>

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
        document.getElementById('submitExpenseBtn').addEventListener('click', function() {

            let btn = this;
            let loader = btn.querySelector('.btn-loader');
            let text = btn.querySelector('.btn-text');

            // Disable + loader show
            btn.disabled = true;
            loader.classList.remove('d-none');
            text.classList.add('d-none');

            let formData = new FormData(document.getElementById('ExpenseForm'));

            fetch("<?php echo e(route('admin.salary.expense.verify')); ?>", {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': "<?php echo e(csrf_token()); ?>"
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {

                    // Reset button
                    btn.disabled = false;
                    loader.classList.add('d-none');
                    text.classList.remove('d-none');

                    if (data.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: data.message || 'Expense verified successfully!'
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

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Varahi\resources\views/admin/salary/expense_preview.blade.php ENDPATH**/ ?>