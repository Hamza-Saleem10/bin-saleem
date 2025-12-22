
<?php $__env->startSection('title', 'Edit Vehicle'); ?>

<?php $__env->startSection('content'); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Edit Vehicle: <?php echo e($vehicle->name); ?></h2>
        <a href="<?php echo e(route('admin.vehicles.index')); ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('admin.vehicles.update', $vehicle)); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="row">
            <div class="col-md-8">

                <div class="card border-0 shadow-sm">
                    <div class="card-body">

                        <div class="mb-3">
                            <label for="name" class="form-label">Vehicle Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control only-alphabets"
                                value="<?php echo e(old('name', $vehicle->name)); ?>">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="seats" class="form-label">Seats <span class="text-danger">*</span></label>
                                <input type="number" name="seats" id="seats" class="form-control"
                                    value="<?php echo e(old('seats', $vehicle->seats)); ?>" min="1" max="50">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="bags" class="form-label">Bags <span class="text-danger">*</span></label>
                                <input type="number" name="bags" id="bags" class="form-control"
                                    value="<?php echo e(old('bags', $vehicle->bags)); ?>" min="0" max="50">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="features" class="form-label">Features (comma-separated)</label>
                            <input type="text" name="features" id="features" class="form-control"
                                value="<?php echo e(old('features', implode(', ', (array) $vehicle->features))); ?>"
                                placeholder="WiFi, AC, Child Seat">
                            <small class="text-muted">Separate each feature with a comma</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                    id="is_active" <?php echo e(old('is_active', $vehicle->is_active) ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="is_active">
                                    Active (visible on website)
                                </label>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <div class="col-md-4">

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">Vehicle Image</div>
                    <div class="card-body text-center">

                        <div class="mb-3">
                            <img id="imagePreview" src="<?php echo e($vehicle->image_url); ?>" alt="Preview" class="img-fluid rounded"
                                style="max-height: 180px;">
                        </div>

                        <div class="mb-3">
                            <input type="file" name="image" id="image" class="form-control" accept="image/*"
                                onchange="previewImage(event)">
                            <small class="text-muted">Leave empty to keep current image</small>
                        </div>

                    </div>
                </div>

                <div class="d-grid mt-3">
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="bi bi-check-circle"></i> Update Vehicle
                    </button>
                </div>

            </div>
        </div>
    </form>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                document.getElementById('imagePreview').src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\binslaeem\resources\views/vehicles/edit.blade.php ENDPATH**/ ?>