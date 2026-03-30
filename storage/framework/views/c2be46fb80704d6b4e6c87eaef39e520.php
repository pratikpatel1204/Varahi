<div class="d-flex justify-content-between mb-2">
    <h6>Employee ID: <?php echo e($empid); ?></h6>

    <a href="<?php echo e(route('admin.employees.create.salary', $empid)); ?>" class="btn btn-sm btn-success">
        + Add Salary
    </a>
</div>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Employee</th>
            <th>Year</th>
            <th>Salary Basis</th>
            <th>Payment Type</th>
            <th>Amount</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $salaries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $salary): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($salary->employee->name ?? '-'); ?></td>
                <td><?php echo e($salary->year ?? '-'); ?></td>
                <td><?php echo e($salary->salary_basis); ?></td>
                <td><?php echo e($salary->payment_type); ?></td>
                <td><?php echo e($salary->salary_amount); ?></td>
                <td>
                    <a href="<?php echo e(route('admin.employees.edit.salary', $salary->id)); ?>" class="btn btn-sm btn-primary">
                        Edit
                    </a>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="6" class="text-center">No Data Found</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<?php /**PATH C:\Varahi\resources\views/admin/employees/emp_salary_details.blade.php ENDPATH**/ ?>