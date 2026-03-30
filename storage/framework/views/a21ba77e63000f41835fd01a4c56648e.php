<!-- Header -->
<div class="header">
    <div class="main-header">
        <div class="header-left">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="logo">
                <img src="<?php echo e(asset('admin/img/logo.png')); ?>" alt="Logo" style="height:40px; width:auto;">
            </a>
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="dark-logo">
                <img src="<?php echo e(asset('admin/img/logo-white.png')); ?>" alt="Logo">
            </a>
        </div>
        <a id="mobile_btn" class="mobile_btn" href="#sidebar">
            <span class="bar-icon">
                <span></span>
                <span></span>
                <span></span>
            </span>
        </a>

        <div class="header-user">
            <div class="nav user-menu nav-list">

                <div class="me-auto d-flex align-items-center" id="header-search">
                    <a id="toggle_btn" href="javascript:void(0);" class="btn btn-menubar me-1">
                        <i class="ti ti-arrow-bar-to-left"></i>
                    </a>
                </div>

                <div class="d-flex align-items-center">
                    <div class="me-1">
                        <a href="javascript:void(0);" class="btn btn-menubar btnFullscreen">
                            <i class="ti ti-maximize"></i>
                        </a>
                    </div>                 
                    <div class="dropdown profile-dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle d-flex align-items-center"
                            data-bs-toggle="dropdown">
                            <span class="avatar avatar-sm online">
                                <?php if(auth()->user()->profile_image): ?>
                                    <img src="<?php echo e(asset(auth()->user()->profile_image)); ?>"
                                        class="img-fluid rounded-circle">
                                <?php else: ?>
                                    <i class="ti ti-user fs-16 text-black"></i>
                                <?php endif; ?>
                            </span>
                        </a>
                        <div class="dropdown-menu shadow-none">
                            <div class="card mb-0">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <span class="avatar avatar-lg me-2 avatar-rounded">
                                            <?php if(auth()->user()->profile_image): ?>
                                                <img src="<?php echo e(asset(auth()->user()->profile_image)); ?>" alt="img">                                                
                                            <?php else: ?>
                                                <i class="ti ti-user fs-16 text-black"></i>
                                            <?php endif; ?>
                                        </span>
                                        <div>
                                            <h5 class="mb-0"><?php echo e(auth()->user()->name); ?></h5>
                                            <p class="fs-12 fw-medium mb-0"><?php echo e(auth()->user()->email); ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <a class="dropdown-item d-inline-flex align-items-center p-0 py-2"
                                        href="<?php echo e(route('admin.profile')); ?>">
                                        <i class="ti ti-user-circle me-1"></i>My Profile
                                    </a>
                                    <a class="dropdown-item d-inline-flex align-items-center p-0 py-2" href="<?php echo e(route('admin.logout')); ?>">
                                        <i class="ti ti-login me-2"></i>Logout
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="dropdown mobile-user-menu">
            <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="fa fa-ellipsis-v"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-end">
                <a class="dropdown-item" href="<?php echo e(route('admin.profile')); ?>">My Profile</a>
                <a class="dropdown-item" href="<?php echo e(route('admin.logout')); ?>">Logout</a>
            </div>
        </div>
        <!-- /Mobile Menu -->

    </div>

</div>
<!-- /Header -->
<?php /**PATH C:\Varahi\resources\views/admin/layout/header.blade.php ENDPATH**/ ?>