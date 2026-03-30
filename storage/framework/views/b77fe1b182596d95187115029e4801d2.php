<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo e(config('app.name') . ' || Login'); ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo e(asset('admin/img/favicon.png')); ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(asset('admin/img/apple-touch-icon.png')); ?>">

    <link rel="stylesheet" href="<?php echo e(asset('admin/css/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('admin/plugins/icons/feather/feather.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('admin/plugins/tabler-icons/tabler-icons.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('admin/plugins/fontawesome/css/fontawesome.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('admin/plugins/fontawesome/css/all.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('admin/css/style.css')); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

</head>

<body class="bg-white">
    <div id="global-loader" style="display: none;">
        <div class="page-loader"></div>
    </div>
    <div class="main-wrapper">
        <div class="container-fuild">
            <div class="w-100 overflow-hidden position-relative flex-wrap d-block vh-100">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="d-lg-flex align-items-center justify-content-center d-none flex-wrap vh-100 bg-primary-transparent">
                            <div>
                                <img src="<?php echo e(asset('admin/img/bg/authentication-bg-03.svg')); ?>" alt="Img">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-12 col-sm-12">
                        <div class="row justify-content-center align-items-center vh-100 overflow-auto flex-wrap ">
                            <div class="col-md-7 mx-auto vh-100">
                                <form id="adminLoginForm" class="vh-100">
                                    <?php echo csrf_field(); ?>
                                    <div class="vh-100 d-flex flex-column justify-content-between p-4 pb-0">
                                        <div class=" mx-auto mb-3 text-center">
                                            <img src="<?php echo e(asset('admin/img/logo.png')); ?>" class="img-fluid vh-50" alt="Logo" style="height: 150px;">
                                        </div>
                                        <div class="">
                                            <div class="text-center mb-3">
                                                <h2 class="mb-2">Sign In</h2>
                                                <p class="mb-0">Please enter your details to sign in</p>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Email Address</label>
                                                <div class="input-group">
                                                    <input type="email" name="email"
                                                        class="form-control border-end-0">
                                                    <span class="input-group-text border-start-0">
                                                        <i class="ti ti-mail"></i>
                                                    </span>
                                                </div>
                                                <span class="text-danger error-email"></span>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Password</label>
                                                <div class="pass-group">
                                                    <input type="password" name="password"
                                                        class="pass-input form-control">
                                                    <span class="ti toggle-password ti-eye-off"></span>
                                                </div>
                                                <span class="text-danger error-password"></span>
                                            </div>

                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                <div class="form-check form-check-md mb-0">
                                                    <input class="form-check-input" id="remember_me" type="checkbox"
                                                        name="remember">
                                                    <label for="remember_me" class="form-check-label mt-0">Remember
                                                        Me</label>
                                                </div>
                                                <a href="<?php echo e(route('admin.forgot.password')); ?>" class="link-danger">Forgot Password?</a>
                                            </div>

                                            <div class="mb-3">
                                                <button type="submit" class="btn btn-primary w-100" id="loginBtn">
                                                    <span class="btn-text">Sign In</span>
                                                    <span
                                                        class="spinner-border spinner-border-sm d-none btn-spinner"></span>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="mt-3 pb-4 text-center">
                                            <p class="mb-0 text-gray-9">Copyright &copy; <?php echo e(date('Y')); ?> - Varahi</p>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo e(asset('admin/js/jquery-3.7.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/js/feather.min.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/js/script.js')); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function() {

            $("#adminLoginForm").on('submit', function(e) {
                e.preventDefault();

                // Reset errors
                $(".error-email").text("");
                $(".error-password").text("");
                $("input").removeClass("is-invalid");

                let email = $("input[name=email]").val().trim();
                let password = $("input[name=password]").val().trim();
                let hasError = false;

                // Frontend validation
                if (email === "") {
                    $(".error-email").text("Email is required");
                    $("input[name=email]").addClass("is-invalid");
                    hasError = true;
                } else if (!/^\S+@\S+\.\S+$/.test(email)) {
                    $(".error-email").text("Enter a valid email");
                    $("input[name=email]").addClass("is-invalid");
                    hasError = true;
                }

                if (password === "") {
                    $(".error-password").text("Password is required");
                    $("input[name=password]").addClass("is-invalid");
                    hasError = true;
                }

                if (hasError) return; // Stop submit if validation fails

                let formData = $(this).serialize();

                // Button Loader
                $("#loginBtn .btn-text").addClass("d-none");
                $("#loginBtn .btn-spinner").removeClass("d-none");
                $("#loginBtn").prop("disabled", true);

                $.ajax({
                    url: "<?php echo e(route('admin.login.submit')); ?>",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        if (response.status === true) {
                            toastr.success("Login successful!");
                            window.location.href = "<?php echo e(route('admin.dashboard')); ?>";
                        } else {
                            toastr.error(response.message ?? "Something went wrong!");
                        }
                    },
                    error: function(xhr) {

                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;

                            if (errors.email) {
                                $(".error-email").text(errors.email[0]);
                                $("input[name=email]").addClass("is-invalid");
                                toastr.error(errors.email[0]);
                            }
                            if (errors.password) {
                                $(".error-password").text(errors.password[0]);
                                $("input[name=password]").addClass("is-invalid");
                                toastr.error(errors.password[0]);
                            }
                        } else if (xhr.status === 401) {
                            toastr.error("Invalid credentials!");
                        } else {
                            toastr.error("Login failed, try again.");
                        }
                    },
                    complete: function() {
                        $("#loginBtn .btn-text").removeClass("d-none");
                        $("#loginBtn .btn-spinner").addClass("d-none");
                        $("#loginBtn").prop("disabled", false);
                    }
                });
            });

        });
    </script>

</body>

</html>
<?php /**PATH C:\Varahi\resources\views/admin/auth/login.blade.php ENDPATH**/ ?>