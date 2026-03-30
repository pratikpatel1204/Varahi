<?php $__env->startSection('content'); ?>
<div class="content">

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">ID Card Templates</h5>
        </div>

        <div class="card-body">

            <?php if(session('success')): ?>
                <div class="alert alert-success"><?php echo e(session('success')); ?></div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Template Name</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($key + 1); ?></td>
                            <td><?php echo e($template->name); ?></td>
                            <td>
                                <?php if($template->is_active): ?>
                                    <span class="badge bg-success">Active</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($template->created_at->format('d M, Y')); ?></td>
                            <td>
                                <a href="<?php echo e(route('admin.id.card.template.edit', $template->id)); ?>"
                                   class="btn btn-sm btn-primary">
                                    <i class="ti ti-edit"></i> Edit
                                </a>


                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="text-center">No templates found.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function () {

    $(document).on('click', '.toggleBtn', function () {
        let id  = $(this).data('id');
        let btn = $(this);

        Swal.fire({
            title: 'Set as Active?',
            text: 'Existing active template will be deactivated.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Set Active',
            cancelButtonText: 'Cancel'
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin/id-card-template/toggle/' + id,
                    type: 'POST',
                    data: { _token: "<?php echo e(csrf_token()); ?>" },
                    success: function () {
                        Swal.fire({
                            icon: 'success',
                            title: 'Done!',
                            text: 'Template set as active.',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(function () {
                            location.reload();
                        });
                    },
                    error: function () {
                        Swal.fire('Error', 'Something went wrong.', 'error');
                    }
                });
            }
        });
    });

});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Varahi\resources\views/admin/id_cards/template_index.blade.php ENDPATH**/ ?>