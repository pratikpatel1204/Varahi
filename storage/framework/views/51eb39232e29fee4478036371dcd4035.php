<?php $__env->startSection('title', config('app.name') . ' || Monthly Working Days'); ?>
<?php $__env->startSection('content'); ?>
    <div class="content">
        <div class="container-fluid mt-4">
            <h4 class="mb-4">Monthly Working Days Entry</h4>

            
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            
            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            
            <?php if($errors->any()): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('admin.monthly_working.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="row g-3">
                    <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-3 col-sm-6">
                            <div class="card shadow-sm border-0 mb-3">
                                <div class="card-body p-3 text-center">
                                    <h6 class="card-title mb-3"><?php echo e($month->month_name); ?></h6>
                                    <input type="number" min="0" max="31"
                                        name="working_days[<?php echo e($month->id); ?>]" class="form-control text-center"
                                        placeholder="Enter total days" value="<?php echo e($workingDays[$month->id] ?? ''); ?>">
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-primary px-4">Save</button>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Varahi\resources\views/admin/month_working_days.blade.php ENDPATH**/ ?>