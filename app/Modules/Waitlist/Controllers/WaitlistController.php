<?php

namespace App\Modules\Waitlist\Controllers;

use App\Controllers\BaseController;
use App\Modules\Waitlist\Models\WaitlistModel;

class WaitlistController extends BaseController
{
    /**
     * Displays the Home Page with email capture.
     */
    public function index()
    {
        return view('App\Modules\Waitlist\Views\intro');
    }

    /**
     * Handles pre-signup email capture from home page.
     */
    public function preSignup()
    {
        $email = $this->request->getPost('email', FILTER_SANITIZE_EMAIL);
        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->to('/')->with('error', 'Please enter a valid email address.');
        }
        $firstName = strtok($email, '@');
        $lastName = null;
        // Store in session for pre-fill
        session()->set('waitlist_prefill', [
            'email' => $email,
            'full_name' => $firstName,
            'last_name' => $lastName
        ]);
        return redirect()->to('waitlist/signup');
    }

    /**
     * Displays the full waitlist signup form, pre-filling if available.
     */
    public function signup()
    {
        $prefill = session()->get('waitlist_prefill');
        return view('App\Modules\Waitlist\Views\signup_form', [
            'prefill' => $prefill
        ]);
    }

    /**
     * Handles the form submission, validation, and database insertion.
     */
    public function submit()
    {
        if (!$this->request->is('post')) {
            return redirect()->to('waitlist/signup');
        }
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
        if (!$this->validate($rules, $messages)) {
            return redirect()->to('waitlist/signup')->withInput()->with('errors', $this->validator->getErrors());
        }
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
        if ($model->save($data)) {
            session()->remove('waitlist_prefill');
            return redirect()->to('waitlist/signup')->with('success', 'Thank you! You have been added to the waitlist. We\'ll be in touch!');
        } else {
            return redirect()->to('waitlist/signup')->withInput()->with('error', 'Sorry, there was a problem. Please try again.');
        }
    }
}
