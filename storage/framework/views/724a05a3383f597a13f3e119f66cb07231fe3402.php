<script src="<?php echo e(asset('plugins/toastr/toastr.min.js')); ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('plugins/toastr/toastr.min.css')); ?>">


<script>


  <?php if(Session::has('success')): ?>
    toastr.remove();
    toastr.success("<?php echo e(Session::get('success')); ?>", '', {
        closeButton: true,
        timeOut: 20000,
        progressBar: true,
        newestOnTop: true
    }); 

    //toastr.success("<?php echo e(Session::get('success')); ?>");
  <?php endif; ?>


  <?php if(Session::has('info')): ?>
    toastr.info("<?php echo e(Session::get('info')); ?>", '', {
        closeButton: true,
        timeOut: 20000,
        progressBar: true,
        newestOnTop: true
    });
  <?php endif; ?>


  <?php if(Session::has('warning')): ?>
    toastr.warning("<?php echo e(Session::get('warning')); ?>", '', {
        closeButton: true,
        timeOut: 20000,
        progressBar: true,
        newestOnTop: true
    });
  <?php endif; ?>


  <?php if(Session::has('error')): ?>
    toastr.error("<?php echo e(Session::get('error')); ?>", '', {
        closeButton: true,
        timeOut: 20000,
        progressBar: true,
        newestOnTop: true
    });
  <?php endif; ?>


</script><?php /**PATH C:\xampp\htdocs\pepris-gb-web\resources\views/layouts/notification.blade.php ENDPATH**/ ?>