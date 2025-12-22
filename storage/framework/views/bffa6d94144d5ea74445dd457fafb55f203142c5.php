
<?php $__env->startPush('styles'); ?>
<!--DataTables Sytles-->


<?php if(isset($export)): ?>
<link href="<?php echo e(asset('plugins/datatables/buttons.dataTables.min.css')); ?>" rel="stylesheet" />
<?php endif; ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<!--DataTables Scripts-->
<script src="<?php echo e(asset('plugins/datatables/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/datatables/dataTables.bootstrap4.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/datatables/dataTables.responsive.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/datatables/responsive.bootstrap4.min.js')); ?>"></script>

<?php if(isset($export)): ?>
<script src="<?php echo e(asset('plugins/datatables/dataTables.buttons.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/datatables/jszip.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/datatables/pdfmake.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/datatables/vfs_fonts.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/datatables/buttons.html5.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/datatables/buttons.print.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/datatables/buttons.colVis.min.js')); ?>"></script>
<?php endif; ?>
<script>
    $.fn.dataTable.ext.errMode = 'none';
</script>
<?php $__env->stopPush(); ?><?php /**PATH C:\xampp\htdocs\pepris-gb-web\resources\views/layouts/dataTablesFiles.blade.php ENDPATH**/ ?>