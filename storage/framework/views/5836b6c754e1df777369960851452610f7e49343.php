<div class="page-header ">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <?php if(@$button['allow']): ?>
                        <a href="<?php echo e($button['link']); ?>" class="btn btn-primary font-weight-bold btn-sm px-4 font-size-base ml-2 float-end"><?php echo e($button['name']); ?></a>
                    <?php endif; ?>
                    <h5 class="m-b-10"><?php echo e($title); ?></h5>
                </div>
                
                
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><i class="feather icon-home"></i></a></li>
                    <?php if(!empty($breadcrumbs)): ?>
                        <?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $breadcrumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(@$breadcrumb['allow']): ?>
                            <li class="breadcrumb-item">
                                <a href="<?php echo e($breadcrumb['link']); ?>"><?php echo e($breadcrumb['name']); ?></a>
                            </li>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                    <li class="breadcrumb-item"><a href="#"><?php echo e($title); ?></a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div><?php /**PATH D:\binslaeem\resources\views/components/breadcrumb.blade.php ENDPATH**/ ?>