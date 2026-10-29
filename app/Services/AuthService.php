<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\User;

class AuthService
{
    public function __construct(private User $users)
    {
    }

    public function attempt(string $username, string $password): ?array
    {
        $user = $this->users->findActiveByUsername($username);
        if (!$user) {
            return null;
        }

        $hashed = password_get_info($user['password'])['algo'] !== null;
        $valid = $hashed ? password_verify($password, $user['password']) : hash_equals($user['password'], $password);
        if (!$valid) {
            return null;
        }

        if (!$hashed || password_needs_rehash($user['password'], PASSWORD_DEFAULT)) {
            $this->users->updatePassword((int) $user['id'], password_hash($password, PASSWORD_DEFAULT));
        }

        unset($user['password']);
        return $user;
    }
}
