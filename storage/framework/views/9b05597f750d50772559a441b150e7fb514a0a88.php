<?php if (isset($component)) { $__componentOriginalc3251b308c33b100480ddc8862d4f9c79f6df015 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\GuestLayout::class, []); ?>
<?php $component->withName('guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

    <div class="container-fluid  g-0">
        <div class="row mobile_web g-0">
            <div class="col-lg-7 col-12 signup_banner_wrapper">
                <div class="left-heading d-flex flex-column justify-content-center align-items-center ">
                    <img src="<?php echo e(asset('public_theme/images/main-logo.png')); ?>" class="img-fluid login_banner" alt="E-School Logo" />
                    <h1 class="text-light mt-3 mb-0 main-heading">e-school</h1>
                    <h2 class="text-light main-heading1">Gilgit Baltistan</h2>
                </div>
            </div>
            <div class="col-lg-5 col-12 left_area d-flex justify-content-center align-items-center">
                <div class="login_area justify-content-center">
                    <div class="sign_in text-center mb-3">
                        <h1>Enter New Password</h1>
                    </div>

                    <?php if(Session::get('error') && Session::get('error') != null): ?>
                        <div style="color:red"><?php echo e(Session::get('error')); ?></div>
                        <?php
                            Session::put('error', null);
                        ?>
                    <?php endif; ?>
                    <?php if(Session::get('success') && Session::get('success') != null): ?>
                        <div style="color:green"><?php echo e(Session::get('success')); ?></div>
                        <?php
                            Session::put('success', null);
                        ?>
                    <?php endif; ?>
                    <?php echo Form::open(['route' => 'users.updatePassword', 'id' => 'formValidation', 'class' => 'register-form']); ?>

                    <div class="contanier-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    
                                    <?php echo Form::password('password', [
                                        'class' => 'form-control ' . $errors->first('password', 'error'),
                                        'placeholder' => 'Password',
                                    ]); ?>

                                    <?php echo $errors->first('password', '<label class="error">:message</label>'); ?>

                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group p-relative mb-3">
                                    
                                    <?php echo Form::password('password_confirmation', [
                                        'class' => 'form-control ' . $errors->first('password_confirmation', 'error'),
                                        'placeholder' => 'Confirm Password',
                                    ]); ?>

                                    <?php echo $errors->first('password_confirmation', '<label class="error">:message</label>'); ?>

                                </div>
                            </div>

                        </div>
                        <div class="col-sm-12 mt-3 text-center">
                            
                            <button type="submit" class="btn btn-primary btn-login btn-block w-100 login_btn">Submit</button>
                        </div>
                    </div>
                </div>
                <?php echo Form::close(); ?> <!--end::Card-->
            </div>
        </div>
    </div>

    
    
    


    <?php $__env->startPush('scripts'); ?>
        <script src="<?php echo e(asset('js/jquery.validate.min.js')); ?>"></script>
        <script type="text/javascript">
            $('document').ready(function() {
                $('#formValidation').validate();
            });
        </script>
    <?php $__env->stopPush(); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc3251b308c33b100480ddc8862d4f9c79f6df015)): ?>
<?php $component = $__componentOriginalc3251b308c33b100480ddc8862d4f9c79f6df015; ?>
<?php unset($__componentOriginalc3251b308c33b100480ddc8862d4f9c79f6df015); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\pepris-gb-web\resources\views/users/change-password.blade.php ENDPATH**/ ?>