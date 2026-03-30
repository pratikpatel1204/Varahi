<?php $__env->startSection('title', config('app.name') . ' || Create loans'); ?>
<?php $__env->startSection('content'); ?>
    <div class="content">
        <div class="card">
            <div class="card-header d-md-flex justify-content-between">
                <h3>Create loans</h3>
            </div>
            <div class="card-body">
                <form method="POST" id="loanForm">
                    <?php echo csrf_field(); ?>
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Select Employee <span class="text-danger">*</span></label>
                            <select class="select2" name="employee_id" id="employee_select" required>
                                <option value="">-- Select Employee --</option>
                                <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($emp->id); ?>" data-name="<?php echo e($emp->name); ?>"
                                        data-phone="<?php echo e($emp->phone); ?>" data-code="<?php echo e($emp->employee_code); ?>"
                                        data-department="<?php echo e($emp->department->name ?? ''); ?>"
                                        data-subdept="<?php echo e($emp->subDepartment->name ?? ''); ?>"
                                        data-designation="<?php echo e($emp->designation->name ?? ''); ?>">
                                        <?php echo e($emp->name); ?> (<?php echo e($emp->employee_code); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <div class="border rounded p-2 bg-light h-100">
                                <p class="mb-2">
                                    <strong>Name:</strong>
                                    <span class="text-dark" id="emp_name"></span>
                                </p>
                                <p class="mb-2">
                                    <strong>Phone:</strong>
                                    <span class="text-dark" id="emp_phone"></span>
                                </p>
                                <p class="mb-2">
                                    <strong>Code:</strong>
                                    <span class="text-dark" id="emp_code"></span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border rounded p-2 bg-light h-100">
                                <p class="mb-2">
                                    <strong>Department:</strong>
                                    <span class="text-dark" id="emp_department"></span>
                                </p>
                                <p class="mb-2">
                                    <strong>Sub Department:</strong>
                                    <span class="text-dark" id="emp_subdept"></span>
                                </p>
                                <p class="mb-2">
                                    <strong>Designation:</strong>
                                    <span class="text-dark" id="emp_designation"></span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Loan Amount <span class="text-danger">*</span></label>
                            <input type="number" name="loan_amount" id="loan_amount" class="form-control calc"
                                min="1" step="0.01" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Interest % <span class="text-danger">*</span></label>
                            <input type="number" name="interest_rate" id="interest_rate" class="form-control calc"
                                min="0" step="0.01" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">No of EMI <span class="text-danger">*</span></label>
                            <input type="number" name="no_of_emi" id="no_of_emi" class="form-control calc" min="1"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">EMI Start Date <span class="text-danger">*</span></label>
                            <input type="date" name="emi_start_date" id="emi_start_date" class="form-control calc"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">EMI End Date</label>
                            <input type="date" name="emi_end_date" id="emi_end_date" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Total Loan (With Interest)</label>
                            <input type="number" name="total_amount" id="total_amount" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">EMI Amount</label>
                            <input type="number" name="emi_amount" id="emi_amount" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="mt-3 text-end">
                        <button type="submit" id="submitBtn" class="btn btn-primary px-3">
                            <span class="btn-text">Save Loan</span>
                            <span class="spinner-border spinner-border-sm d-none" id="btnLoader"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            $('#employee_select').on('change', function() {

                let option = this.options[this.selectedIndex];

                if (!this.value) return;

                $('#emp_name').text(option.getAttribute('data-name') || '-');
                $('#emp_phone').text(option.getAttribute('data-phone') || '-');
                $('#emp_code').text(option.getAttribute('data-code') || '-');
                $('#emp_department').text(option.getAttribute('data-department') || '-');
                $('#emp_subdept').text(option.getAttribute('data-subdept') || '-');
                $('#emp_designation').text(option.getAttribute('data-designation') || '-');
            });

        });
    </script>
    <script>
        $(document).ready(function() {
            function calculateLoan() {
                let amount = parseFloat($('#loan_amount').val()) || 0;
                let interest = parseFloat($('#interest_rate').val()) || 0;
                let noOfEmi = parseInt($('#no_of_emi').val()) || 1;

                let total = amount + (amount * interest / 100);
                let emi = noOfEmi > 0 ? (total / noOfEmi) : 0;

                $('#total_amount').val(total.toFixed(2));
                $('#emi_amount').val(emi.toFixed(2));

                // EMI END DATE
                let startDate = $('#emi_start_date').val();

                if (startDate && noOfEmi > 0) {
                    let start = new Date(startDate);
                    let end = new Date(start);

                    end.setMonth(end.getMonth() + noOfEmi - 1);

                    let yyyy = end.getFullYear();
                    let mm = String(end.getMonth() + 1).padStart(2, '0');
                    let dd = String(end.getDate()).padStart(2, '0');

                    $('#emi_end_date').val(`${yyyy}-${mm}-${dd}`);
                } else {
                    $('#emi_end_date').val('');
                }
            }
            $('.calc').on('input change', calculateLoan);
        });
        $('#loanForm').on('submit', function(e) {
            e.preventDefault();

            let form = $(this);
            let btn = $('#submitBtn');
            let loader = $('#btnLoader');

            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();

            btn.prop('disabled', true);
            loader.removeClass('d-none');
            $('.btn-text').text('Saving...');

            $.ajax({
                url: "<?php echo e(route('admin.loans.store')); ?>",
                type: "POST",
                data: form.serialize(),
                success: function(res) {
                    btn.prop('disabled', false);
                    loader.addClass('d-none');
                    $('.btn-text').text('Save Loan');
                    if (res.status === true) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: res.message || 'Loan created successfully!'
                        });
                        form[0].reset();
                        $('#emi_end_date, #total_amount, #emi_amount').val('');
                        $('#employeeDetails span').text('');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: res.message || 'Something went wrong!'
                        });
                    }
                },
                error: function(xhr) {
                    btn.prop('disabled', false);
                    loader.addClass('d-none');
                    $('.btn-text').text('Save Loan');
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            let input = $('[name="' + key + '"]');
                            input.addClass('is-invalid');
                            input.after('<span class="invalid-feedback text-danger d-block">' +
                                value[0] + '</span>');
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Server Error!'
                        });
                    }
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Varahi\resources\views/admin/loans/create.blade.php ENDPATH**/ ?>