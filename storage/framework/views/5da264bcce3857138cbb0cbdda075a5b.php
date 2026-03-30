<?php $__env->startSection('title', config('app.name') . ' || Create Employee'); ?>
<?php $__env->startSection('content'); ?>
    <div class="content">
        <!-- Breadcrumb -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Create Employee</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0);"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Employee</li>
                        <li class="breadcrumb-item active">Create Employee</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- /Breadcrumb -->
        <div class="card">
            <div class="card-body">
                <form id="NewEmployeeForm" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Employee Code <small class="text-danger">*</small></label>
                            <input type="text" name="employee_code" value="<?php echo e(old('employee_code')); ?>"
                                class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Name <small class="text-danger">*</small></label>
                            <input type="text" name="name" value="<?php echo e(old('name')); ?>" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Email <small class="text-danger">*</small></label>
                            <input type="email" name="email" value="<?php echo e(old('email')); ?>" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" name="password" class="form-control" id="password" required>
                                <span class="input-group-text" onclick="togglePassword('password')"><i class="ti ti-eye"
                                        id="passwordIcon"></i></span>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Confirm Password</label>
                            <div class="input-group">
                                <input type="password" name="password_confirmation" class="form-control"
                                    id="password_confirmation" required>
                                <span class="input-group-text" onclick="togglePassword('password_confirmation')">
                                    <i class="ti ti-eye" id="passwordConfirmIcon"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Phone <small class="text-danger">*</small></label>
                            <input type="text" name="phone" value="<?php echo e(old('phone')); ?>" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Gender <small class="text-danger">*</small></label>
                            <select name="gender" class="form-select" required>
                                <option value="">Select</option>
                                <option value="male" <?php echo e(old('gender') == 'male' ? 'selected' : ''); ?>>Male
                                </option>
                                <option value="female" <?php echo e(old('gender') == 'female' ? 'selected' : ''); ?>>
                                    Female
                                </option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">DOB <small class="text-danger">*</small></label>
                            <input type="date" name="dob" value="<?php echo e(old('dob')); ?>" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Designation <small class="text-danger">*</small></label>
                            <select name="designation" id="manager_designation" class="select2" required>
                                <option value="">Select</option>
                                <?php $__currentLoopData = $designations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $des): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($des->name); ?>"
                                        <?php echo e(old('designation') == $des->name ? 'selected' : ''); ?>>
                                        <?php echo e($des->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Reporting Manager</label>
                            <select name="reporting_manager" id="reporting_manager" class="form-select">
                                <option value="">Select Manager</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Department <small class="text-danger">*</small></label>
                            <select name="department_id" class="select2" id="department" required>
                                <option value="">Select</option>
                                <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($dept->id); ?>"
                                        <?php echo e(old('department_id') == $dept->id ? 'selected' : ''); ?>>
                                        <?php echo e($dept->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Sub Department <small class="text-danger">*</small></label>
                            <select name="sub_department_id" id="sub_department" class="select2" required>
                                <option value="">Select Sub Department</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Skill Type <small class="text-danger">*</small></label>
                            <select name="skill_type" class="form-select" id="skill_type" required>
                                <option value="">Select</option>
                                <option value="skilled">Skilled</option>
                                <option value="semi_skilled">Semi Skilled</option>
                                <option value="non_skilled">Non Skilled</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Profile Image</label>
                            <input type="file" name="profile_image" class="form-control">
                        </div>
                        <div class="col-md-4 my-2">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="pf_applicable"
                                    name="pf_applicable" value="1">
                                <label class="form-check-label" for="pf_applicable">
                                    PF Applicable
                                </label>
                            </div>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" role="switch" id="esic_applicable"
                                    name="esic_applicable" value="1">
                                <label class="form-check-label" for="esic_applicable">
                                    ESIC Applicable
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label class="form-label">Address <small class="text-danger">*</small></label>
                            <textarea name="address" class="form-control" rows="2" required><?php echo e(old('address')); ?></textarea>
                        </div>
                    </div>
                    <div class="text-end mt-3">
                        <a href="<?php echo e(route('admin.employees.index')); ?>" class="btn btn-secondary">
                            Back
                        </a>
                        <button type="submit" class="btn btn-primary" id="saveEmployeeBtn">
                            <span class="btn-text">Save Employee</span>
                            <span class="btn-loader d-none">
                                <span class="spinner-border spinner-border-sm"></span> Saving...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#manager_designation').on('change', function() {
                let designationId = $(this).val();
                $('#reporting_manager').html('<option>Loading...</option>');

                if (designationId) {
                    $.ajax({
                        url: "<?php echo e(route('admin.get.reporting.manager', ':id')); ?>".replace(':id',
                            designationId),
                        type: "GET",
                        success: function(data) {
                            let options = '<option value="">Select Manager</option>';
                            $.each(data, function(key, manager) {
                                options +=
                                    `<option value="${manager.id}">${manager.name}</option>`;
                            });
                            $('#reporting_manager').html(options);
                        },
                        error: function() {
                            $('#reporting_manager').html(
                                '<option value="">Error loading managers</option>');
                        }
                    });
                } else {
                    $('#reporting_manager').html('<option value="">Select Manager</option>');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {

            $("#NewEmployeeForm").submit(function(e) {
                e.preventDefault();

                let form = this;
                let formData = new FormData(form);
                let btn = $("#saveEmployeeBtn");

                $(".error-text").remove();
                $(".is-invalid").removeClass("is-invalid");

                // START LOADER
                btn.prop("disabled", true);
                btn.find(".btn-text").addClass("d-none");
                btn.find(".btn-loader").removeClass("d-none");

                $.ajax({

                    url: "<?php echo e(route('admin.employees.store')); ?>",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status) {
                            toastr.success(response.message);
                            setTimeout(function() {
                                window.location.href =
                                    "<?php echo e(route('admin.employees.index')); ?>";
                            }, 1500);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(field, message) {
                                let input = $("[name='" + field + "']");
                                input.addClass("is-invalid");
                                input.after('<span class="text-danger error-text">' +
                                    message[0] + '</span>');
                            });
                            toastr.error("Please fix validation errors");
                        }
                        if (xhr.status === 500) {
                            toastr.error(xhr.responseJSON.message);
                        }
                    },
                    complete: function() {
                        btn.prop("disabled", false);
                        btn.find(".btn-text").removeClass("d-none");
                        btn.find(".btn-loader").addClass("d-none");

                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#department').on('change', function() {
                let deptId = $(this).val();
                $('#sub_department').html('<option>Loading...</option>');
                if (deptId) {
                    $.ajax({
                        url: "<?php echo e(route('admin.get.subdepartments', ':id')); ?>".replace(':id',
                            deptId),
                        type: "GET",
                        success: function(data) {
                            let options = '<option value="">Select Sub Department</option>';
                            $.each(data, function(key, item) {
                                options += '<option value="' + item.id + '">' + item
                                    .name + '</option>';
                            });
                            $('#sub_department').html(options);
                        },
                        error: function() {
                            $('#sub_department').html(
                                '<option value="">Error loading data</option>');
                        }
                    });
                } else {
                    $('#sub_department').html('<option value="">Select Sub Department</option>');
                }
            });
        });

        function togglePassword(fieldId) {
            const input = document.getElementById(fieldId);
            const icon = fieldId === 'password' ?
                document.getElementById('passwordIcon') :
                document.getElementById('passwordConfirmIcon');

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("ti-eye");
                icon.classList.add("ti-eye-off");
            } else {
                input.type = "password";
                icon.classList.remove("ti-eye-off");
                icon.classList.add("ti-eye");
            }
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Varahi\resources\views/admin/employees/create.blade.php ENDPATH**/ ?>