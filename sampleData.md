
Understood. The visual reference clarifies the user flow perfectly. You want a two-page system:
Intro Page (/waitlist): A visually striking landing page that explains the value and has a single call-to-action button.
Signup Form Page (/waitlist/signup): The detailed form where the user enters all their information.
# 1. CONTROLLER (UPDATED)
I will now generate the updated codebase to reflect this exact two-page structure, matching the design aesthetic from your image (dark intro, light form, orange action buttons). The previous Model and database schema are still correct and will be used.
1. CONTROLLER (UPDATED)
The WaitlistController is updated to handle the two separate pages. The index() method now shows the intro page, and a new signup() method shows the form.
Path: app/Modules/Waitlist/Controllers/WaitlistController.php
```php
Generated php
<?php

namespace App\Modules\Waitlist\Controllers;

use App\Controllers\BaseController;
use App\Modules\Waitlist\Models\WaitlistModel;

class WaitlistController extends BaseController
{
    /**
     * Displays the "Homepage waitlist intro" page.
     */
    public function index()
    {
        return view('App\Modules\Waitlist\Views\intro');
    }

    /**
     * Displays the full waitlist signup form.
     */
    public function signup()
    {
        // Helper 'form' is loaded automatically by BaseController
        return view('App\Modules\Waitlist\Views\signup_form');
    }

    /**
     * Handles the form submission, validation, and database insertion.
     */
    public function submit()
    {
        if (!$this->request->is('post')) {
            // Redirect to the form page if not a POST request
            return redirect()->to('waitlist/signup');
        }

        // 1. Define Validation Rules
        $rules = [
            'full_name'        => 'required|min_length[3]|max_length[150]',
            'email'            => 'required|valid_email|is_unique[waitlist_signups.email]',
            'phone_number'     => 'permit_empty|min_length[7]|max_length[30]',
            'type_of_business' => 'required|in_list[Music,Fashion,Digital Goods,Other]',
            'custom_business_tags' => 'permit_empty|string',
            'country'          => 'required|max_length[100]',
            'city'             => 'required|max_length[100]',
        ];
        
        $messages = [
            'email' => [
                'is_unique' => 'This email address has already joined the waitlist.'
            ]
        ];

        // 2. Run Validation
        if (!$this->validate($rules, $messages)) {
            // If validation fails, redirect back to the form with errors and old input
            return redirect()->to('waitlist/signup')->withInput()->with('errors', $this->validator->getErrors());
        }

        // 3. Prepare and Sanitize Data
        $model = new WaitlistModel();
        
        $data = [
            'full_name'        => $this->request->getPost('full_name', FILTER_SANITIZE_SPECIAL_CHARS),
            'email'            => $this->request->getPost('email', FILTER_SANITIZE_EMAIL),
            'phone_number'     => $this->request->getPost('phone_number', FILTER_SANITIZE_SPECIAL_CHARS),
            'type_of_business' => $this->request->getPost('type_of_business', FILTER_SANITIZE_SPECIAL_CHARS),
            'custom_business_tags' => $this->request->getPost('type_of_business') === 'Other' ? $this->request->getPost('custom_business_tags', FILTER_SANITIZE_SPECIAL_CHARS) : null,
            'country'          => $this->request->getPost('country', FILTER_SANITIZE_SPECIAL_CHARS),
            'city'             => $this->request->getPost('city', FILTER_SANITIZE_SPECIAL_CHARS),
            'has_run_store_before' => $this->request->getPost('has_run_store_before') ? 1 : 0,
            'wants_tutorial_book'  => $this->request->getPost('wants_tutorial_book') ? 1 : 0,
        ];

        // 4. Save to Database
        if ($model->save($data)) {
            // On success, redirect back to the signup form with a success message.
            return redirect()->to('waitlist/signup')->with('success', 'Thank you! You have been added to the waitlist. We\'ll be in touch!');
        } else {
            // On failure, redirect back with a generic error.
            return redirect()->to('waitlist/signup')->withInput()->with('error', 'Sorry, there was a problem. Please try again.');
        }
    }
```
# 2. VIEWS (NEW & UPDATED)
## 2.1. Intro Page View (NEW)
}
2. VIEWS (NEW & UPDATED)
I will now create two separate view files as requested.
```php
2.1. Intro Page View (NEW)
This view replicates the left-side panel from your image.
Path: app/Modules/Waitlist/Views/intro.php
Generated php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Myzuwa is Coming Soon</title>
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
        .intro-panel {
            background-color: #121212;
            color: #ffffff;
            padding: 3rem 2.5rem;
            border-radius: 1rem;
            max-width: 450px;
            text-align: left;
        }
        .intro-panel .brand {
            font-weight: 900;
            font-size: 1.75rem;
            letter-spacing: 1px;
        }
        .intro-panel .headline {
            font-weight: 900;
            font-size: 3rem;
            line-height: 1.1;
            margin-top: 1rem;
            margin-bottom: 1.5rem;
        }
        .intro-panel p {
            font-size: 1.1rem;
            color: #e0e0e0;
            margin-bottom: 2rem;
        }
        .intro-panel .btn-action {
            background-color: #D9530D;
            color: #ffffff;
            font-weight: 700;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            text-decoration: none;
            display: block;
            text-align: center;
            transition: background-color 0.2s;
        }
        .intro-panel .btn-action:hover {
            background-color: #b8460b;
        }
        .intro-panel ul {
            list-style: none;
            padding: 0;
            margin-top: 2rem;
        }
        .intro-panel ul li {
            padding-left: 1.5rem;
            position: relative;
            margin-bottom: 0.75rem;
        }
        .intro-panel ul li::before {
            content: '•';
            color: #D9530D;
            font-weight: bold;
            display: inline-block;
            position: absolute;
            left: 0;
            font-size: 1.25rem;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="intro-panel">
            <div class="brand">MYZUWA</div>
            <h1 class="headline">Myzuwa is coming.</h1>
            <p>E-commerce meets music. Be first to experience the future.</p>
            <a href="<?= site_url('waitlist/signup') ?>" class="btn-action">Join the Waitlist</a>
            <ul>
                <li>Stream exclusive music</li>
                <li>Shop curated drops</li>
                <li>Unlock early bird perks</li>
            </ul>
        </div>
    </div>
## 2.2. Signup Form View (UPDATED)
</body>
</html>
2.2. Signup Form View (UPDATED)
```php
This view is updated to match the right-side panel's style and contains the full, detailed form.
Path: app/Modules/Waitlist/Views/signup_form.php
Generated php
<!DOCTYPE html>
<html lang="en">
<head>
```
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

            <?= form_open(site_url('waitlist/submit')) ?>
            <?= csrf_field() ?>

            <!-- All Form Fields Go Here -->
            <div class="mb-3">
                <label for="full_name" class="form-label">Full Name</label>
                <input type="text" class="form-control <?= isset($errors['full_name']) ? 'is-invalid' : '' ?>" id="full_name" name="full_name" placeholder="Enter your full name" value="<?= old('full_name') ?>" required>
                <?php if(isset($errors['full_name'])): ?><div class="invalid-feedback"><?= $errors['full_name'] ?></div><?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" id="email" name="email" placeholder="you@example.com" value="<?= old('email') ?>" required>
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
# 3. ROUTING (UPDATED)
    </script>
</body>
</html>
3. ROUTING (UPDATED)
```php
The routes file is updated to include the new /signup URL.
Path: app/Modules/Waitlist/Config/Routes.php
Generated php
<?php
```

// This is a module-specific routes file.
// It will be automatically discovered and loaded by the system.

$routes->group('waitlist', ['namespace' => 'App\Modules\Waitlist\Controllers'], function ($routes) {
    // Page 1: The Intro Page
    $routes->get('/', 'WaitlistController::index');
    
    // Page 2: The Signup Form Page
    $routes->get('signup', 'WaitlistController::signup');
    
# Summary of Changes & How to Use
    // Form Submission Endpoint
    $routes->post('submit', 'WaitlistController::submit');
});
Summary of Changes & How to Use
* Replace the old [`WaitlistController.php`](app/Modules/Waitlist/Controllers/WaitlistController.php) and [`signup_form.php`](app/Modules/Waitlist/Views/signup_form.php) with these new versions.
* Add the new [`intro.php`](app/Modules/Waitlist/Views/intro.php) file inside [`app/Modules/Waitlist/Views/`](app/Modules/Waitlist/Views/).
* Replace the old [`Routes.php`](app/Modules/Waitlist/Config/Routes.php) in [`app/Modules/Waitlist/Config/`](app/Modules/Waitlist/Config/) with this updated one.
* Navigate to `https://your-domain.com/waitlist`. You will see the intro page.
* Click the "Join the Waitlist" button. You will be taken to `https://your-domain.com/waitlist/signup`.
* Fill out the form and submit. The logic will process the data and redirect you back to the signup page with a success or error message.
```