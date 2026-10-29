<?php
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\MemberController;

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
$basePath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
if ($basePath !== '' && str_starts_with($path, $basePath)) {
    $path = substr($path, strlen($basePath)) ?: '/';
}
$path = '/' . trim($path, '/');

if ($path === '/login' && $_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_SESSION['user_id'])) {
    redirect('/dashboard');
}
if ($path === '/login') {
    (new AuthController($authService))->login();
} elseif ($path === '/logout') {
    (new AuthController($authService))->logout();
} elseif ($path === '/' || $path === '/dashboard') {
    require_auth();
    (new DashboardController($userModel))->index();
} elseif ($path === '/members' || $path === '/members/create' || $path === '/members/edit' || $path === '/members/delete') {
    require_auth();
    $controller = new MemberController($memberModel);
    if ($path === '/members/create') {
        $controller->create();
    } elseif ($path === '/members/edit') {
        $controller->edit();
    } elseif ($path === '/members/delete') {
        $controller->delete();
    } else {
        $controller->index();
    }
} else {
    http_response_code(404);
    echo 'Page not found';
}
