
<?php $__env->startSection('title', config('app.name') . ' || Attendance Change'); ?>

<?php $__env->startSection('content'); ?>

    <style>
        .big-checkbox {
            transform: scale(1.4);
            cursor: pointer;
        }
    </style>

    <div class="content">
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    Attendance Change - <?php echo e($user->name); ?> (<?php echo e($month); ?> <?php echo e($year); ?>)
                </h5>
                <a href="<?php echo e(route('admin.salary.attendance.preview', ['year' => $year, 'month' => $month])); ?>"
                    class="btn btn-secondary btn-sm">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
                <button id="markPresent" class="btn btn-success btn-sm">Mark Present</button>
            </div>

            <div class="card-body">
                <form id="attendanceForm">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="id" value="<?php echo e($user->id); ?>">
                    <input type="hidden" name="year" value="<?php echo e($year); ?>">
                    <input type="hidden" name="month" value="<?php echo e($month); ?>">
                    
                    <div class="row gap-2">
                        <?php
                            $firstDay = \Carbon\Carbon::create($year, date('m', strtotime($month)), 1);
                            $lastDay = $firstDay->copy()->endOfMonth();
                            $dayOfWeek = $firstDay->dayOfWeek;
                            $dayCounter = 1;
                        ?>

                        
                        <?php for($i = 0; $i < $dayOfWeek; $i++): ?>
                            <div class="col-1"></div>
                        <?php endfor; ?>

                        <?php while($dayCounter <= $lastDay->day): ?>
                            <?php
                                $dateStr = $firstDay->copy()->format('Y-m-d');
                                $today = \Carbon\Carbon::today();
                                $dayName = $firstDay->format('D');

                                $status = '-';
                                $borderClass = 'border-secondary';

                                foreach ($events ?? [] as $event) {
                                    if ($event['start'] == $dateStr) {
                                        $status = $event['title'] ?: '-';
                                        switch ($status) {
                                            case 'P':
                                                $borderClass = 'border-success';
                                                break;
                                            case 'A':
                                                $borderClass = 'border-danger';
                                                break;
                                            case 'AP':
                                                $borderClass = 'border-warning';
                                                break;
                                            case 'L':
                                                $borderClass = 'border-info';
                                                break;
                                        }
                                    }
                                }

                                $isFuture = \Carbon\Carbon::parse($dateStr)->gte($today);
                                $isSunday = $dayName === 'Sun';

                                $badgeClass = 'bg-secondary';
                                switch ($status) {
                                    case 'P':
                                        $badgeClass = 'bg-success';
                                        break;
                                    case 'A':
                                        $badgeClass = 'bg-danger';
                                        break;
                                    case 'AP':
                                        $badgeClass = 'bg-warning text-dark';
                                        break;
                                    case 'L':
                                        $badgeClass = 'bg-info';
                                        break;
                                }
                            ?>

                            <div class="col-1 bg-gray border border-secondary rounded p-2" style="height:100px;">
                                <h6 class="text-center text-muted"><?php echo e($dayName); ?></h6>
                                <h4 class="fw-bold text-center"><?php echo e($dayCounter); ?></h4>
                                <div class="d-flex justify-content-between align-items-center mt-1">
                                    <?php if(!$isSunday): ?>
                                        <span class="badge <?php echo e($badgeClass); ?>"><?php echo e($status); ?></span>

                                        <input class="form-check-input big-checkbox" type="checkbox" name="dates[]"
                                            value="<?php echo e($dateStr); ?>" <?php echo e($isFuture ? 'disabled' : ''); ?>

                                            <?php echo e($status != 'L' && !$isFuture ? 'checked' : ''); ?>>
                                    <?php endif; ?>
                                </div>

                            </div>

                            <?php
                                $dayCounter++;
                                $firstDay->addDay();
                            ?>
                        <?php endwhile; ?>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('markPresent').addEventListener('click', function(e) {
            e.preventDefault();

            let checked = document.querySelectorAll('input[name="dates[]"]:checked:not(:disabled)');

            if (checked.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Select at least one date'
                });
                return;
            }

            let formData = new FormData(document.getElementById('attendanceForm'));

            fetch("<?php echo e(route('admin.salary.attendance.update')); ?>", {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': "<?php echo e(csrf_token()); ?>"
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    Swal.fire({
                        icon: 'success',
                        title: data.message || 'Updated successfully'
                    }).then(() => location.reload());
                })
                .catch(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Something went wrong'
                    });
                });
        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Varahi\resources\views/admin/salary/attendance_change.blade.php ENDPATH**/ ?>