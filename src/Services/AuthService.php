<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\UserRepository;
use App\Exceptions\ValidationException;

/**
 * AuthService — Business logic for authentication.
 *
 * Sits between Controller and Repository.
 * Controllers handle HTTP; Services handle business rules.
 */
class AuthService
{
    private UserRepository $userRepo;

    public function __construct()
    {
        $this->userRepo = new UserRepository();
    }

    /**
     * Register a new user account.
     *
     * @param  array $data Validated registration data (username, email, password, phone)
     * @return int         The newly created user's ID
     * @throws ValidationException If username or email is already taken
     */
    public function register(array $data): int
    {
        // Check uniqueness (give friendly errors instead of raw DB constraint violations)
        $errors = [];

        if ($this->userRepo->findByUsername($data['username'])) {
            $errors['username'] = 'This username is already taken.';
        }

        if ($this->userRepo->findByEmail($data['email'])) {
            $errors['email'] = 'This email address is already registered.';
        }

        if (!empty($errors)) {
            throw new ValidationException($errors);
        }

        // Hash the password — NEVER store plain text (rubric #5)
        $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);

        // Insert the new user
        return $this->userRepo->create([
            'username'      => $data['username'],
            'email'         => $data['email'],
            'password_hash' => $passwordHash,
            'phone'         => !empty($data['phone']) ? $data['phone'] : null,
            'role'          => 'customer',
        ]);
    }
}
