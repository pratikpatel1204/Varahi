<?php $__env->startSection('title', config('app.name') . ' || Working Days'); ?>
<?php $__env->startSection('content'); ?>
    <div class="content">
        <div class="card">
            <div class="card-header d-md-flex justify-content-between align-items-center">
                <h3 class="mb-0">Working Days List</h3>
                <button class="btn btn-primary" id="btnAdd">
                    <i class="ti ti-circle-plus me-2"></i> Add Day
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="WorkingTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Day Name</th>
                                <th>Status</th>
                                <th width="120">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr id="row_<?php echo e($row->id); ?>">
                                    <td><?php echo e($key + 1); ?></td>
                                    <td><?php echo e($row->day_name); ?></td>
                                    <td>
                                        <?php if($row->is_working): ?>
                                            <span class="badge bg-success">Working</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Holiday</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-success btnEdit" data-id="<?php echo e($row->id); ?>"
                                            data-name="<?php echo e($row->day_name); ?>" data-status="<?php echo e($row->is_working); ?>">
                                            <i class="ti ti-edit"></i>
                                        </button>
                                        <button class="btn-delete btn btn-sm btn-secondary" data-id="<?php echo e($row->id); ?>">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="dayModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="dayForm">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="id" id="id">
                    <div class="modal-header">
                        <h5 id="modalTitle">Add Working Day</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Day Name</label>
                            <input type="text" name="day_name" id="day_name" class="form-control">
                            <span class="text-danger error-text day_name_error"></span>
                        </div>
                        <div class="mb-3">
                            <label>Status</label>
                            <select name="is_working" id="is_working" class="form-select">
                                <option value="1">Working</option>
                                <option value="0">Holiday</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button class="btn btn-primary">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#WorkingTable').DataTable();

            let modal = new bootstrap.Modal(document.getElementById('dayModal'));

            $('#btnAdd').click(function() {
                $('#dayForm')[0].reset();
                $('#id').val('');
                $('#modalTitle').text('Add Working Day');
                $('.error-text').text('');
                modal.show();
            });

            $('.btnEdit').click(function() {
                $('#modalTitle').text('Edit Working Day');
                $('#id').val($(this).data('id'));
                $('#day_name').val($(this).data('name'));
                $('#is_working').val($(this).data('status'));
                $('.error-text').text('');
                modal.show();
            });

            $('#dayForm').submit(function(e) {
                e.preventDefault();

                let id = $('#id').val();
                let url = id ?
                    "<?php echo e(route('admin.working.days.update')); ?>" :
                    "<?php echo e(route('admin.working.days.store')); ?>";

                $.ajax({
                    url: url,
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(res) {
                        toastr.success(res.message ?? 'Saved Successfully');
                        modal.hide();
                        setTimeout(() => {
                            location.reload();
                        }, 700);
                    },
                    error: function(err) {
                        if (err.status == 422) {
                            let errors = err.responseJSON.errors;
                            $.each(errors, function(key, val) {
                                $('.' + key + '_error').text(val[0]);
                            });
                        }
                    }
                });
            });

            $(document).on('click', '.btn-delete', function() {

                let id = $(this).data('id');
                Swal.fire({
                    title: 'Delete?',
                    text: "Working Day will be removed",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "<?php echo e(url('admin/working-days/delete')); ?>/" + id,
                            type: "DELETE",
                            data: {
                                _token: "<?php echo e(csrf_token()); ?>"
                            },
                            success: function(res) {
                                $('#row_' + id).remove();
                                toastr.success(res.message ?? 'Deleted Successfully');
                            }
                        });
                    }
                });
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Varahi\resources\views/admin/working_days/index.blade.php ENDPATH**/ ?>