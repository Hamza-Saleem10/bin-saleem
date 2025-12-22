<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo e(config('app.name', 'PEPRIS GB')); ?></title>
    <link rel="icon" href="<?php echo e(asset('images/favicon.ico')); ?>" type="image/x-icon">
    

    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public_theme/css/bootstrap.min.css')); ?>">
    
    <link href="<?php echo e(asset('public_theme/css/line-awesome.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('public_theme/css/custom_style.css')); ?>" rel="stylesheet" type="text/css" />
    
    
    <link href="<?php echo e(asset('public_theme/css/google_fonts.css')); ?>" rel="stylesheet" type="text/css" />
    

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>

<body>

    <?php echo e($slot); ?>


    <script src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public_theme/js/bootstrap.bundle.js')); ?>"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
    <script>
        function togglePasswordVisibility(icon) {
            var input = icon.previousElementSibling;

            // Toggle password visibility
            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }

            icon.classList.toggle("la-eye");
            icon.classList.toggle("la-eye-slash");
        }
    </script>

    

</body>

</html>
<?php /**PATH C:\xampp\htdocs\pepris-gb-web\resources\views/layouts/guest.blade.php ENDPATH**/ ?>