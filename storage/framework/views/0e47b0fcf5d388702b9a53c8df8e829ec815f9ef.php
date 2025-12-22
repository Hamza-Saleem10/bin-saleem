<?php if (isset($component)) { $__componentOriginalf11e64d756badf3afc84507aa171d29c75914128 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\RegisterLayout::class, []); ?>
<?php $component->withName('register-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

    <div class="col-md-6  col-12 d-flex justify-content-center align-items-center vh-100 right-section">
        <div class="form-container">
            <h4 class="text-center text-light mb-4">Register</h4>
            <form method="POST" action="<?php echo e(route('register')); ?>">
                <?php echo csrf_field(); ?>

                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.input','data' => ['type' => 'text','id' => 'name','name' => 'name','class' => 'form-control form-input mb-3','value' => old('name'),'required' => true,'autofocus' => true,'placeholder' => 'Owner Name']]); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'text','id' => 'name','name' => 'name','class' => 'form-control form-input mb-3','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('name')),'required' => true,'autofocus' => true,'placeholder' => 'Owner Name']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.input','data' => ['type' => 'text','id' => 'cnic','name' => 'cnic','class' => 'form-control form-input mb-3','value' => old('cnic'),'required' => true,'autofocus' => true,'placeholder' => 'Owner CNIC']]); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'text','id' => 'cnic','name' => 'cnic','class' => 'form-control form-input mb-3','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('cnic')),'required' => true,'autofocus' => true,'placeholder' => 'Owner CNIC']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.input','data' => ['type' => 'email','id' => 'email','name' => 'email','class' => 'form-control form-input mb-3','value' => old('email'),'required' => true,'autofocus' => true,'placeholder' => 'Email']]); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'email','id' => 'email','name' => 'email','class' => 'form-control form-input mb-3','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('email')),'required' => true,'autofocus' => true,'placeholder' => 'Email']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.input','data' => ['type' => 'password','id' => 'password','name' => 'password','class' => 'form-control form-input mb-3','value' => old('password'),'required' => true,'autofocus' => true,'placeholder' => 'Password']]); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'password','id' => 'password','name' => 'password','class' => 'form-control form-input mb-3','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('password')),'required' => true,'autofocus' => true,'placeholder' => 'Password']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.input','data' => ['type' => 'password','id' => 'password_confirmation','name' => 'password_confirmation','class' => 'form-control form-input mb-3','required' => true,'placeholder' => 'Confirm Password']]); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'password','id' => 'password_confirmation','name' => 'password_confirmation','class' => 'form-control form-input mb-3','required' => true,'placeholder' => 'Confirm Password']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>


                <?php if($errors->any()): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <div class="form-check d-flex align-items-start mb-3">
                    <input class="form-check-input me-2" type="checkbox" id="terms" />
                    <label class="form-check-label small text-light" for="terms">
                        I agree to the Terms & Conditions and Privacy Policy by registering.
                    </label>
                </div>

                <button type="submit" class="btn btn-register">Register</button>

                <div class="text-center mt-3">
                    <span class="text-light">Already Have An Account? </span>
                    <a href="<?php echo e(route('login')); ?>" class="login-link fw-bold">Login</a>
                </div>
            </form>
        </div>
    </div>

    
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf11e64d756badf3afc84507aa171d29c75914128)): ?>
<?php $component = $__componentOriginalf11e64d756badf3afc84507aa171d29c75914128; ?>
<?php unset($__componentOriginalf11e64d756badf3afc84507aa171d29c75914128); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\pepris-gb-web\resources\views/auth/register.blade.php ENDPATH**/ ?>