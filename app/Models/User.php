<?php
declare(strict_types=1);

namespace App\Models;

use PDO;

class User
{
    public function __construct(private PDO $db)
    {
    }

    public function findActiveByUsername(string $username): ?array
    {
        $stmt = $this->db->prepare('SELECT id, username, password FROM users WHERE username = :username AND status = 1 LIMIT 1');
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        return $user ?: null;
    }

    public function findActiveById(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT id, username FROM users WHERE id = :id AND status = 1 LIMIT 1');
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();

        return $user ?: null;
    }

    public function updatePassword(int $id, string $passwordHash): void
    {
        $stmt = $this->db->prepare('UPDATE users SET password = :password WHERE id = :id');
        $stmt->execute(['password' => $passwordHash, 'id' => $id]);
    }
}
