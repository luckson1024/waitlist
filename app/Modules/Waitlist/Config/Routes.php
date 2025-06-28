<?php
// This is a module-specific routes file.
// It will be automatically discovered and loaded by the system.

$routes->group('waitlist', ['namespace' => 'App\Modules\Waitlist\Controllers'], function ($routes) {
    // Page 1: The Intro Page
    $routes->get('/', 'WaitlistController::index');
    // Pre-signup email capture
    $routes->post('preSignup', 'WaitlistController::preSignup');
    // Page 2: The Signup Form Page
    $routes->get('signup', 'WaitlistController::signup');
    // Form Submission Endpoint
    $routes->post('submit', 'WaitlistController::submit');
});
