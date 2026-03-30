<?php $__env->startSection('title', config('app.name') . ' || Roles List'); ?>
<?php $__env->startSection('content'); ?>
<div class="content">

    <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
        <div class="my-auto mb-2">
            <h2 class="mb-1">Roles List</h2>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);"><i class="ti ti-smart-home"></i></a>
                    </li>
                    <li class="breadcrumb-item">Roles</li>
                    <li class="breadcrumb-item active" aria-current="page">Role List</li>
                </ol>
            </nav>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Role List</h4>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered" id="rolesTable">
                            <thead>
                                <tr>
                                    <th style="width: 20%;">Role Name</th>
                                    <th style="width: 80%;">Permissions</th>
                                    <th style="width: 20%;">Action</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e(ucfirst($role->name)); ?></td>
                                    <td>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Roles')): ?>
                                        <a href="<?php echo e(route('admin.roles.edit', $role->id)); ?>" class="btn btn-sm btn-info">Edit</a>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php $__currentLoopData = $role->permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $perm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="badge bg-success m-1"><?php echo e($perm->name); ?></span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
    $('#rolesTable').DataTable();
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Varahi\resources\views/admin/roles/list.blade.php ENDPATH**/ ?>