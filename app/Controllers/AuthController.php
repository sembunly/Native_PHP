<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Services\AuthService;

class AuthController
{
    public function __construct(private AuthService $auth)
    {
    }

    public function login(): void
    {
        if (!empty($_SESSION['user_id'])) {
            redirect('/dashboard');
        }
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = $this->auth->attempt(trim($_POST['username'] ?? ''), $_POST['password'] ?? '');
            if ($user) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = (int) $user['id'];
                redirect('/dashboard');
            }
            $error = 'Login failed';
        }
        view('auth/login', compact('error'));
    }

    public function logout(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy();
        redirect('/login');
    }
}
