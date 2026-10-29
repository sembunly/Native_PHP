<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\User;

class DashboardController
{
    public function __construct(private User $users)
    {
    }

    public function index(): void
    {
        $user = $this->users->findActiveById((int) $_SESSION['user_id']);
        if (!$user) {
            redirect('/logout');
        }
        view('dashboard/index', compact('user'));
    }
}
