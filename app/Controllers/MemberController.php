<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Member;

class MemberController
{
    public function __construct(private Member $members)
    {
    }

    public function index(): void
    {
        $search = trim($_GET['search'] ?? '');
        $members = $this->members->all($search);
        view('members/index', compact('members', 'search'));
    }

    public function create(): void
    {
        $this->form(null);
    }

    public function edit(): void
    {
        $member = $this->members->find((int) ($_GET['id'] ?? 0));
        if (!$member) {
            http_response_code(404);
            view('members/show', ['member' => null]);
            return;
        }
        $this->form($member);
    }

    public function delete(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf($_POST['_token'] ?? '')) {
            http_response_code(400);
            echo 'Invalid request';
            return;
        }
        $this->members->delete((int) ($_POST['id'] ?? 0));
        redirect('/members');
    }

    private function form(?array $member): void
    {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf($_POST['_token'] ?? '')) {
                http_response_code(400);
                $error = 'Invalid request. Please refresh the page and try again.';
            } else {
                $data = [];
                foreach (['first_name', 'last_name', 'gender', 'dob', 'join_date', 'phone', 'email', 'address'] as $field) {
                    $data[$field] = trim($_POST[$field] ?? '');
                }
                $id = $member ? (int) $member['id'] : null;
                if ($data['first_name'] === '' || $data['last_name'] === '' || !in_array($data['gender'], ['Male', 'Female'], true) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                    $error = 'Please enter valid member details.';
                } elseif ($this->members->hasDuplicate('phone', $data['phone'], $id)) {
                    $error = 'Phone number already exists!';
                } elseif ($this->members->hasDuplicate('email', $data['email'], $id)) {
                    $error = 'Email already exists!';
                } else {
                    if ($member) {
                        $this->members->update($id, $data);
                    } else {
                        $this->members->create($data);
                    }
                    redirect('/members');
                }
                $member = array_merge($member ?? [], $data);
            }
        }
        view('members/' . ($member && isset($member['id']) ? 'edit' : 'create'), compact('member', 'error'));
    }
}
