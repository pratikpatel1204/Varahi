
<?php $__env->startSection('title', config('app.name') . ' || Salary Processing'); ?>
<?php $__env->startSection('content'); ?>
    <div class="content">
        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Salary Processing for <?php echo e($monthName); ?> <?php echo e($yearName); ?></h5>
                <?php if($SalaryVerified): ?>
                    <span class="badge bg-success">Salary Processed</span>
                <?php else: ?>
                    <span class="badge bg-warning">Pending</span>
                <?php endif; ?>
                <a href="<?php echo e(route('admin.salary.Processing', ['year' => $yearName, 'month' => $monthName])); ?>"
                    class="btn btn-secondary btn-sm">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <form method="POST">
                        <?php echo csrf_field(); ?>
                        <table class="table table-bordered table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Emp Code</th>
                                    <th>Emp Name</th>
                                    <th>Designation</th>
                                    <th>Account</th>
                                    <th>IFSC</th>
                                    <th>Month Days</th>
                                    <th>Present</th>
                                    <th>Holiday</th>
                                    <th>Weekend</th>
                                    <th>Leave</th>
                                    <th>Absent</th>
                                    <th>Paybled Days</th>
                                    <?php
                                        $earningTypes = $employees->first()?->earnings->pluck('salary_type_name') ?? [];
                                    ?>
                                    <?php $__currentLoopData = $earningTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <th><?php echo e($type); ?></th>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $deductionTypes =
                                            $employees->first()?->deductions->pluck('salary_type_name') ?? [];
                                    ?>
                                    <?php $__currentLoopData = $deductionTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <th><?php echo e($type); ?></th>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $netsTypes = $employees->first()?->net->pluck('salary_type_name') ?? [];
                                    ?>
                                    <?php $__currentLoopData = $netsTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <th><?php echo e($type); ?></th>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <th>Loan</th>
                                    <th>Expense</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <?php echo e($loop->iteration); ?>

                                            <input type="hidden" name="employee_id[]" value="<?php echo e($emp->id); ?>">
                                            <input type="hidden" name="year" value="<?php echo e($yearName); ?>">
                                            <input type="hidden" name="month" value="<?php echo e($monthName); ?>">
                                        </td>
                                        <td>
                                            <?php echo e($emp->employee_code); ?>

                                            <input type="hidden" name="emp_code[<?php echo e($emp->id); ?>]"
                                                value="<?php echo e($emp->employee_code); ?>">
                                        </td>
                                        <td>
                                            <?php echo e($emp->name); ?>

                                            <input type="hidden" name="emp_name[<?php echo e($emp->id); ?>]"
                                                value="<?php echo e($emp->name); ?>">
                                        </td>
                                        <td>
                                            <?php echo e($emp->designation->name ?? 'N/A'); ?>

                                            <input type="hidden" name="designation[<?php echo e($emp->id); ?>]"
                                                value="<?php echo e($emp->designation->name ?? 'N/A'); ?>">
                                        </td>
                                        <td>
                                            <?php echo e($emp->profile?->account_number ?? 'N/A'); ?>

                                            <input type="hidden" name="account_number[<?php echo e($emp->id); ?>]"
                                                value="<?php echo e($emp->profile?->account_number ?? 'N/A'); ?>">
                                        </td>
                                        <td>
                                            <?php echo e($emp->profile?->ifsc_code ?? 'N/A'); ?>

                                            <input type="hidden" name="ifsc[<?php echo e($emp->id); ?>]"
                                                value="<?php echo e($emp->profile?->ifsc_code ?? 'N/A'); ?>">
                                        </td>
                                        <td>
                                            <?php echo e($monthdays); ?>

                                            <input type="hidden" name="month_days[<?php echo e($emp->id); ?>]"
                                                value="<?php echo e($monthdays); ?>">
                                        </td>
                                        <td>
                                            <?php echo e($emp->emppresent); ?>

                                            <input type="hidden" name="present[<?php echo e($emp->id); ?>]"
                                                value="<?php echo e($emp->emppresent); ?>">
                                        </td>
                                        <td>
                                            <?php echo e($emp->holidays); ?>

                                            <input type="hidden" name="holidays[<?php echo e($emp->id); ?>]"
                                                value="<?php echo e($emp->holidays); ?>">
                                        </td>
                                        <td>
                                            <?php echo e($sundaysCount); ?>

                                            <input type="hidden" name="weekends[<?php echo e($emp->id); ?>]"
                                                value="<?php echo e($sundaysCount); ?>">
                                        </td>
                                        <td>
                                            <?php echo e($emp->leaveDays); ?>

                                            <input type="hidden" name="leaves[<?php echo e($emp->id); ?>]"
                                                value="<?php echo e($emp->leaveDays); ?>">
                                        </td>
                                        <td>
                                            <?php echo e($emp->absents); ?>

                                            <input type="hidden" name="absents[<?php echo e($emp->id); ?>]"
                                                value="<?php echo e($emp->absents); ?>">
                                        </td>
                                        <td>
                                            <?php echo e($emp->paybledays); ?>

                                            <input type="hidden" name="paybled_days[<?php echo e($emp->id); ?>]"
                                                value="<?php echo e($emp->paybledays); ?>">
                                        </td>
                                        <?php $__currentLoopData = $emp->earnings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $earning): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <td>
                                                <?php echo e(number_format($earning->amount, 2)); ?>

                                                <input type="hidden"
                                                    name="earnings[<?php echo e($emp->id); ?>][<?php echo e($earning->salary_type_name); ?>]"
                                                    value="<?php echo e($earning->amount); ?>">
                                            </td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php $__currentLoopData = $emp->deductions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deduction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <td>
                                                <?php echo e(number_format($deduction->amount, 2)); ?>

                                                <input type="hidden"
                                                    name="deductions[<?php echo e($emp->id); ?>][<?php echo e($deduction->salary_type_name); ?>]"
                                                    value="<?php echo e($deduction->amount); ?>">
                                            </td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php $__currentLoopData = $emp->net; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nets): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <td>
                                                <?php echo e(number_format($nets->amount, 2)); ?>

                                                <input type="hidden"
                                                    name="net[<?php echo e($emp->id); ?>][<?php echo e($nets->salary_type_name); ?>]"
                                                    value="<?php echo e($nets->amount); ?>">
                                            </td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <td>
                                            <?php echo e(number_format($emp->loanEmi, 2)); ?>

                                            <input type="hidden" name="loan[<?php echo e($emp->id); ?>]"
                                                value="<?php echo e($emp->loanEmi); ?>">
                                        </td>
                                        <td>
                                            <?php echo e(number_format($emp->expenseTotal, 2)); ?>

                                            <input type="hidden" name="expense[<?php echo e($emp->id); ?>]"
                                                value="<?php echo e($emp->expenseTotal); ?>">
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </form>
                </div>
                <div class="mt-3 text-end">
                    <button type="button" id="submitSalaryBtn"
                        class="btn <?php echo e($SalaryVerified ? 'btn-warning' : 'btn-success'); ?>">
                        <span class="btn-text">
                            <i class="fa fa-save"></i>
                            <?php echo e($SalaryVerified ? 'Already Verified (Click to Re-Verify)' : 'Process Salary'); ?>

                        </span>
                        <span class="spinner-border spinner-border-sm d-none" id="btnLoader"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            $('#submitSalaryBtn').on('click', function() {

                let btn = $(this);
                let loader = $('#btnLoader');
                let text = $('.btn-text');

                // show loader
                btn.prop('disabled', true);
                loader.removeClass('d-none');
                text.addClass('d-none');

                $.ajax({
                    url: "<?php echo e(route('admin.salary.process.save')); ?>",
                    type: "POST",
                    data: $('form').serialize(),

                    success: function(response) {

                        // hide loader
                        btn.prop('disabled', false);
                        loader.addClass('d-none');
                        text.removeClass('d-none');
                        if (response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message ??
                                    'Salary processed successfully',
                                confirmButtonColor: '#3085d6'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Failed',
                                text: response.message ?? 'Something went wrong',
                                confirmButtonColor: '#d33'
                            });
                        }
                    },

                    error: function(xhr) {

                        btn.prop('disabled', false);
                        loader.addClass('d-none');
                        text.removeClass('d-none');

                        Swal.fire({
                            icon: 'error',
                            title: 'Server Error',
                            text: 'Something went wrong. Please try again.',
                            confirmButtonColor: '#d33'
                        });
                    }
                });

            });

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Varahi\resources\views/admin/salary/process_salary.blade.php ENDPATH**/ ?>