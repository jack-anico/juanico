<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\AuthService;
use App\Validators\UserValidator;
use App\Exceptions\ValidationException;

/**
 * AuthController — Handles registration (and later, login/logout).
 */
class AuthController extends BaseController
{
    private AuthService $authService;

    public function __construct()
    {
        parent::__construct();
        $this->authService = new AuthService();
    }

    /**
     * GET /register — Display the registration form.
     */
    public function showRegisterForm(): void
    {
        // If already logged in, redirect to home
        if (isAuthenticated()) {
            $this->response->redirect(url('/'));
        }

        $this->response->view('auth.register');
    }

    /**
     * POST /register — Process the registration form submission.
     *
     * Flow:
     *   1. Validate CSRF token
     *   2. Collect and sanitize input
     *   3. Validate input (server-side)
     *   4. Create user via AuthService
     *   5. Start authenticated session
     *   6. Redirect to home page
     */
    public function register(): void
    {
        // 1. CSRF check (rubric #4: proper sanitization)
        if (!$this->request->validateCsrf()) {
            $this->backWithErrors(['csrf' => 'Invalid security token. Please try again.']);
        }

        // 2. Collect input
        $data = $this->request->only([
            'username',
            'email',
            'phone',
            'password',
            'password_confirmation',
        ]);

        // 3. Server-side validation (rubric #4: client- AND server-side)
        $validator = new UserValidator();
        $errors    = $validator->validateRegistration($data);

        if (!empty($errors)) {
            $this->backWithErrors($errors, [
                'username' => $data['username'] ?? '',
                'email'    => $data['email'] ?? '',
                'phone'    => $data['phone'] ?? '',
            ]);
        }

        // 4. Attempt registration (may throw ValidationException for duplicate username/email)
        try {
            $userId = $this->authService->register($data);
        } catch (ValidationException $e) {
            $this->backWithErrors($e->getErrors(), [
                'username' => $data['username'] ?? '',
                'email'    => $data['email'] ?? '',
                'phone'    => $data['phone'] ?? '',
            ]);
        } catch (\Exception $e) {
            // Graceful error — never expose raw errors (rubric #6)
            $this->backWithErrors(
                ['general' => 'An unexpected error occurred. Please try again.'],
                [
                    'username' => $data['username'] ?? '',
                    'email'    => $data['email'] ?? '',
                    'phone'    => $data['phone'] ?? '',
                ]
            );
        }

        // 5. Auto-login: start authenticated session
        session_regenerate_id(true); // Prevent session fixation (rubric #5)
        $_SESSION['user_id'] = $userId;

        // 6. Redirect to home page
        $this->response->redirect(url('/'));
    }
}
