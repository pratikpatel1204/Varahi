<?php $__env->startSection('title', config('app.name') . ' || Employee Dashboard'); ?>
<?php $__env->startSection('content'); ?>
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Employee Dashboard</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0);"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            Dashboard
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Employee Dashboard</li>
                    </ol>
                </nav>
            </div>
        </div>
        <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leave): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="alert bg-secondary-transparent alert-dismissible fade show mb-4 leave-alert"
                data-id="<?php echo e($leave->id); ?>">

                Your Leave Request on
                <strong><?php echo e(\Carbon\Carbon::parse($leave->from_date)->format('d M Y')); ?></strong>
                has been
                <strong class="<?php echo e($leave->status == 'Approved' ? 'text-success' : 'text-danger'); ?>">
                    <?php echo e($leave->status); ?>

                </strong> !!!

                <button type="button" class="btn-close fs-14 mark-read" data-id="<?php echo e($leave->id); ?>"
                    data-bs-dismiss="alert">
                    <i class="ti ti-x"></i>
                </button>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <div class="row">
            <div class="col-xl-4 d-flex">
                <div class="card position-relative flex-fill">
                    <div class="card-header bg-dark">
                        <div class="d-flex align-items-center">
                            <span class="avatar avatar-lg avatar-rounded border border-white border-2 flex-shrink-0 me-2">
                                <?php if(!empty($employee->profile_image)): ?>
                                    <img src="<?php echo e(asset($employee->profile_image)); ?>" alt="Img">
                                <?php else: ?>
                                    <img src="<?php echo e(asset('admin/img/person-dummy.jpg')); ?>" alt="Img">
                                <?php endif; ?>
                            </span>
                            <div>
                                <h5 class="text-white mb-1"><?php echo e($employee->name); ?></h5>
                                <div class="d-flex align-items-center">
                                    <p class="text-white fs-12 mb-0"><?php echo e($employee->designation->name ?? 'N/A'); ?></p>
                                    <span class="mx-1"><i class="ti ti-point-filled text-primary"></i></span>
                                    <p class="fs-12"><?php echo e($employee->department->name ?? 'N/A'); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <span class="d-block mb-1 fs-13">Employee ID</span>
                            <p class="text-gray-9"><?php echo e($employee->employee_code ?? '-'); ?></p>
                        </div>
                        <div class="mb-3">
                            <span class="d-block mb-1 fs-13">Phone Number</span>
                            <p class="text-gray-9"><?php echo e($employee->phone ?? '-'); ?></p>
                        </div>
                        <div class="mb-3">
                            <span class="d-block mb-1 fs-13">Email Address</span>
                            <p class="text-gray-9">
                                <a href="javascript:void(0)" class="text-info d-inline-flex align-items-center copy-email"
                                    data-email="<?php echo e($employee->email); ?>">
                                    <?php echo e($employee->email ?? '-'); ?><i class="ti ti-copy text-dark ms-2"></i>
                                </a>
                            </p>
                        </div>
                        <div class="mb-3">
                            <span class="d-block mb-1 fs-13">Report Manager</span>
                            <p class="text-gray-9"><?php echo e($employee->manager->name ?? 'Not Assigned'); ?></p>
                        </div>
                        <div>
                            <span class="d-block mb-1 fs-13">Joined on</span>
                            <p class="text-gray-9">
                                <?php if(optional($employee->profile)->joining_date): ?>
                                    <?php echo e(\Carbon\Carbon::parse($employee->profile->joining_date)->format('d M Y')); ?>

                                <?php elseif($employee->created_at): ?>
                                    <?php echo e(\Carbon\Carbon::parse($employee->created_at)->format('d M Y')); ?>

                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-5 d-flex">
                <div class="card flex-fill">
                    <div class="card-header">
                        <h5>Attendance Overview (<?php echo e(now()->year); ?>)</h5>
                    </div>

                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center justify-content-between mb-3 p-2 rounded bg-light">
                                    <div class="d-flex align-items-center">
                                        <span class="avatar avatar-xs bg-success me-2">
                                            <i class="ti ti-check"></i>
                                        </span>
                                        <span class="fw-medium">Present</span>
                                    </div>
                                    <span class="fw-bold text-success"><?php echo e($presentCount); ?></span>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-3 p-2 rounded bg-light">
                                    <div class="d-flex align-items-center">
                                        <span class="avatar avatar-xs bg-warning me-2">
                                            <i class="ti ti-clock"></i>
                                        </span>
                                        <span class="fw-medium">Approval Pending</span>
                                    </div>
                                    <span class="fw-bold text-warning"><?php echo e($apCount); ?></span>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-3 p-2 rounded bg-light">
                                    <div class="d-flex align-items-center">
                                        <span class="avatar avatar-xs bg-danger me-2">
                                            <i class="ti ti-x"></i>
                                        </span>
                                        <span class="fw-medium">Absent</span>
                                    </div>
                                    <span class="fw-bold text-danger"><?php echo e($absentCount); ?></span>
                                </div>
                                <hr class="my-3">
                                <p class="fw-semibold text-gray-7 mb-2">Leave Breakdown</p>
                                <?php $__currentLoopData = $leaveTypeData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $days): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <div class="d-flex align-items-center">
                                            <span class="avatar avatar-xs bg-info me-2">
                                                <i class="ti ti-calendar"></i>
                                            </span>
                                            <span class="fw-medium"><?php echo e($type); ?></span>
                                        </div>
                                        <span class="fw-bold text-info"><?php echo e($days); ?></span>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-md-end">
                                    <div id="leaves_chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 d-flex">
                <div class="card flex-fill">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-2">
                            <h5>Leave Details</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-sm-6">
                                <div class="mb-4">
                                    <span class="d-block mb-1">Total Leaves</span>
                                    <h4><?php echo e($totalleaves); ?></h4>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-4">
                                    <span class="d-block mb-1">Taken</span>
                                    <h4><?php echo e($takenLeaves); ?></h4>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-4">
                                    <span class="d-block mb-1">Absent</span>
                                    <h4>0</h4>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-4">
                                    <span class="d-block mb-1">Request</span>
                                    <h4><?php echo e($pendingLeaves); ?></h4>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-4">
                                    <span class="d-block mb-1">Remaining</span>
                                    <h4><?php echo e($remainingLeaves); ?></h4>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div>
                                    <a href="#" class="btn btn-dark w-100" data-bs-toggle="modal"
                                        data-bs-target="#add_leaves">Apply New Leave</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-4 d-flex">
                <div class="card flex-fill border-primary attendance-bg">
                    <div class="attendance-card card-body">
                        <div class="mb-4 text-center">
                            <h6 class="fw-medium text-gray-5 mb-1">Attendance</h6>
                            <?php
                                $today = now();
                                $displayDate = $today;
                                if ($attendance && !$attendance->punch_out && $attendance->punch_in) {
                                    // sirf punch_in time use karo, date mat lagao
                                    $punchInDate = $attendance->date
                                        ? \Carbon\Carbon::parse($attendance->date)->toDateString()
                                        : now()->toDateString();
                                    $punchInTime = \Carbon\Carbon::parse($attendance->punch_in)->toTimeString();
                                    $displayDate = \Carbon\Carbon::parse($punchInDate . ' ' . $punchInTime);
                                }
                            ?>
                            <h4><?php echo e($displayDate->format('h:i A, d M Y')); ?></h4>
                        </div>
                        <div class="attendance-circle-progress attendance-progress mx-auto mb-3">
                            <span class="progress-left">
                                <span class="progress-bar"></span>
                            </span>
                            <span class="progress-right">
                                <span class="progress-bar"></span>
                            </span>
                            <div class="total-work-hours text-center w-100">
                                <span>Total Hours</span>
                                <h6 class="totalHours">00:00:00</h6>
                            </div>
                        </div>
                        <div class="text-center">
                            <h6 class="fw-medium d-flex align-items-center justify-content-center mb-4">
                                <i class="ti ti-fingerprint text-primary me-1"></i>
                                <span id="punchText">
                                    <?php if(!$attendance): ?>
                                        Not Punched In
                                    <?php elseif(!$attendance->punch_out): ?>
                                        <?php
                                            $today = now()->format('Y-m-d');
                                            $recordDate = optional($attendance)->date
                                                ? \Carbon\Carbon::parse($attendance->date)->format('Y-m-d')
                                                : null;
                                            $punchInTime = optional($attendance)->punch_in
                                                ? \Carbon\Carbon::parse($attendance->punch_in)->format('h:i A')
                                                : 'Unknown';
                                        ?>

                                        <?php if($recordDate && $recordDate !== $today): ?>
                                            Pending open punch from
                                            <?php echo e(\Carbon\Carbon::parse($attendance->date)->format('d M Y')); ?> (In at
                                            <?php echo e($punchInTime); ?>) — please complete punch out for this day.
                                        <?php else: ?>
                                            Punch In at <?php echo e($punchInTime); ?>

                                        <?php endif; ?>
                                    <?php else: ?>
                                        Completed
                                    <?php endif; ?>
                                </span>
                            </h6>
                            <button id="punchBtn" class="btn btn-primary w-100"
                                <?php echo e($attendance && $attendance->punch_out ? 'disabled' : ''); ?>

                                data-type="<?php echo e(!$attendance ? 'in' : (!$attendance->punch_out ? 'out' : 'completed')); ?>">

                                <?php if(!$attendance): ?>
                                    Punch In
                                <?php elseif(!$attendance->punch_out): ?>
                                    Punch Out
                                <?php else: ?>
                                    Completed
                                <?php endif; ?>
                            </button>

                            <button id="customPunchBtn" class="btn btn-outline-secondary w-100 mt-2"
                                <?php echo e($attendance && $attendance->punch_out ? 'disabled' : ''); ?>

                                data-type="<?php echo e(!$attendance ? 'in' : (!$attendance->punch_out ? 'out' : 'completed')); ?>">
                                <?php if(!$attendance): ?>
                                    Custom Punch In
                                <?php elseif(!$attendance->punch_out): ?>
                                    Custom Punch Out
                                <?php else: ?>
                                    Completed
                                <?php endif; ?>
                            </button>
                            <?php if(!$attendance): ?>
                                <button id="absentCustomBtn" class="btn btn-outline-danger w-100 mt-2">
                                    <i class="ti ti-calendar-off me-1"></i> Mark Attendance (Both Forgot)
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="punch_in"
                    value="<?php echo e($attendance && $attendance->punch_in
                        ? \Carbon\Carbon::parse($attendance->date)->toDateString() .
                            ' ' .
                            \Carbon\Carbon::parse($attendance->punch_in)->format('H:i:s')
                        : ''); ?>">

                <input type="hidden" id="punch_out"
                    value="<?php echo e($attendance && $attendance->punch_out
                        ? \Carbon\Carbon::parse($attendance->date)->toDateString() .
                            ' ' .
                            \Carbon\Carbon::parse($attendance->punch_out)->format('H:i:s')
                        : ''); ?>">
            </div>

            <div class="col-xl-8 d-flex">
                <div class="row flex-fill">
                    <div class="col-xl-6 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="border-bottom mb-3 pb-2">
                                    <span class="avatar avatar-sm bg-dark mb-2">
                                        <i class="ti ti-clock-up"></i>
                                    </span>

                                    <h2 class="mb-2">
                                        <?php echo e($weekHours); ?>

                                        / <span class="fs-20 text-gray-5">45</span>
                                    </h2>

                                    <p class="fw-medium text-truncate">Total Hours Week</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="border-bottom mb-3 pb-2">
                                    <span class="avatar avatar-sm bg-info mb-2">
                                        <i class="ti ti-calendar-up"></i>
                                    </span>
                                    <h2 class="mb-2">
                                        <?php echo e($monthHours); ?>

                                        / <span class="fs-20 text-gray-5">180</span>
                                    </h2>
                                    <p class="fw-medium text-truncate">Total Hours Month</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="border-bottom mb-3 pb-2">
                                    <span class="avatar avatar-sm bg-success mb-2">
                                        <i class="ti ti-clock-plus"></i>
                                    </span>
                                    <h2 class="mb-2">
                                        <?php echo e($weekOvertime); ?>

                                    </h2>
                                    <p class="fw-medium text-truncate">Overtime This Week</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="border-bottom mb-3 pb-2">
                                    <span class="avatar avatar-sm bg-pink mb-2">
                                        <i class="ti ti-calendar-star"></i>
                                    </span>
                                    <h2 class="mb-2">
                                        <?php echo e($monthOvertime); ?>

                                    </h2>
                                    <p class="fw-medium text-truncate">Overtime This Month</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Leaves -->
    <div class="modal fade" id="add_leaves">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Leave</h4>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form id="leaveForm">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body pb-0">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Leave Type <span class="text-danger">*</span></label>
                                    <select name="leave_type_id" id="leave_type_id" class="form-control">
                                        <option value="">Select</option>
                                        <?php $__currentLoopData = $leaves; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($type->leave_type_id); ?>">
                                                <?php echo e($type->leaveType->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <span class="text-danger error-text leave_type_id_error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">From <span class="text-danger">*</span></label>
                                    <input type="date" name="from_date" id="from_date" class="form-control">
                                    <span class="text-danger error-text from_date_error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">To <span class="text-danger">*</span></label>
                                    <input type="date" name="to_date" id="to_date" class="form-control">
                                    <span class="text-danger error-text to_date_error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">No of Days <span class="text-danger">*</span></label>
                                    <input type="text" name="days" id="days" class="form-control" readonly>
                                    <span class="text-danger error-text days_error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Remaining Days <span class="text-danger">*</span></label>
                                    <input type="text" name="remaining_days" id="remaining_days" class="form-control"
                                        readonly>
                                    <span class="text-danger error-text remaining_days_error"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Reason <span class="text-danger">*</span></label>
                                    <textarea name="reason" class="form-control" rows="3"></textarea>
                                    <span class="text-danger error-text reason_error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" id="leaveSubmitBtn" class="btn btn-primary">
                            <span class="btn-text">Add Leaves</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- CDN add karein -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        // Global flag
        let isProcessingPrevPunchOut = false;
        // ── Helpers ────────────────────────────────────────────
        function getCurrentTime() {
            let now = new Date();
            return now.toTimeString().slice(0, 5); // HH:MM
        }

        function formatTime(dateTimeStr) {
            if (!dateTimeStr) return '';
            let timePart = dateTimeStr.includes(' ') ? dateTimeStr.split(' ')[1] : dateTimeStr;
            let [hours, minutes] = timePart.split(':');

            if (hours === undefined || minutes === undefined) return '';

            hours = String(hours).padStart(2, '0');
            minutes = String(minutes).padStart(2, '0');

            return `${hours}:${minutes}`;
        }

        function timeToMinutes(timeStr) {
            if (!timeStr || !timeStr.includes(':')) return 0;
            let [h, m] = timeStr.split(':').map(Number);
            if (Number.isNaN(h) || Number.isNaN(m)) return 0;
            return h * 60 + m;
        }



        function parsePunchDate(punchIn) {
            if (!punchIn) return null;

            const input = punchIn.trim();

            // 1) explicit HH:MM (no date)
            if (/^\d{1,2}:\d{1,2}$/.test(input)) {
                const [h, m] = input.split(':').map(Number);
                const now = new Date();
                return new Date(now.getFullYear(), now.getMonth(), now.getDate(), h, m);
            }

            // 2) date and time separated by space or T
            const normalized = input.replace(' ', 'T');

            // try full ISO parse
            let parsed = new Date(normalized);

            if (!isNaN(parsed.getTime())) {
                return parsed;
            }

            // fallback for 'YYYY-MM-DD HH:MM:SS' and if timezone differences
            const parts = input.split(' ');
            if (parts.length >= 2) {
                const datePart = parts[0];
                const timePart = parts.slice(1).join(' ');
                const dt = `${datePart}T${timePart}`;
                parsed = new Date(dt);
                if (!isNaN(parsed.getTime())) {
                    return parsed;
                }

                // explicit manual build from date/time
                const [y, mo, d] = datePart.split('-').map(Number);
                const [h, min, s] = timePart.split(':').map(Number);
                if (Number.isNaN(y) || Number.isNaN(mo) || Number.isNaN(d) || Number.isNaN(h) || Number.isNaN(min)) {
                    return null;
                }
                return new Date(y, mo - 1, d, h, min, Number.isNaN(s) ? 0 : s);
            }

            return null;
        }

        function calculateWorkedDuration(punchIn) {
            if (!punchIn) return 0;

            const now = new Date();
            let punchDate = parsePunchDate(punchIn);

            if (!punchDate || isNaN(punchDate.getTime())) return 0;

            // if the punch date is in future by more than 5 minutes, assume it was yesterday (cross-day stores maybe unspecific)
            if (punchDate > now && (punchDate.getTime() - now.getTime()) > 5 * 60 * 1000) {
                punchDate.setDate(punchDate.getDate() - 1);
            }

            let diff = Math.floor((now.getTime() - punchDate.getTime()) / 1000);
            return diff > 0 ? diff : 0;
        }

        function formatDuration(seconds) {
            let hrs = Math.floor(seconds / 3600);
            let mins = Math.floor((seconds % 3600) / 60);
            let secs = seconds % 60;
            const pad = v => String(v).padStart(2, '0');
            return `${pad(hrs)}:${pad(mins)}:${pad(secs)}`;
        }

        function calculateWorkedHours(punchIn) {
            return Math.floor(calculateWorkedDuration(punchIn) / 3600);
        }

        function updateTotalHours() {
            let punchIn = $('#punch_in').val();
            let punchOut = $('#punch_out').val();

            if (!punchIn) {
                $('.totalHours').text('00:00:00');
                return;
            }

            if (punchOut) {
                // Punch out ho gaya — in se out tak ka diff
                let inDate = parsePunchDate(punchIn);
                let outDate = parsePunchDate(punchOut);
                if (!inDate || !outDate) {
                    $('.totalHours').text('00:00:00');
                    return;
                }
                let diff = Math.floor((outDate.getTime() - inDate.getTime()) / 1000);
                $('.totalHours').text(formatDuration(diff > 0 ? diff : 0));
            } else {
                // Still punched in — live timer
                $('.totalHours').text(formatDuration(calculateWorkedDuration(punchIn)));
            }
        }

        function startTotalHoursTimer() {
            let punchIn = $('#punch_in').val();
            let punchOut = $('#punch_out').val();
            if (!punchIn) return;

            updateTotalHours();

            if (!punchOut) {
                // Sirf tab interval jab punch out pending ho
                window.totalHoursTimer = setInterval(updateTotalHours, 1000);
            }
        }

        function startTotalHoursTimer() {
            let punchIn = $('#punch_in').val();
            let punchOut = $('#punch_out').val();

            if (!punchIn) return;

            updateTotalHours(); // pehle ek baar chalaao

            if (!punchOut) {
                // ✅ Sirf tab interval lagao jab punch out nahi hua
                window.totalHoursTimer = setInterval(updateTotalHours, 1000);
            }
            // ✅ Punch out ho gaya — interval ki zarurat nahi, static value dikhao
        }

        function formatToDDMMYY(dateStr) {
            const d = new Date(dateStr);
            const day = String(d.getDate()).padStart(2, '0');
            const month = String(d.getMonth() + 1).padStart(2, '0');
            const year = String(d.getFullYear());
            return `${day}-${month}-${year}`;
        }

        async function getCurrentLocation() {
            return new Promise((resolve, reject) => {
                if (!navigator.geolocation) return reject('Geolocation not supported');
                navigator.geolocation.getCurrentPosition(
                    pos => resolve({
                        latitude: pos.coords.latitude,
                        longitude: pos.coords.longitude
                    }),
                    err => reject(err.message || 'GPS error'), {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    }
                );
            });
        }

        async function capturePhotoFromCamera() {
            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia)
                throw new Error('Camera not available');

            const stream = await navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: 'user'
                }
            });
            const video = document.createElement('video');
            video.autoplay = true;
            video.srcObject = stream;
            video.setAttribute('playsinline', true);

            await new Promise(resolve => {
                video.onloadedmetadata = resolve;
            });
            await new Promise(resolve => setTimeout(resolve, 500)); // camera warm up

            const canvas = document.createElement('canvas');
            canvas.width = video.videoWidth || 640;
            canvas.height = video.videoHeight || 480;
            canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
            stream.getTracks().forEach(t => t.stop());

            return canvas.toDataURL('image/jpeg', 0.6); // 0.6 quality = smaller size
        }

        async function collectPunchMeta(type) {
            let meta = {};
            try {
                const loc = await getCurrentLocation();
                if (type === 'in') {
                    meta.punch_in_latitude = loc.latitude;
                    meta.punch_in_longitude = loc.longitude;
                } else {
                    meta.punch_out_latitude = loc.latitude;
                    meta.punch_out_longitude = loc.longitude;
                }
            } catch (e) {
                console.warn('GPS failed:', e);
            }

            try {
                const photo = await capturePhotoFromCamera();
                if (type === 'in') meta.punch_in_photo = photo;
                else meta.punch_out_photo = photo;
            } catch (e) {
                console.warn('Camera failed:', e);
            }

            return meta;
        }

        // ── MAIN HANDLER ───────────────────────────────────────
        async function handlePunch(type, isCustom = false) {
            let $btn = $('#punchBtn');
            let $customBtn = $('#customPunchBtn');
            let currentTime = getCurrentTime();
            let punchInVal = $('#punch_in').val();

            $btn.prop('disabled', true).text('Processing...');
            $customBtn.prop('disabled', true);

            // ── PUNCH IN ──────────────────────────────────────────
            if (type === 'in') {

                let punchData = {
                    custom: isCustom ? 1 : 0
                };

                if (isCustom) {
                    // Custom Punch In — time + reason
                    const result = await Swal.fire({
                        title: 'Custom Punch In',
                        html: `
                    <div class="text-start">
                        <label class="form-label fw-semibold">Punch In Time</label>
                        <input type="time" id="swal-in-time" class="form-control mb-3" value="${currentTime}">
                        <label class="form-label fw-semibold">Reason <span class="text-danger">*</span></label>
                        <textarea id="swal-reason" class="form-control" rows="3"
                            placeholder="e.g. Reached office at 10:00 but forgot to punch in"></textarea>
                    </div>`,
                        showCancelButton: true,
                        confirmButtonText: 'Submit',
                        preConfirm: () => {
                            let inTime = $('#swal-in-time').val();
                            let reason = $('#swal-reason').val().trim();
                            if (!inTime) {
                                Swal.showValidationMessage('Punch In time is required');
                                return false;
                            }
                            if (!reason) {
                                Swal.showValidationMessage('Reason is required');
                                return false;
                            }
                            return {
                                in_time: inTime,
                                reason
                            };
                        }
                    });
                    if (!result.isConfirmed) {
                        resetBtns(type);
                        return;
                    }
                    punchData = {
                        ...punchData,
                        ...result.value
                    };

                } else {
                    // Normal Punch In
                    punchData.in_time = currentTime;

                    // ✅ Late punch in check — 10:00 ke baad hai?
                    let inMinutes = timeToMinutes(currentTime);
                    if (inMinutes > timeToMinutes('10:00')) {
                        const result = await Swal.fire({
                            title: 'Late Punch In',
                            html: `
                        <div class="text-start">
                            <p class="text-muted mb-3">You are punching in after <strong>10:00 AM</strong>. Please provide a reason.</p>
                            <label class="form-label fw-semibold">Reason <span class="text-danger">*</span></label>
                            <textarea id="swal-late-reason" class="form-control" rows="3"
                                placeholder="e.g. Traffic, doctor appointment..."></textarea>
                        </div>`,
                            showCancelButton: true,
                            confirmButtonText: 'Submit',
                            preConfirm: () => {
                                let reason = $('#swal-late-reason').val().trim();
                                if (!reason) {
                                    Swal.showValidationMessage('Reason is required');
                                    return false;
                                }
                                return {
                                    reason
                                };
                            }
                        });
                        if (!result.isConfirmed) {
                            resetBtns(type);
                            return;
                        }
                        punchData = {
                            ...punchData,
                            custom: 1,
                            ...result.value
                        };
                    }
                }

                let meta = await collectPunchMeta('in');

                $.ajax({
                    url: "<?php echo e(route('employee.attendance.punch')); ?>",
                    type: 'POST',
                    data: {
                        _token: "<?php echo e(csrf_token()); ?>",
                        type: 'in',
                        ...punchData,
                        ...meta
                    },
                    success: res => {
                        Swal.fire({
                            icon: 'success',
                            title: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                        setTimeout(() => location.reload(), 1600);
                    },
                    error: async xhr => {
                        let res = xhr.responseJSON;
                        console.log('Punch in error:', res);
                        if (res && res.message === 'incomplete_prev') {
                            resetBtns(type);
                            await handleIncompletePrev(res.prev_date, res.punch_in, punchData, meta);
                            return;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: res?.message || 'Something went wrong'
                        });
                        resetBtns(type);
                    }
                });
                return;
            }

            // ── PUNCH OUT ─────────────────────────────────────────
            if (type === 'out') {

                let hours = punchInVal ? calculateWorkedHours(punchInVal) : 0;
                let outMinutes = timeToMinutes(currentTime);
                let earlyLeave = outMinutes < timeToMinutes('19:00'); // 7 PM se pehle

                // previous-day detection from punch_in hidden value (more reliable)
                let attendanceDate = $('#attendance_date').val();
                if (!attendanceDate && punchInVal && punchInVal.includes(' ')) {
                    attendanceDate = punchInVal.split(' ')[0];
                }
                let todayDate = new Date().toISOString().slice(0, 10);
                let isPrevDate = attendanceDate && attendanceDate !== todayDate;

                // Previous day punch-out should go through pending correction modal (in/out and reason)
                if (isPrevDate && !isCustom) {
                    await handleIncompletePrev(attendanceDate || null, punchInVal, null, null);
                    resetBtns(type);
                    return;
                }

                if (isCustom) {
                    // Custom Punch Out — in/out time + reason
                    let defaultIn = punchInVal ? (() => {
                        let t = punchInVal.includes(' ') ? punchInVal.split(' ')[1] : punchInVal;
                        return t.slice(0, 5);
                    })() : currentTime;

                    const result = await Swal.fire({
                        title: 'Custom Punch Out',
                        html: `
                    <div class="text-start">
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label fw-semibold">In Time</label>
                                <input type="time" id="swal-in-time" class="form-control" value="${defaultIn}">
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-semibold">Out Time</label>
                                <input type="time" id="swal-out-time" class="form-control" value="${currentTime}">
                            </div>
                        </div>
                        <label class="form-label fw-semibold">Reason <span class="text-danger">*</span></label>
                        <textarea id="swal-reason" class="form-control" rows="3"
                            placeholder="e.g. Left early due to emergency"></textarea>
                    </div>`,
                        showCancelButton: true,
                        confirmButtonText: 'Submit',
                        preConfirm: () => {
                            let inTime = $('#swal-in-time').val();
                            let outTime = $('#swal-out-time').val();
                            let reason = $('#swal-reason').val().trim();
                            if (!inTime || !outTime) {
                                Swal.showValidationMessage('Both times are required');
                                return false;
                            }
                            if (timeToMinutes(outTime) === timeToMinutes(inTime)) {
                                Swal.showValidationMessage('Out time cannot be same as In time');
                                return false;
                            }
                            if (!reason) {
                                Swal.showValidationMessage('Reason is required');
                                return false;
                            }
                            let overnight = timeToMinutes(outTime) < timeToMinutes(inTime) ? 1 : 0;
                            return {
                                in_time: inTime,
                                out_time: outTime,
                                reason,
                                overnight
                            };
                        }
                    });
                    if (!result.isConfirmed) {
                        resetBtns(type);
                        return;
                    }
                    let meta = await collectPunchMeta('out');
                    submitPunch('out', {
                        ...result.value,
                        custom: 1,
                        ...meta
                    });
                    return;
                }

                // ✅ Normal punch out
                if (!earlyLeave && hours >= 8) {
                    // Normal — no reason needed
                    let meta = await collectPunchMeta('out');
                    submitPunch('out', {
                        out_time: currentTime,
                        custom: 0,
                        ...meta
                    });
                    return;
                }

                // ✅ Early punch out (7 PM se pehle) — reason poochho
                const result = await Swal.fire({
                    title: 'Early Punch Out',
                    html: `
                <div class="text-start">
                    <p class="text-muted mb-3">You are punching out before <strong>7:00 PM</strong>. Please provide a reason.</p>
                    <label class="form-label fw-semibold">Reason <span class="text-danger">*</span></label>
                    <textarea id="swal-early-reason" class="form-control" rows="3"
                        placeholder="e.g. Work completed, emergency at home..."></textarea>
                </div>`,
                    showCancelButton: true,
                    confirmButtonText: 'Submit',
                    preConfirm: () => {
                        let reason = $('#swal-early-reason').val().trim();
                        if (!reason) {
                            Swal.showValidationMessage('Reason is required');
                            return false;
                        }
                        return {
                            reason
                        };
                    }
                });
                if (!result.isConfirmed) {
                    resetBtns(type);
                    return;
                }

                let meta = await collectPunchMeta('out');
                submitPunch('out', {
                    out_time: currentTime,
                    custom: 1,
                    reason: result.value.reason,
                    ...meta
                });
            }
        }

        // ── Case 3: Pichle din ka punch out handle karo ────────


// Helper function: 12-hour to 24-hour conversion
function convertTo24Hour(time12h) {
    const [time, modifier] = time12h.split(' ');
    let [hours, minutes] = time.split(':');

    if (hours === '12') {
        hours = '00';
    }
    if (modifier.toUpperCase() === 'PM') {
        hours = parseInt(hours, 10) + 12;
    }

    return `${String(hours).padStart(2, '0')}:${minutes}`;
}
        async function handleIncompletePrev(prevDate, prevPunchIn, pendingInData = null, pendingInMeta = null) {
            let prevPunchInFormatted = prevPunchIn ?
                (prevPunchIn.includes(' ') ? prevPunchIn.split(' ')[1] : prevPunchIn).slice(0, 5) :
                '09:00';
            const formattedPrevDate = formatToDDMMYY(prevDate);
  const result = await Swal.fire({
    icon: 'warning',
    title: 'Pending Punch Out!',
    html: `
        <p class="mb-3">You forgot to punch out on <strong>${formattedPrevDate}</strong>.</p>
        <div class="text-start">
            <div class="row g-2 mb-3">
                <div class="col-6">
                    <label class="form-label fw-semibold">In Time (${formattedPrevDate})</label>
                    <input type="text" id="prev-in-time" class="form-control" placeholder="Select time">
                </div>
                <div class="col-6">
                    <label class="form-label fw-semibold">Out Time (${formattedPrevDate})</label>
                    <input type="text" id="prev-out-time" class="form-control" placeholder="Select time">
                </div>
            </div>
            <label class="form-label fw-semibold">Reason <span class="text-danger">*</span></label>
            <textarea id="prev-reason" class="form-control" rows="2"></textarea>
        </div>`,
    showCancelButton: true,
    confirmButtonText: 'Complete & Punch In Today',
    didOpen: () => {
        // Initialize Flatpickr with 12-hour format
        flatpickr('#prev-in-time', {
            enableTime: true,
            noCalendar: true,
            dateFormat: "h:i K",      // 12-hour format with AM/PM
            defaultDate: prevPunchInFormatted,
            time_24hr: false
        });

        flatpickr('#prev-out-time', {
            enableTime: true,
            noCalendar: true,
            dateFormat: "h:i K",
            defaultDate: "06:00 PM",
            time_24hr: false
        });
    },
    preConfirm: () => {
        let inTime = $('#prev-in-time').val();
        let outTime = $('#prev-out-time').val();
        let reason = $('#prev-reason').val().trim();

        if (!inTime || !outTime) {
            Swal.showValidationMessage('Both times required');
            return false;
        }
        if (!reason) {
            Swal.showValidationMessage('Reason is required');
            return false;
        }

        // Convert 12-hour to 24-hour for backend
        return {
            in_time: convertTo24Hour(inTime),
            out_time: convertTo24Hour(outTime),
            reason
        };
    }
});



            if (!result.isConfirmed) return;

            // ✅ Flag set karo — yeh prev day ka punch out hai, earlyLeave modal mat dikhao
            isProcessingPrevPunchOut = true;

            // metadata collect karo (GPS+photo)
            let outMeta = await collectPunchMeta('out');
            let punchOutDate = new Date().toISOString().slice(0, 10); // 30th march case me 30 bnega

            $.ajax({
                url: "<?php echo e(route('employee.attendance.punch')); ?>",
                type: 'POST',
                data: {
                    _token: "<?php echo e(csrf_token()); ?>",
                    type: 'out',
                    custom: 1,
                    in_time: result.value.in_time,
                    out_time: result.value.out_time,
                    punch_out_date: punchOutDate,
                    reason: result.value.reason,
                    ...outMeta
                },
                success: () => {
                    isProcessingPrevPunchOut = false; // ✅ Flag reset

                    if (pendingInData) {
                        $.ajax({
                            url: "<?php echo e(route('employee.attendance.punch')); ?>",
                            type: 'POST',
                            data: {
                                _token: "<?php echo e(csrf_token()); ?>",
                                type: 'in',
                                ...pendingInData,
                                ...pendingInMeta
                            },
                            success: res => {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'All done! ' + res.message,
                                    timer: 1800,
                                    showConfirmButton: false
                                });
                                setTimeout(() => location.reload(), 1900);
                            },
                            error: xhr => {
                                Swal.fire({
                                    icon: 'error',
                                    title: xhr.responseJSON?.message ||
                                        'Today punch in failed'
                                });
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Previous day punch out completed.',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        setTimeout(() => location.reload(), 1600);
                    }
                },
                error: xhr => {
                    isProcessingPrevPunchOut = false; // ✅ Flag reset on error bhi
                    Swal.fire({
                        icon: 'error',
                        title: xhr.responseJSON?.message || 'Failed to complete previous punch out'
                    });
                }
            });
        }
        // ── Case 4: Both forgot — Absent wala custom punch ─────
        // Yeh button dashboard pe alag se add karo agar chahiye
        async function handleAbsentCustomPunch() {
            const result = await Swal.fire({
                title: 'Custom Punch In & Out',
                html: `
                <div class="text-start">
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold">In Time</label>
                            <input type="time" id="abs-in-time" class="form-control" value="10:00">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">Out Time</label>
                            <input type="time" id="abs-out-time" class="form-control" value="18:00">
                        </div>
                    </div>
                    <label class="form-label fw-semibold">Reason <span class="text-danger">*</span></label>
                    <textarea id="abs-reason" class="form-control" rows="3"
                        placeholder="e.g. Was present but forgot both punch in and out"></textarea>
                </div>`,
                showCancelButton: true,
                confirmButtonText: 'Submit',
                preConfirm: () => {
                    let inTime = $('#abs-in-time').val();
                    let outTime = $('#abs-out-time').val();
                    let reason = $('#abs-reason').val().trim();
                    if (!inTime || !outTime) {
                        Swal.showValidationMessage('Both times required');
                        return false;
                    }
                    if (outTime <= inTime) {
                        Swal.showValidationMessage('Out time must be after In time');
                        return false;
                    }
                    if (!reason) {
                        Swal.showValidationMessage('Reason is required');
                        return false;
                    }
                    return {
                        in_time: inTime,
                        out_time: outTime,
                        reason
                    };
                }
            });

            if (!result.isConfirmed) return;

            // Pehle custom punch in
            $.ajax({
                url: "<?php echo e(route('employee.attendance.punch')); ?>",
                type: 'POST',
                data: {
                    _token: "<?php echo e(csrf_token()); ?>",
                    type: 'in',
                    custom: 1,
                    in_time: result.value.in_time,
                    reason: result.value.reason
                },
                success: () => {
                    // Phir custom punch out
                    $.ajax({
                        url: "<?php echo e(route('employee.attendance.punch')); ?>",
                        type: 'POST',
                        data: {
                            _token: "<?php echo e(csrf_token()); ?>",
                            type: 'out',
                            custom: 1,
                            in_time: result.value.in_time,
                            out_time: result.value.out_time,
                            reason: result.value.reason
                        },
                        success: res => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Attendance submitted for approval',
                                timer: 1800,
                                showConfirmButton: false
                            });
                            setTimeout(() => location.reload(), 1900);
                        },
                        error: xhr => {
                            Swal.fire({
                                icon: 'error',
                                title: xhr.responseJSON?.message || 'Punch out failed'
                            });
                        }
                    });
                },
                error: xhr => {
                    Swal.fire({
                        icon: 'error',
                        title: xhr.responseJSON?.message || 'Punch in failed'
                    });
                }
            });
        }

        // ── Submit helper ──────────────────────────────────────
        function submitPunch(type, data) {
            $.ajax({
                url: "<?php echo e(route('employee.attendance.punch')); ?>",
                type: 'POST',
                data: {
                    _token: "<?php echo e(csrf_token()); ?>",
                    type,
                    ...data
                },
                success: res => {
                    Swal.fire({
                        icon: 'success',
                        title: res.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                    setTimeout(() => location.reload(), 1600);
                },
                error: xhr => {
                    Swal.fire({
                        icon: 'error',
                        title: xhr.responseJSON?.message || 'Something went wrong'
                    });
                    resetBtns(type);
                }
            });
        }

        function resetBtns(type) {
            $('#punchBtn').prop('disabled', false)
                .text(type === 'in' ? 'Punch In' : 'Punch Out');
            $('#customPunchBtn').prop('disabled', false)
                .text(type === 'in' ? 'Custom Punch In' : 'Custom Punch Out');
        }

        // ── Button Bindings ────────────────────────────────────
        $('#punchBtn').click(function() {
            let type = $(this).data('type');
            if (type === 'completed') return;
            handlePunch(type, false);
        });

        $('#customPunchBtn').click(function() {
            let type = $(this).data('type');
            if (type === 'completed') return;
            handlePunch(type, true);
        });

        // Case 4 button — Blade mein add karo:
        // <button id="absentCustomBtn" class="btn btn-outline-danger w-100 mt-2">Mark Attendance (Both Forgot)</button>
        $('#absentCustomBtn').click(function() {
            handleAbsentCustomPunch();
        });

        $(document).ready(function() {
            startTotalHoursTimer();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Varahi\resources\views/admin/employee_dashboard.blade.php ENDPATH**/ ?>