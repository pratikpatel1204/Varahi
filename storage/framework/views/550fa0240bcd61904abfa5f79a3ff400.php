
<?php $__env->startSection('title', config('app.name') . ' || Attendance Preview'); ?>
<?php $__env->startSection('content'); ?>
    <div class="content">
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    Attendance Preview - <?php echo e($month); ?> <?php echo e($year); ?>

                </h5>
                <h5 class="mb-0">
                    <strong>Total Working Days:</strong> <?php echo e($totalWorkingDays); ?>

                </h5>
                <a href="<?php echo e(route('admin.salary.Processing', ['year' => $year, 'month' => $month])); ?>" class="btn btn-secondary btn-sm">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
            <div class="card-body">
                <form id="attendancePreviewForm">
                    <?php echo csrf_field(); ?>

                    <input type="hidden" name="year" value="<?php echo e($year); ?>">
                    <input type="hidden" name="month" value="<?php echo e($month); ?>">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>Action</th>
                                    <th>Employee</th>
                                    <th>Total Days</th>
                                    <th>Present</th>
                                    <th>Holiday</th>
                                    <th>Sick Leave</th>
                                    <th>Casual Leave</th>
                                    <th>Paid Leave</th>
                                    <th>Absent</th>
                                    <th>Payable Days</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            <a href="<?php echo e(route('admin.salary.attendance.show', ['employee_id' => $row['employee_id'], 'month' => $month, 'year' => $year])); ?>"
                                                class="btn btn-sm btn-info">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <?php echo e($row['employee_name']); ?>

                                            <br>
                                            <?php echo e($row['employee_code']); ?>

                                            <input type="hidden" name="rows[<?php echo e($index); ?>][employee_name]"
                                                value="<?php echo e($row['employee_name']); ?>">
                                            <input type="hidden" name="rows[<?php echo e($index); ?>][employee_code]"
                                                value="<?php echo e($row['employee_code']); ?>">
                                            <input type="hidden" name="rows[<?php echo e($index); ?>][employee_id]"
                                                value="<?php echo e($row['employee_id']); ?>">
                                        </td>
                                        <td>
                                            <div contenteditable="true" class="cell-value" data-row="<?php echo e($index); ?>"
                                                data-col="total_days">
                                                <?php echo e($row['total_days']); ?>

                                            </div>
                                            <input type="hidden" name="rows[<?php echo e($index); ?>][total_days]"
                                                value="<?php echo e($row['total_days']); ?>">
                                        </td>

                                        <td>
                                            <div contenteditable="true" class="cell-value" data-row="<?php echo e($index); ?>"
                                                data-col="present_days">
                                                <?php echo e($row['present_days']); ?>

                                            </div>
                                            <input type="hidden" name="rows[<?php echo e($index); ?>][present_days]"
                                                value="<?php echo e($row['present_days']); ?>">
                                        </td>
                                        <td>
                                            <div class="cell-value"><?php echo e($row['holiday_days'] ?? 0); ?></div>
                                            <input type="hidden" name="rows[<?php echo e($index); ?>][holiday_days]" value="<?php echo e($row['holiday_days'] ?? 0); ?>">
                                        </td>
                                        <td>
                                            <div contenteditable="true" class="cell-value" data-row="<?php echo e($index); ?>"
                                                data-col="sick_leave">
                                                <?php echo e($row['sick_leave']); ?>

                                            </div>
                                            <input type="hidden" name="rows[<?php echo e($index); ?>][sick_leave]"
                                                value="<?php echo e($row['sick_leave']); ?>">
                                        </td>

                                        <td>
                                            <div contenteditable="true" class="cell-value" data-row="<?php echo e($index); ?>"
                                                data-col="casual_leave">
                                                <?php echo e($row['casual_leave']); ?>

                                            </div>
                                            <input type="hidden" name="rows[<?php echo e($index); ?>][casual_leave]"
                                                value="<?php echo e($row['casual_leave']); ?>">
                                        </td>

                                        <td>
                                            <div contenteditable="true" class="cell-value" data-row="<?php echo e($index); ?>"
                                                data-col="paid_leave">
                                                <?php echo e($row['paid_leave']); ?>

                                            </div>
                                            <input type="hidden" name="rows[<?php echo e($index); ?>][paid_leave]"
                                                value="<?php echo e($row['paid_leave']); ?>">
                                        </td>

                                        <td>
                                            <div contenteditable="true" class="cell-value" data-row="<?php echo e($index); ?>"
                                                data-col="absent_days">
                                                <?php echo e($row['absent_days']); ?>

                                            </div>
                                            <input type="hidden" name="rows[<?php echo e($index); ?>][absent_days]"
                                                value="<?php echo e($row['absent_days']); ?>">
                                        </td>

                                        <td>
                                            <div contenteditable="true" class="cell-value" data-row="<?php echo e($index); ?>"
                                                data-col="payable_days">
                                                <?php echo e($row['payable_days']); ?>

                                            </div>
                                            <input type="hidden" name="rows[<?php echo e($index); ?>][payable_days]"
                                                value="<?php echo e($row['payable_days']); ?>">
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="9" class="text-center text-danger">No Attendance Data Found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>

                        </table>
                    </div>
                    <button type="button" id="submitBtn"
                        class="btn mt-3 w-auto <?php echo e($attendanceVerified ? 'btn-warning' : 'btn-success'); ?>">

                        <span class="btn-text">
                            <?php echo e($attendanceVerified ? 'Already Verified (Click to Re-Verify)' : 'Finalize & Verify'); ?>

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
        document.querySelectorAll('.cell-value').forEach(cell => {
            cell.addEventListener('input', function() {
                const row = this.dataset.row;
                const col = this.dataset.col;
                const hiddenInput = document.querySelector(`input[name="rows[${row}][${col}]"]`);
                hiddenInput.value = this.textContent.trim();
            });
        });

        document.getElementById('submitBtn').addEventListener('click', function() {

            let btn = this;
            let loader = btn.querySelector('.btn-loader');
            let text = btn.querySelector('.btn-text');

            btn.disabled = true;
            loader.classList.remove('d-none');
            text.classList.add('d-none');

            let formData = new FormData(document.getElementById('attendancePreviewForm'));

            fetch("<?php echo e(route('admin.salary.attendance.store')); ?>", {
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
                            text: data.message || 'Attendance Verified!'
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

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Varahi\resources\views/admin/salary/attendance_preview.blade.php ENDPATH**/ ?>