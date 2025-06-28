<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join the Myzuwa Waitlist</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f5;
        }
        .main-container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 1rem;
        }
        .form-panel {
            background-color: #ffffff;
            padding: 2.5rem;
            border-radius: 1rem;
            max-width: 550px;
            width: 100%;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .form-panel h2 {
            font-weight: 900;
            margin-bottom: 1.5rem;
        }
        .form-control, .form-select {
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            border: 1px solid #ced4da;
        }
        .form-control:focus, .form-select:focus {
            box-shadow: none;
            border-color: #D9530D;
        }
        .btn-action {
            background-color: #D9530D;
            color: #ffffff;
            font-weight: 700;
            padding: 0.85rem;
            border: none;
            border-radius: 0.5rem;
            width: 100%;
            transition: background-color 0.2s;
        }
        .btn-action:hover {
            background-color: #b8460b;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="form-panel">
            <h2>Join the waitlist</h2>
            <!-- Display Flash Messages -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php elseif (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>
            <?php $errors = session()->getFlashdata('errors'); ?>
            <?php $prefill = isset($prefill) ? $prefill : []; ?>
            <?= form_open(site_url('waitlist/submit')) ?>
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="full_name" class="form-label">Full Name</label>
                <input type="text" class="form-control <?= isset($errors['full_name']) ? 'is-invalid' : '' ?>" id="full_name" name="full_name" placeholder="Enter your full name" value="<?= old('full_name', $prefill['full_name'] ?? '') ?>" required>
                <?php if(isset($errors['full_name'])): ?><div class="invalid-feedback"><?= $errors['full_name'] ?></div><?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" id="email" name="email" placeholder="you@example.com" value="<?= old('email', $prefill['email'] ?? '') ?>" required>
                <?php if(isset($errors['email'])): ?><div class="invalid-feedback"><?= $errors['email'] ?></div><?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone Number (Optional)</label>
                <input type="tel" class="form-control" id="phone_number" name="phone_number" placeholder="Enter phone number" value="<?= old('phone_number') ?>">
            </div>
            <div class="mb-3">
                <label for="type_of_business" class="form-label">Type of Business</label>
                <select class="form-select <?= isset($errors['type_of_business']) ? 'is-invalid' : '' ?>" id="type_of_business" name="type_of_business" required>
                    <option value="" disabled selected>Select one...</option>
                    <option value="Music" <?= old('type_of_business') == 'Music' ? 'selected' : '' ?>>Music</option>
                    <option value="Fashion" <?= old('type_of_business') == 'Fashion' ? 'selected' : '' ?>>Fashion</option>
                    <option value="Digital Goods" <?= old('type_of_business') == 'Digital Goods' ? 'selected' : '' ?>>Digital Goods</option>
                    <option value="Other" <?= old('type_of_business') == 'Other' ? 'selected' : '' ?>>Other</option>
                </select>
                <?php if(isset($errors['type_of_business'])): ?><div class="invalid-feedback"><?= $errors['type_of_business'] ?></div><?php endif; ?>
            </div>
            <div class="mb-3 d-none" id="custom_business_tags_wrapper">
                <label for="custom_business_tags" class="form-label">Custom Business Tags (comma-separated)</label>
                <input type="text" class="form-control" id="custom_business_tags" name="custom_business_tags" placeholder="e.g., Art, Crafts, Coaching" value="<?= old('custom_business_tags') ?>">
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="country" class="form-label">Country</label>
                    <input type="text" class="form-control <?= isset($errors['country']) ? 'is-invalid' : '' ?>" id="country" name="country" value="<?= old('country') ?>" required>
                    <?php if(isset($errors['country'])): ?><div class="invalid-feedback"><?= $errors['country'] ?></div><?php endif; ?>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="city" class="form-label">City</label>
                    <input type="text" class="form-control <?= isset($errors['city']) ? 'is-invalid' : '' ?>" id="city" name="city" value="<?= old('city') ?>" required>
                    <?php if(isset($errors['city'])): ?><div class="invalid-feedback"><?= $errors['city'] ?></div><?php endif; ?>
                </div>
            </div>
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" value="1" id="has_run_store_before" name="has_run_store_before" <?= old('has_run_store_before') ? 'checked' : '' ?>>
                <label class="form-check-label" for="has_run_store_before">Have you run an online store before?</label>
            </div>
            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" value="1" id="wants_tutorial_book" name="wants_tutorial_book" <?= old('wants_tutorial_book') ? 'checked' : '' ?>>
                <label class="form-check-label" for="wants_tutorial_book">Sign up to receive our Tutorial Book</label>
            </div>
            <button type="submit" class="btn-action">Reserve My Spot</button>
        </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const businessTypeSelect = document.getElementById('type_of_business');
            const customTagsWrapper = document.getElementById('custom_business_tags_wrapper');
            function toggleCustomTags() {
                if (businessTypeSelect.value === 'Other') {
                    customTagsWrapper.classList.remove('d-none');
                } else {
                    customTagsWrapper.classList.add('d-none');
                }
            }
            toggleCustomTags();
            businessTypeSelect.addEventListener('change', toggleCustomTags);
        });
    </script>
</body>
</html>
