
<?php $__env->startSection('title', config('app.name') . ' || Holiday'); ?>
<?php $__env->startSection('content'); ?>
    <div class="content">
        <div class="card">
            <div class="card-header d-md-flex justify-content-between align-items-center">
                <h5 class="mb-0">Holiday Master</h5>
                <a href="#" data-bs-toggle="modal" data-bs-target="#add_holiday" class="btn btn-primary">
                    <i class="ti ti-plus"></i> Add Holiday
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="holidaytable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Year</th>
                                <th>Title</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th width="120">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $holidays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr id="row_<?php echo e($row->id); ?>">
                                    <td><?php echo e($k + 1); ?></td>
                                    <td><?php echo e($row->year->year ?? '-'); ?></td>
                                    <td><?php echo e($row->title); ?></td>
                                    <td><?php echo e(date('d-m-Y', strtotime($row->from_date))); ?></td>
                                    <td><?php echo e(date('d-m-Y', strtotime($row->to_date))); ?></td>
                                    <td>
                                        <?php if($row->type == 'Full'): ?>
                                            <span class="badge bg-success">Full</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning">Half</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($row->status == 'Active'): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-primary btn-edit" data-bs-toggle="modal"
                                            data-bs-target="#edit_holiday" data-id="<?php echo e($row->id); ?>"
                                            data-year="<?php echo e($row->year_id); ?>" data-title="<?php echo e($row->title); ?>"
                                            data-from="<?php echo e($row->from_date); ?>" data-to="<?php echo e($row->to_date); ?>"
                                            data-type="<?php echo e($row->type); ?>" data-status="<?php echo e($row->status); ?>">
                                            <i class="ti ti-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger btn-delete" data-id="<?php echo e($row->id); ?>">
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

    <div class="modal fade" id="add_holiday">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form id="addHolidayForm">
                    <?php echo csrf_field(); ?>
                    <div class="modal-header">
                        <h5>Add Holiday</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Year</label>
                                <select name="year_id" class="form-select select2">
                                    <option value="">Select Year</option>
                                    <?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($y->id); ?>"><?php echo e($y->year); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Holiday Title</label>
                                <input type="text" name="title" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>From Date</label>
                                <input type="date" name="from_date" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>To Date</label>
                                <input type="date" name="to_date" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Holiday Type</label>
                                <select name="type" class="form-select">
                                    <option value="Full">Full Day</option>
                                    <option value="Half">Half Day</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Status</label>
                                <select name="status" class="form-select">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
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

    <div class="modal fade" id="edit_holiday">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form id="updateHolidayForm">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="id" id="edit_id">
                    <div class="modal-header">
                        <h5>Edit Holiday</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Year</label>
                                <select name="year_id" id="edit_year" class="form-select select2-edit">
                                    <?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($y->id); ?>"><?php echo e($y->year); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Holiday Title</label>
                                <input type="text" name="title" id="edit_title" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>From Date</label>
                                <input type="date" name="from_date" id="edit_from" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>To Date</label>
                                <input type="date" name="to_date" id="edit_to" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Holiday Type</label>
                                <select name="type" id="edit_type" class="form-select">
                                    <option value="Full">Full Day</option>
                                    <option value="Half">Half Day</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Status</label>
                                <select name="status" id="edit_status" class="form-select">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button class="btn btn-primary">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#holidaytable').DataTable({
                pageLength: 10,
                ordering: true,
                searching: true,
                responsive: true
            });
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            }
        });

        $(document).on('click', '.btn-edit', function() {

            $('#edit_id').val($(this).data('id'));
            $('#edit_title').val($(this).data('title'));
            $('#edit_from').val($(this).data('from'));
            $('#edit_to').val($(this).data('to'));

            $('#edit_year').val($(this).data('year')).trigger('change');
            $('#edit_type').val($(this).data('type'));
            $('#edit_status').val($(this).data('status'));

        });


        $('#addHolidayForm').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: "<?php echo e(route('admin.holidays.store')); ?>",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    toastr.success(res.message);
                    $('#add_holiday').modal('hide');
                    setTimeout(() => {
                        location.reload();
                    }, 700);
                },
                error: function(xhr) {
                    if (xhr.status == 422) {
                        $.each(xhr.responseJSON.errors, function(k, v) {
                            toastr.error(v[0]);
                        });
                    }
                }
            });
        });

        $('#updateHolidayForm').submit(function(e) {
            e.preventDefault();

            let formData = new FormData(this);

            $.ajax({
                url: "<?php echo e(route('admin.holidays.update')); ?>",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    toastr.success(res.message);
                    $('#edit_holiday').modal('hide');
                    setTimeout(() => {
                        location.reload();
                    }, 700);
                },
                error: function(xhr) {
                    if (xhr.status == 422) {
                        $.each(xhr.responseJSON.errors, function(k, v) {
                            toastr.error(v[0]);
                        });
                    }
                }
            });
        });

        $('.btn-delete').click(function() {
            let id = $(this).data('id');
            Swal.fire({
                title: 'Delete Holiday?',
                text: 'This action cannot be undone',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Yes Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/admin/holidays/delete/' + id,
                        method: 'GET',
                        success: function(res) {
                            $('#row_' + id).remove();
                            toastr.success(res.message);
                        },
                        error: function() {
                            toastr.error('Something went wrong');
                        }
                    });
                }
            });
        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Varahi\resources\views/admin/holidays/index.blade.php ENDPATH**/ ?>