<div class="dt-responsive table-responsive">
    <table id="<?php echo e($datatable_class); ?>" class="table nowrap datatable <?php echo e($datatable_class); ?>">
        <thead>
            <tr>
                <?php $__empty_1 = true; $__currentLoopData = $keys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <th><?php echo e($key); ?></th>    
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div><?php /**PATH D:\binslaeem\resources\views/components/table.blade.php ENDPATH**/ ?>