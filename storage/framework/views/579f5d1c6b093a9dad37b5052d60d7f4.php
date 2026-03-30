<?php $__env->startSection('title', config('app.name') . ' || Permission List'); ?>
<?php $__env->startSection('content'); ?>
<div class="content">

    <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
        <div class="my-auto mb-2">
            <h2 class="mb-1">Permission List</h2>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#"><i class="ti ti-smart-home"></i></a></li>
                    <li class="breadcrumb-item">Permissions</li>
                    <li class="breadcrumb-item active">Permission List</li>
                </ol>
            </nav>
        </div>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Permissions')): ?>
        <div>
            <a href="<?php echo e(route('admin.permissions.create')); ?>" class="btn btn-primary">
                <i class="ti ti-plus"></i> Add Permission
            </a>           
        </div>
        <?php endif; ?>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header"><h4 class="card-title">Permission Table</h4></div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered" id="Permission_List">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Permission Name</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($permission->id); ?></td>
                                        <td><?php echo e($permission->name); ?></td>
                                        <td><?php echo e($permission->created_at->format('d M Y')); ?></td>
                                        <td>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Permissions')): ?>
                                                <a href="<?php echo e(route('admin.permissions.edit', $permission->id)); ?>" class="btn btn-sm btn-info">
                                                    Edit
                                                </a>
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
    </div>
</div>

<script>
$(document).ready(function() {
    $('#Permission_List').DataTable();
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Varahi\resources\views/admin/permissions/list.blade.php ENDPATH**/ ?>