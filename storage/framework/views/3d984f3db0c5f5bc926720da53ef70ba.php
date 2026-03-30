<?php $__env->startSection('title', config('app.name') . ' || Product Inquiry'); ?>
<?php $__env->startSection('content'); ?>
    <div class="content">
        <div class="card">
            <div class="card-header d-md-flex justify-content-between align-items-center">
                <h3 class="mb-0">Product Inquiry</h3>
                <a href="<?php echo e(route('employee.inquiry.list')); ?>" class="btn btn-primary">
                    <i class="ti ti-plus"></i> Add Inquiry
                </a>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Varahi\resources\views/admin/inquiry/list.blade.php ENDPATH**/ ?>