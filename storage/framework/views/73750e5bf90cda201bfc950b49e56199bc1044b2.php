<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

    <head>

        <title><?php echo e(config('app.name', 'Laravel')); ?></title>
        <!-- HTML5 Shim and Respond.js IE11 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 11]>
                <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
                <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
                <![endif]-->
        <!-- Meta -->

        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="description" content="" />
        <meta name="keywords" content="">
        <meta name="author" content="Codedthemes" />
        <!-- Favicon icon -->
        <link rel="icon" href="<?php echo e(asset('images/favicon.ico')); ?>" type="image/x-icon">

        <link rel="stylesheet" href="<?php echo e(asset('plugins/jquery-confirm/jquery-confirm.min.css')); ?>">
        <link href="<?php echo e(asset('css/jquery-ui.min.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(asset('css/select2.min.css')); ?>" rel="stylesheet">

        <!-- vendor css -->
        <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/custom.css?v=2')); ?>">
        
        
        
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <?php echo $__env->yieldPushContent('styles'); ?>

    </head>
    <body class="">

<!--        <div class="loader-bg">
            <div class="loader-track">
                <div class="loader-fill"></div>
            </div>
        </div>-->

        <?php echo $__env->make('layouts.left-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('layouts.top-bar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        
        <?php echo e($slot); ?>

        
        
        <script src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>
        <script src="<?php echo e(asset('js/popper.min.js')); ?>"></script>
        <script src="<?php echo e(asset('js/perfect-scrollbar.min.js')); ?>"></script>
        <script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
        <script src="<?php echo e(asset('js/pcoded.js?v=1' . config('app.version'))); ?>"></script>
        <script src="<?php echo e(asset('plugins/jquery-confirm/jquery-confirm.min.js')); ?>"></script>
        <script src="<?php echo e(asset('js/jquery-ui.min.js')); ?>"></script>
        <script src="<?php echo e(asset('js/loadingoverlay.min.js')); ?>"></script>
        <script src="<?php echo e(asset('js/select2.min.js')); ?>"></script>
        <script src="<?php echo e(asset('js/jquery.ui.monthpicker.min.js')); ?>"></script>
        
        <script src="<?php echo e(asset('js/menu-setting.js?v=1' . config('app.version'))); ?>"></script>
        <!-- custom-chart js -->
        <?php echo $__env->make('layouts.notification', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo app('Tightenco\Ziggy\BladeRouteGenerator')->generate(); ?>
        <script src="<?php echo e(asset('js/common.js?v=1' . config('app.version'))); ?>"></script>
        <?php echo $__env->yieldPushContent('scripts'); ?>

    </body>
</html>
<?php /**PATH C:\xampp\htdocs\pepris-gb-web\resources\views/layouts/app.blade.php ENDPATH**/ ?>