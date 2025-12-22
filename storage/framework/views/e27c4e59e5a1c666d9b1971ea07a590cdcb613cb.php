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
                    <img src="<?php echo e(asset('public_theme/images/main-logo.png')); ?>" class="img-fluid login_banner"
                        alt="E-School Logo" />
                    <h1 class="text-light mt-3 mb-0 main-heading">Umrah Taxi</h1>
                    <h2 class="text-light main-heading1">Saudi Arbia</h2>
                </div>
            </div>

            <div class="col-lg-5 col-12 left_area d-flex justify-content-center align-items-center">
                <div class="login_area justify-content-center">
                    <div class="sign_in text-center mb-3">
                        <h1>Login</h1>
                    </div>

                    <form action="<?php echo e(route('login')); ?>" method="POST" class="register-form">
                        <?php echo csrf_field(); ?>
                        <div class="contanier-fluid">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <input id="username"
                                            class="form-control <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            placeholder="Username" type="username" name="username"
                                            value="<?php echo e(old('username', session()->get('username'))); ?>" maxlength="50"
                                            autofocus />
                                        <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group p-relative mb-3">
                                        <input id="password"
                                            class="form-control  pwd-hide-show_input <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            type="password" name="password" autocomplete="current-password"
                                            placeholder="Password" />
                                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <!---capcha start---->
                                <div class="col-12">
                                    <div class="d-flex align-items-center">

                                        <div class="form-group mb-3 me-3" id="captch-container">
                                            <?php echo captcha_img(); ?>

                                        </div>

                                        <div class="form-group mb-3">
                                            <button type="button" id="btn-refresh" class="btn btn-primary btn-auth">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-12"></div>
                                    <div class="form-group mb-3">
                                        <input id="captcha" class="form-control <?php $__errorArgs = ['captcha'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="Enter Captcha" type="text" name="captcha" tabindex="3" />
                                        <?php $__errorArgs = ['captcha'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <!-------end------------>
                                <div class="col-12 d-flex justify-content-between align-items-center">
                                    <div class="form-check custom-checkbox">
                                        <input class="form-check-input" type="checkbox" id="remember">
                                        <label class="form-check-label" for="remember">Remember me</label>
                                    </div>
                                    <a href="#" class="forgot-password">Forgot Password?</a>
                                </div>


                            </div>
                            <div class="col-sm-12 mt-3 text-center">
                                <button class="btn btn-block btn-primary btn-login w-100 login_btn">Login</button>
                                <small class="d-block text-center text-primary mt-3">Don’t have account? <a
                                        href="<?php echo e(route('register')); ?>"
                                        target="_self"><strong>Register</strong></a></small>
                            </div>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    <?php $__env->startPush('scripts'); ?>
        <script>
            $(document).on("click", "#btn-refresh", function() {
                $.ajax({
                    url: "<?php echo e(route('refresh-captcha')); ?>",
                    data:{

                        '_token':"<?php echo e(csrf_token()); ?>"
                    },
                    type:"POST",
                    cache: false,
                    success: function(html) {
                        $("#captch-container").find('img').attr('src', html);
                    }
                });
            });
        </script>
    <?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc3251b308c33b100480ddc8862d4f9c79f6df015)): ?>
<?php $component = $__componentOriginalc3251b308c33b100480ddc8862d4f9c79f6df015; ?>
<?php unset($__componentOriginalc3251b308c33b100480ddc8862d4f9c79f6df015); ?>
<?php endif; ?>
<?php /**PATH D:\binslaeem\resources\views/auth/login.blade.php ENDPATH**/ ?>