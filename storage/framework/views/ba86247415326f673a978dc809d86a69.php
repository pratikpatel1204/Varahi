<?php $__env->startSection('title', config('app.name') . ' || Assign Working Days'); ?>
<?php $__env->startSection('content'); ?>
    <div class="content">
        <div class="card">
            <div class="card-header">
                <h5>Assign Working Days</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="workingDaysTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Designation</th>
                            <th>Working Days</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $designations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($key + 1); ?></td>
                                <td><?php echo e($row->name); ?></td>
                                <td>
                                    <?php $__currentLoopData = $row->workingDays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span class="badge bg-info">
                                            <?php echo e($day->day_name); ?>

                                        </span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary btn-assign" data-id="<?php echo e($row->id); ?>">
                                        Assign
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="assignModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="assignForm">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="designation_id" id="designation_id">
                    <div class="modal-header">
                        <h5>Assign Working Days</h5>
                    </div>
                    <div class="modal-body">
                        <div id="daysBox" class="row">
                            <!-- Checkboxes via JS -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#workingDaysTable').DataTable();
        });

        $(document).on('click', '.btn-assign', function() {

            let id = $(this).data('id');

            $('#designation_id').val(id);

            $('#daysBox').html('');

            $('#assignModal').modal('show');

            $.get("<?php echo e(url('admin/designation-working-days')); ?>/" + id + "/get-days", function(res) {

                let html = '';

                <?php $__currentLoopData = $days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    html += `
                    <div class="col-md-4 mb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="working_days[]" value="<?php echo e($day->id); ?>" ${res.includes(<?php echo e($day->id); ?>) ? 'checked' : ''}>
                            <label class="form-check-label"><?php echo e($day->day_name); ?></label>
                        </div>
                    </div>
                    `;
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                $('#daysBox').html(html);
            });
        });

        $('#assignForm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?php echo e(route('admin.designation-working-days.save-modal')); ?>",
                type: 'POST',
                data: $(this).serialize(),
                success: function(res) {
                    if (res.status) {
                        $('#assignModal').modal('hide');
                        toastr.success('Working days assigned successfully');
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        toastr.error('Something went wrong');
                    }
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Varahi\resources\views/admin/designation_working_days/index.blade.php ENDPATH**/ ?>