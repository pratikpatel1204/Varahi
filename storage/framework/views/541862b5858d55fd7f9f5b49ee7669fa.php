
<?php $__env->startSection('title', config('app.name') . ' || Salary Processing'); ?>

<?php $__env->startSection('content'); ?>
    <div class="content">

        
        <div class="card mb-3 shadow-sm">
            <div class="card-header">
                <h5 class="mb-3">Salary Processing Period</h5>
                <?php if(session('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <?php echo e(session('success')); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <?php echo e(session('error')); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
            </div>

            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label>Select Year</label>
                        <select class="form-select" id="salaryYear">
                            <option value="">-- Select Year --</option>
                            <?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($year->year); ?>"
                                    <?php echo e($selectedYear == $year->year || (!$selectedYear && $year->status == 'Active') ? 'selected' : ''); ?>>
                                    <?php echo e($year->year); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label>Select Month</label>
                        <select class="form-select" id="salaryMonth">
                            <option value="">-- Select Month --</option>
                            <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($month->month_name); ?>"
                                    <?php echo e($selectedMonth == $month->month_name || (!$selectedMonth && $month->status == 1) ? 'selected' : ''); ?>>
                                    <?php echo e($month->month_name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="row g-3">

                    <!-- STEP 1 -->
                    <div class="col-md-4">
                        <div class="card border-primary bg-transparent text-center process-card disabled" data-step="1">
                            <div class="card-body">
                                <span class="badge bg-primary mb-1">1</span>
                                <h6>Verify Attendance</h6>
                                <p class="text-muted small">Check attendance</p>
                                <button class="btn btn-primary btn-sm verify-attendance" disabled>Verify</button>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 2 -->
                    <div class="col-md-4">
                        <div class="card border-primary bg-transparent text-center process-card disabled" data-step="2">
                            <div class="card-body">
                                <span class="badge bg-primary mb-1">2</span>
                                <h6>Verify Loan</h6>
                                <p class="text-muted small">Validate loans</p>
                                <button class="btn btn-primary btn-sm" disabled>Verify</button>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 3 -->
                    <div class="col-md-4">
                        <div class="card border-primary bg-transparent text-center process-card disabled" data-step="3">
                            <div class="card-body">
                                <span class="badge bg-primary mb-1">3</span>
                                <h6>Verify Reimbursement</h6>
                                <p class="text-muted small">Check expenses</p>
                                <button class="btn btn-primary btn-sm" disabled>Verify</button>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 4 (PROCESS SALARY) -->
                    <div class="col-md-6">
                        <div class="card border-primary bg-transparent text-center process-card disabled" data-step="4">
                            <div class="card-body">
                                <span class="badge bg-primary mb-1">4</span>
                                <h6>Process Salary</h6>
                                <p class="text-muted small">Finalize salary</p>
                                <button class="btn btn-primary btn-sm" disabled>Process</button>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 5 (FINAL) -->
                    <div class="col-md-6">
                        <div class="card border-primary bg-transparent text-center process-card final disabled"
                            data-step="5">
                            <div class="card-body">
                                <span class="badge bg-primary mb-1">5</span>
                                <h6>Generate Salary Slip</h6>
                                <p class="text-muted small">Download slips</p>
                                <button class="btn btn-primary btn-sm" disabled>Open</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <script>
        function resetSteps() {
            document.querySelectorAll('.process-card').forEach(card => {
                // Disable the card
                card.classList.add('disabled');

                // Reset card border to primary
                card.classList.remove('border-success', 'border-warning');
                card.classList.add('border-primary');

                // Reset badge color to primary
                let badge = card.querySelector('span.badge');
                if (badge) {
                    badge.classList.remove('bg-success', 'bg-warning');
                    badge.classList.add('bg-primary');
                }

                // Reset button
                let btn = card.querySelector('button');
                if (btn) {
                    btn.disabled = true;
                    btn.innerText = 'Verify';
                    btn.classList.remove('btn-success', 'btn-warning');
                    btn.classList.add('btn-primary');
                }
            });
        }

        function enableStep(step) {
            document.querySelectorAll('.process-card').forEach(card => {
                let cardStep = parseInt(card.getAttribute('data-step'));

                // Steps before current step → enable but keep primary color
                if (cardStep < step) {
                    card.classList.remove('disabled');
                    card.classList.remove('border-warning', 'border-success');
                    card.classList.add('border-primary');

                    let btn = card.querySelector('button');
                    if (btn) {
                        btn.disabled = false; // allow click even if not verified
                        btn.classList.remove('btn-warning', 'btn-success');
                        btn.classList.add('btn-primary');
                        btn.innerText = 'Verify';
                    }

                    let badge = card.querySelector('span.badge');
                    if (badge) {
                        badge.classList.remove('bg-warning', 'bg-success');
                        badge.classList.add('bg-primary');
                    }
                }

                // Current step → warning (active)
                if (cardStep == step) {
                    card.classList.remove('disabled', 'border-primary', 'border-success');
                    card.classList.add('border-warning');

                    let btn = card.querySelector('button');
                    if (btn) {
                        btn.disabled = false;
                        btn.classList.remove('btn-primary', 'btn-success');
                        btn.classList.add('btn-warning');
                    }

                    let badge = card.querySelector('span.badge');
                    if (badge) {
                        badge.classList.remove('bg-primary', 'bg-success');
                        badge.classList.add('bg-warning');
                    }
                }

                // Steps after current → keep disabled
                if (cardStep > step) {
                    card.classList.add('disabled');
                    card.classList.remove('border-success', 'border-warning');
                    card.classList.add('border-primary');

                    let btn = card.querySelector('button');
                    if (btn) {
                        btn.disabled = true;
                        btn.classList.remove('btn-warning', 'btn-success');
                        btn.classList.add('btn-primary');
                        btn.innerText = 'Verify';
                    }

                    let badge = card.querySelector('span.badge');
                    if (badge) {
                        badge.classList.remove('bg-warning', 'bg-success');
                        badge.classList.add('bg-primary');
                    }
                }
            });
        }

        function markCompleted(step) {
            let card = document.querySelector('[data-step="' + step + '"]');
            if (card) {
                let btn = card.querySelector('button');
                let badge = card.querySelector('span.badge');
                if (btn) {
                    btn.innerText = 'Verified';
                    btn.classList.remove('btn-primary');
                    btn.classList.add('btn-success');
                    btn.disabled = true;
                }
                if (badge) {
                    badge.classList.remove('bg-primary');
                    badge.classList.add('bg-success');
                }

                card.classList.remove('border-primary');
                card.classList.add('border-success');
            }
        }

        function applyStatus(status) {

            if (!status) {
                enableStep(1);
                return;
            }

            // ✅ If salary fully processed
            if (status.salary_processed == "1") {
                markCompleted(1);
                markCompleted(2);
                markCompleted(3);
                markCompleted(4);
                enableStep(5);
                return;
            }

            // ✅ Correct step mapping (1 → 5)
            const steps = [{
                    step: 1,
                    key: 'attendance_verified'
                },
                {
                    step: 2,
                    key: 'loan_verified'
                },
                {
                    step: 3,
                    key: 'expense_verified'
                }, // ✅ FIXED
                {
                    step: 4,
                    key: 'salary_processed'
                }
            ];

            for (let item of steps) {
                if (status[item.key] == "1") {
                    markCompleted(item.step);
                } else {
                    enableStep(item.step);
                    return;
                }
            }
        }

        function fetchProcessStatus() {

            let year = document.getElementById('salaryYear').value;
            let month = document.getElementById('salaryMonth').value;

            if (!year || !month) return;

            resetSteps();

            fetch("<?php echo e(route('admin.salary.process.status')); ?>?year=" + year + "&month=" + month)
                .then(res => res.json())
                .then(data => applyStatus(data));
        }

        document.querySelectorAll('#salaryYear,#salaryMonth')
            .forEach(el => el.addEventListener('change', fetchProcessStatus));

        document.addEventListener("DOMContentLoaded", fetchProcessStatus);


        /* CLICK ACTIONS */

        function redirectTo(route) {
            let year = $('#salaryYear').val();
            let month = $('#salaryMonth').val();

            if (!checkYearMonth(year, month)) return;

            function checkYearMonth(year, month) {
                if (!year || !month) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops!',
                        text: 'Select Year & Month',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                    return false;
                }
                return true;
            }

            window.location.href = route + "?year=" + year + "&month=" + month;
        }

        $(document).on('click', '.verify-attendance', function() {
            redirectTo("<?php echo e(route('admin.salary.attendance.preview')); ?>");
        });

        $(document).on('click', '[data-step="2"] button', function() {
            redirectTo("<?php echo e(route('admin.salary.loan.preview')); ?>");
        });

        $(document).on('click', '[data-step="3"] button', function() {
            redirectTo("<?php echo e(route('admin.salary.expense.preview')); ?>");
        });

        $(document).on('click', '[data-step="4"] button', function() {
            redirectTo("<?php echo e(route('admin.salary.process.verify')); ?>");
        });

        $(document).on('click', '[data-step="5"] button', function() {
            redirectTo("<?php echo e(route('admin.salary.slip.page')); ?>");
        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Varahi\resources\views/admin/salary/process.blade.php ENDPATH**/ ?>