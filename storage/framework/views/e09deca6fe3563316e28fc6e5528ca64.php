<?php $__env->startSection('title', config('app.name') . ' || Edit Roles'); ?>

<?php $__env->startSection('content'); ?>

    <div class="content">

        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Edit Role</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0);"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Roles</li>
                        <li class="breadcrumb-item active">Edit Role & Permissions</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Modify Role & Permissions</h5>
            </div>

            <div class="card-body">

                <form id="updateRoleForm">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="id" value="<?php echo e($role->id); ?>">

                    <div class="row">

                        <div class="col-lg-6">
                            <label class="form-label">Role Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="<?php echo e($role->name); ?>" readonly>
                        </div>

                        <div class="col-lg-12 mt-3">
                            <label class="form-label">Permissions</label>
                            <div class="row">
                                <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-3 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input permissionCheck" type="checkbox"
                                                name="permissions[]" value="<?php echo e($permission->name); ?>"
                                                <?php echo e(in_array($permission->id, $rolePermissions) ? 'checked' : ''); ?>>

                                            <label class="form-check-label">
                                                <?php echo e($permission->name); ?>

                                            </label>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>

                    </div>

                    <div class="text-start mt-3">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Roles')): ?>
                            <a href="<?php echo e(route('admin.roles.list')); ?>" class="btn btn-secondary">Cancel</a>
                        <?php endif; ?>

                        <button type="submit" class="btn btn-primary" id="saveBtn">
                            <span class="btn-text">Update Role</span>
                            <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>

    <script>
        $(document).ready(function() {

            $('#updateRoleForm').on('submit', function(e) {
                e.preventDefault();

                $("#saveBtn").attr('disabled', true);
                $(".spinner-border").removeClass('d-none');

                $.ajax({
                    url: "<?php echo e(route('admin.roles.update')); ?>",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(response) {

                        toastr.success("Role updated successfully");

                        $("#saveBtn").attr('disabled', false);
                        $(".spinner-border").addClass('d-none');

                        setTimeout(() => {
                            window.location.href = "<?php echo e(route('admin.roles.list')); ?>";
                        }, 1000);
                    },
                    error: function(xhr) {
                        let error = xhr.responseJSON.message ?? "Something went wrong!";
                        toastr.error(error);

                        $("#saveBtn").attr('disabled', false);
                        $(".spinner-border").addClass('d-none');
                    }
                });
            });

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Varahi\resources\views/admin/roles/edit.blade.php ENDPATH**/ ?>