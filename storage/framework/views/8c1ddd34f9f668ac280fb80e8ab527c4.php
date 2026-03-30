<?php $__env->startSection('title', config('app.name') . ' || Dashboard'); ?>
<?php $__env->startSection('content'); ?>
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-1">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0);"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Superadmin</li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- /Breadcrumb -->

        <!-- Welcome Wrap -->
        <div class="welcome-wrap mb-2 p-2">
            <div class=" d-flex align-items-center justify-content-between flex-wrap">
                <h2 class="text-white">Welcome Back, <?php echo e(auth()->user()->name); ?></h2>
            </div>
            <div class="welcome-bg">
                <img src="<?php echo e(asset('admin/img/bg/welcome-bg-02.svg')); ?>" alt="img" class="welcome-bg-01"
                    style="height: 50px;">
                <img src="<?php echo e(asset('admin/img/bg/welcome-bg-03.svg')); ?>" alt="img" class="welcome-bg-02"
                    style="top: -25px;">
                <img src="<?php echo e(asset('admin/img/bg/welcome-bg-01.svg')); ?>" alt="img" class="welcome-bg-03">
            </div>
        </div>
        <!-- /Welcome Wrap -->    
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Varahi\resources\views/admin/admin_dashboard.blade.php ENDPATH**/ ?>