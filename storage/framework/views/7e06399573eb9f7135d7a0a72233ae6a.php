
<?php $__env->startSection('title', config('app.name') . ' || Product List'); ?>
<?php $__env->startSection('content'); ?>
    <div class="content">
        <div class="card">
            <div class="card-header d-md-flex justify-content-between align-items-center">
                <h3 class="mb-0">Product List</h3>
                <a href="<?php echo e(route('employee.product.create')); ?>" class="btn btn-primary">
                    <i class="ti ti-plus"></i> Add Product
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="ProductTable">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th>Created By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td>
                                        <?php if($product->image): ?>
                                            <img src="<?php echo e(asset($product->image)); ?>" width="50">
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($product->name); ?></td>
                                    <td><?php echo e($product->category); ?></td>
                                    <td>₹ <?php echo e(number_format($product->price, 2)); ?></td>
                                    <td><?php echo e($product->stock); ?></td>
                                    <td>
                                        <?php if($product->status): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e(optional($product->creator)->name ?? '-'); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('employee.product.edit', $product->id)); ?>"
                                            class="btn btn-sm btn-primary">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#ProductTable').DataTable({
                pageLength: 10,
                ordering: true,
                searching: true,
                responsive: true
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Varahi\resources\views/admin/product/list.blade.php ENDPATH**/ ?>