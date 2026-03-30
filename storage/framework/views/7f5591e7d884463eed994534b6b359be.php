<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="Smarthr - Bootstrap Admin Template">
    <meta name="keywords" content="admin, estimates, bootstrap, business, html5, responsive, Projects">
    <meta name="author" content="Dreams technologies - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title><?php echo $__env->yieldContent('title'); ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo e(asset('admin/img/favicon.png')); ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(asset('admin/img/apple-touch-icon.png')); ?>"> 

    <link rel="stylesheet" href="<?php echo e(asset('admin/css/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('admin/plugins/icons/feather/feather.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('admin/plugins/tabler-icons/tabler-icons.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('admin/plugins/select2/css/select2.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('admin/plugins/fontawesome/css/fontawesome.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('admin/plugins/fontawesome/css/all.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('admin/plugins/summernote/summernote-lite.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('admin/plugins/daterangepicker/daterangepicker.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('admin/plugins/flatpickr/flatpickr.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('admin/plugins/@simonwep/pickr/themes/nano.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('admin/css/style.css')); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="<?php echo e(asset('admin/js/jquery-3.7.1.min.js')); ?>"></script>    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>  
</head>

<body>

    <div id="global-loader">
        <div class="page-loader"></div>
    </div>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <?php echo $__env->make('admin.layout.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('admin.layout.Sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="page-wrapper">
            <?php echo $__env->yieldContent('content'); ?>
            <div class="footer d-sm-flex align-items-center justify-content-between border-top bg-white p-3">
                <p class="mb-0"><?php echo e(date('Y')); ?> &copy; Varahi.</p>
                <p>Designed &amp; Developed By <a href="https://qubetatechnolab.com/" class="text-primary">Qubeta Technolab</a></p>
            </div>
        </div>
    </div>    
    <script src="<?php echo e(asset('admin/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/js/feather.min.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/js/jquery.slimscroll.min.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/plugins/apexchart/apexcharts.min.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/plugins/apexchart/chart-data.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/plugins/chartjs/chart.min.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/plugins/chartjs/chart-data.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/js/moment.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/js/bootstrap-datetimepicker.min.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/plugins/daterangepicker/daterangepicker.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/plugins/summernote/summernote-lite.min.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/plugins/select2/js/select2.min.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/plugins/@simonwep/pickr/pickr.es5.min.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/js/script.js')); ?>"></script>
     <!-- DataTables core -->
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
    
    <!-- Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    
    <!-- Excel dependency -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    
    <!-- Excel button -->
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
</body>

</html>
<?php /**PATH C:\Varahi\resources\views/admin/layout/main-layout.blade.php ENDPATH**/ ?>