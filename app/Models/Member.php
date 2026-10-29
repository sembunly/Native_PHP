<?php
declare(strict_types=1);

namespace App\Models;

use PDO;

class Member
{
    public function __construct(private PDO $db)
    {
    }

    public function all(string $search = ''): array
    {
        $sql = 'SELECT * FROM members WHERE status = 1';
        $params = [];
        if ($search !== '') {
            $sql .= ' AND (first_name LIKE :search OR last_name LIKE :search OR phone LIKE :search OR email LIKE :search)';
            $params['search'] = '%' . $search . '%';
        }
        $sql .= ' ORDER BY id ASC';
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM members WHERE id = :id AND status = 1 LIMIT 1');
        $stmt->execute(['id' => $id]);
        $member = $stmt->fetch();

        return $member ?: null;
    }

    public function hasDuplicate(string $field, string $value, ?int $exceptId = null): bool
    {
        if (!in_array($field, ['phone', 'email'], true)) {
            return false;
        }
        $sql = "SELECT id FROM members WHERE {$field} = :value AND status = 1";
        $params = ['value' => $value];
        if ($exceptId !== null) {
            $sql .= ' AND id != :id';
            $params['id'] = $exceptId;
        }
        $stmt = $this->db->prepare($sql . ' LIMIT 1');
        $stmt->execute($params);

        return (bool) $stmt->fetchColumn();
    }

    public function create(array $data): void
    {
        $stmt = $this->db->prepare('INSERT INTO members (first_name, last_name, gender, dob, join_date, phone, email, address, status) VALUES (:first_name, :last_name, :gender, :dob, :join_date, :phone, :email, :address, 1)');
        $stmt->execute($data);
    }

    public function update(int $id, array $data): void
    {
        $this->db->beginTransaction();
        try {
            $archive = $this->db->prepare('UPDATE members SET status = 2 WHERE id = :id AND status = 1');
            $archive->execute(['id' => $id]);
            if ($archive->rowCount() !== 1) {
                throw new \RuntimeException('Member could not be updated.');
            }
            $this->create($data);
            $this->db->commit();
        } catch (\Throwable $error) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            throw $error;
        }
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('UPDATE members SET status = 0 WHERE id = :id AND status = 1');
        $stmt->execute(['id' => $id]);
    }
}
