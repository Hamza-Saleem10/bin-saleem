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
    
</head>

<body>

    <div class="container-fluid main-container">
        <div class="row mobile_web">
            <!-- Left Section -->
            <div class="col-md-6 col-12 left-section">
                <div class="left-heading d-flex flex-column justify-content-center align-items-center">
                    <img src="<?php echo e(asset('public_theme/images/main-logo.png')); ?>" class="img-fluid login_banner"
                        alt="E-School Logo" />
                    <h1 class="text-light mt-3 mb-0 main-heading">e-school</h1>
                    <h2 class="text-light main-heading1">Gilgit Baltistan</h2>
                </div>
            </div>

            <!-- Right Section -->

            <?php echo e($slot); ?>


        </div>
    </div>

    <script src="<?php echo e(asset('public_theme/js/bootstrap.bundle.js')); ?>"></script>

    

</body>

</html>
<?php /**PATH C:\xampp\htdocs\pepris-gb-web\resources\views/layouts/register.blade.php ENDPATH**/ ?>