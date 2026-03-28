<?php $__env->startSection('title', config('app.name') . ' || Employee'); ?>
<?php $__env->startSection('content'); ?>
    <div class="content">
        <div class="row">
            <div class="col-lg-3 col-md-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center overflow-hidden">
                            <div>
                                <span class="avatar avatar-lg bg-dark rounded-circle">
                                    <i class="ti ti-users"></i>
                                </span>
                            </div>
                            <div class="ms-2 overflow-hidden">
                                <p class="fs-12 fw-medium mb-1 text-truncate">Total Employee</p>
                                <h4><?php echo e($totalEmployees); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center overflow-hidden">
                            <div>
                                <span class="avatar avatar-lg bg-success rounded-circle">
                                    <i class="ti ti-user-share"></i>
                                </span>
                            </div>
                            <div class="ms-2 overflow-hidden">
                                <p class="fs-12 fw-medium mb-1 text-truncate">Active</p>
                                <h4><?php echo e($activeEmployees); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center overflow-hidden">
                            <div>
                                <span class="avatar avatar-lg bg-danger rounded-circle">
                                    <i class="ti ti-user-pause"></i>
                                </span>
                            </div>
                            <div class="ms-2 overflow-hidden">
                                <p class="fs-12 fw-medium mb-1 text-truncate">InActive</p>
                                <h4><?php echo e($inactiveEmployees); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center overflow-hidden">
                            <div>
                                <span class="avatar avatar-lg bg-info rounded-circle">
                                    <i class="ti ti-user-plus"></i>
                                </span>
                            </div>
                            <div class="ms-2 overflow-hidden">
                                <p class="fs-12 fw-medium mb-1 text-truncate">New Joiners</p>
                                <h4><?php echo e($newJoiners); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                <h5>Employee List</h5>
                <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
                    <div class="mb-2">
                        <a href="<?php echo e(route('admin.employees.create')); ?>" class="btn btn-primary d-flex align-items-center">
                            <i class="ti ti-circle-plus me-2"></i>Add Employee
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered w-100" id="employeeTable">
                        <thead class="thead-light">
                            <tr>
                                <th>S.No</th>
                                <th>Action</th>
                                <th>Emp ID</th>
                                <th>Designation</th>
                                <th>Department</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>DOB</th>
                                <th>Address</th>
                                <th>Gender</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr id="row_<?php echo e($row->id); ?>">
                                    <td><?php echo e($key + 1); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('admin.employees.edit', $row->id)); ?>"
                                            class="btn btn-sm btn-success">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <a href="javascript:void(0)" class="btn btn-sm btn-danger btn-delete"
                                            data-id="<?php echo e($row->id); ?>">
                                            <i class="ti ti-trash"></i>
                                        </a>
                                        <button class="btn btn-sm btn-info btn-salary" data-id="<?php echo e($row->id); ?>">
                                            <i class="ti ti-currency-rupee"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('admin.employees.view', $row->id)); ?>" class="text-warning">
                                            <strong><?php echo e($row->employee_code); ?></strong>
                                        </a>
                                    </td>
                                    <td><?php echo e($row->role ?? '-'); ?></td>
                                    <td><?php echo e($row->department->name ?? '-'); ?></td>
                                    <td><?php echo e($row->name); ?></td>
                                    <td><?php echo e($row->email); ?></td>
                                    <td><?php echo e($row->phone); ?></td>
                                    <td><?php echo e($row->dob); ?></td>
                                    <td><?php echo e($row->address); ?></td>
                                    <td><?php echo e(ucfirst($row->gender)); ?></td>
                                    <td>
                                        <?php if($row->status): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="salaryModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Salary Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="salaryTableView">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).on('click', '.btn-salary', function() {

            let empId = $(this).data('id');

            $('#salaryModal').modal('show');
            $('#salaryTableView').html('<div class="text-center">Loading...</div>');

            $.ajax({
                url: "<?php echo e(route('admin.get.employees.salary')); ?>",
                type: "GET",
                data: {
                    id: empId
                },
                success: function(response) {
                    $('#salaryTableView').html(response.html);
                },
                error: function() {
                    $('#salaryTableView').html(
                        '<div class="text-danger text-center">Error loading data</div>');
                }
            });

        });
        $(document).ready(function() {
            $('#employeeTable').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'csv',
                    text: 'Export CSV',
                    className: 'btn btn-info'
                }, ]
            });
        });

        $(document).on('click', '.btn-delete', function() {
            let id = $(this).data('id');
            Swal.fire({
                title: "Are you sure?",
                text: "Employee will be deleted!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                confirmButtonText: "Yes, Delete"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/admin/employees/delete/" + id,
                        type: "POST",
                        data: {
                            _token: "<?php echo e(csrf_token()); ?>"
                        },
                        success: function(response) {
                            $('#row_' + id).remove();
                            Swal.fire(
                                "Deleted!",
                                response.message,
                                "success"
                            );
                        },
                        error: function() {
                            Swal.fire(
                                "Error!",
                                "Something went wrong.",
                                "error"
                            );
                        }
                    });
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Varahi\resources\views/admin/employees/index.blade.php ENDPATH**/ ?>