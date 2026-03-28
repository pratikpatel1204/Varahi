
<?php $__env->startSection('title', config('app.name') . ' || Create Product'); ?>
<?php $__env->startSection('content'); ?>
    <div class="content">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Create Product</h3>
                <a href="<?php echo e(route('employee.product.list')); ?>" class="btn btn-secondary btn-sm">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>

            <div class="card-body">
                <form id="productForm" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Product Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control">
                            <small class="text-danger error-name"></small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category <span class="text-danger">*</span></label>
                            <select name="category" class="form-select">
                                <option value="">Select Category</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($cat->name); ?>"><?php echo e($cat->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <small class="text-danger error-category"></small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Price <span class="text-danger">*</span></label>
                            <input type="number" name="price" class="form-control">
                            <small class="text-danger error-price"></small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stock <span class="text-danger">*</span></label>
                            <input type="number" name="stock" class="form-control">
                            <small class="text-danger error-stock"></small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Product Image</label>
                            <input type="file" name="image" class="form-control">
                            <small class="text-danger error-image"></small>
                        </div>
                        <div class="col-md-6 mb-3 d-flex align-items-center">
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" role="switch" id="status" name="status"
                                    value="1" checked>

                                <label class="form-check-label" for="status" id="statusLabel">
                                    Active
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="button" id="submitProductBtn" class="btn btn-success">
                            <span class="btn-text">
                                <i class="fa fa-save"></i> Save Product
                            </span>
                            <span class="spinner-border spinner-border-sm d-none btn-loader"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            $('#status').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#statusLabel').text('Active');
                } else {
                    $('#statusLabel').text('Inactive');
                }
            });

        });
    </script>
    <script>
        $(document).ready(function() {

            $('#submitProductBtn').click(function() {

                let btn = $(this);
                let loader = btn.find('.btn-loader');
                let text = btn.find('.btn-text');

                // ✅ RESET ONLY ERROR MESSAGES
                $('[class^="error-"]').text('');
                $('.form-control').removeClass('is-invalid');

                let formData = new FormData($('#productForm')[0]);

                // LOADER START
                btn.prop('disabled', true);
                loader.removeClass('d-none');
                text.addClass('d-none');

                $.ajax({
                    url: "<?php echo e(route('employee.product.store')); ?>",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,

                    success: function(response) {

                        btn.prop('disabled', false);
                        loader.addClass('d-none');
                        text.removeClass('d-none');

                        if (response.status) {

                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                            }).then(() => {

                                // ✅ RESET FORM AFTER SUCCESS
                                $('#productForm')[0].reset();

                                // ✅ REDIRECT
                                window.location.href =
                                    "<?php echo e(route('employee.product.list')); ?>";
                            });

                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },

                    error: function(xhr) {

                        btn.prop('disabled', false);
                        loader.addClass('d-none');
                        text.removeClass('d-none');

                        if (xhr.status === 422) {

                            let errors = xhr.responseJSON.errors;

                            $.each(errors, function(key, value) {

                                $('.error-' + key).text(value[0]);

                                // ✅ ADD RED BORDER
                                $('[name="' + key + '"]').addClass('is-invalid');
                            });

                        } else {
                            Swal.fire('Error', 'Something went wrong', 'error');
                        }
                    }
                });

            });

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Varahi\resources\views/admin/product/create.blade.php ENDPATH**/ ?>