<?php

declare(strict_types=1);

namespace App\Validators;

/**
 * UserValidator — Handles server-side validation for user input.
 */
class UserValidator
{
    /**
     * Validate registration form data.
     *
     * @param array $data Input data
     * @return array Associative array of errors, empty if valid
     */
    public function validateRegistration(array $data): array
    {
        $errors = [];

        // Username validation
        if (empty($data['username'])) {
            $errors['username'] = 'Username is required.';
        } elseif (strlen($data['username']) < 3 || strlen($data['username']) > 150) {
            $errors['username'] = 'Username must be between 3 and 150 characters.';
        } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $data['username'])) {
            $errors['username'] = 'Username can only contain letters, numbers, and underscores.';
        }

        // Email validation
        if (empty($data['email'])) {
            $errors['email'] = 'Email is required.';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Please provide a valid email address.';
        } elseif (strlen($data['email']) > 191) {
            $errors['email'] = 'Email cannot exceed 191 characters.';
        }

        // Password validation
        if (empty($data['password'])) {
            $errors['password'] = 'Password is required.';
        } elseif (strlen($data['password']) < 6) {
            $errors['password'] = 'Password must be at least 6 characters.';
        } elseif (!preg_match('/[0-9]/', $data['password'])) {
            $errors['password'] = 'Password must contain at least one number.';
        }

        // Password confirmation
        if (($data['password'] ?? '') !== ($data['password_confirmation'] ?? '')) {
            $errors['password_confirmation'] = 'Passwords do not match.';
        }

        // Phone validation (optional)
        if (!empty($data['phone']) && strlen($data['phone']) > 30) {
            $errors['phone'] = 'Phone number cannot exceed 30 characters.';
        }

        return $errors;
    }
}
