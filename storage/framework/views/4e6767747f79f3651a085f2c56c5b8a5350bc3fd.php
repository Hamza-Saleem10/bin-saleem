<div class="status-modal-content">
    <div class="text-center mb-3">
        <h6 class="text-muted">Application No: <?php echo e($application->id ?? $institution->id ?? 'N/A'); ?></h6>
        <?php if(isset($application)): ?>
            <p class="text-muted small">Current Status: <span class="fw-bold"><?php echo e($application->status); ?></span></p>
        <?php endif; ?>
    </div>
    
    <div class="application-status-tracking">
        <?php $__currentLoopData = $stages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $status = $stageStatuses[$stage] ?? 'Pending';
            ?>
            
            <div class="status-step bg-light border rounded p-3 mb-2 
                <?php echo e($status === 'Completed' || $status === 'Approved' || str_contains($status, 'Forwarded to') ? 'border-success bg-success-subtle' : ''); ?>

                <?php echo e(str_contains($status, 'Rejected') ? 'border-danger bg-danger-subtle' : ''); ?>

                <?php echo e($status === 'Pending' ? 'border-warning bg-warning-subtle' : ''); ?>

                <?php echo e($status === 'N/A' ? 'border-secondary bg-light' : ''); ?>">
                
                <div class="d-flex justify-content-between align-items-center">
                    <div class="status-title fw-semibold small text-dark 
                        <?php echo e($status === 'Completed' || $status === 'Approved' || str_contains($status, 'Forwarded to') ? 'text-success' : ''); ?>

                        <?php echo e(str_contains($status, 'Rejected') ? 'text-danger' : ''); ?>

                        <?php echo e($status === 'Pending' ? 'text-warning' : ''); ?>

                        <?php echo e($status === 'N/A' ? 'text-muted' : ''); ?>">
                        <?php echo e($stage); ?>

                    </div>
                    <div class="status-badge">
                        <?php if($status === 'Completed' || $status === 'Approved'): ?>
                            <span class="badge bg-success rounded-pill px-3 py-1"><?php echo e($status); ?></span>
                        <?php elseif(str_contains($status, 'Forwarded to')): ?>
                            <span class="badge bg-primary rounded-pill px-3 py-1"><?php echo e($status); ?></span>
                        <?php elseif(str_contains($status, 'Rejected')): ?>
                            <span class="badge bg-danger rounded-pill px-3 py-1"><?php echo e($status); ?></span>
                        <?php elseif($status === 'Pending'): ?>
                            <span class="badge bg-warning rounded-pill px-3 py-1">Pending</span>
                        <?php elseif($status === 'N/A'): ?>
                            <span class="badge bg-secondary rounded-pill px-3 py-1">N/A</span>
                        <?php else: ?>
                            <span class="badge bg-secondary rounded-pill px-3 py-1"><?php echo e($status); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <?php if(!$loop->last): ?>
                <?php
                    $connectorClass = 'border-secondary';
                    if ($status === 'Completed' || $status === 'Approved' || str_contains($status, 'Forwarded to')) {
                        $connectorClass = 'border-success';
                    } elseif (str_contains($status, 'Rejected')) {
                        $connectorClass = 'border-danger';
                    } elseif ($status === 'Pending') {
                        $connectorClass = 'border-warning';
                    } elseif ($status === 'N/A') {
                        $connectorClass = 'border-secondary';
                    }
                ?>
                
                <div class="status-connector d-flex justify-content-center my-1">
                    <div class="connector-line border-start border-2 h-4 <?php echo e($connectorClass); ?>"></div>
                </div>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div><?php /**PATH C:\xampp\htdocs\pepris-gb-web\resources\views/institutions/partials/status-modal-content.blade.php ENDPATH**/ ?>