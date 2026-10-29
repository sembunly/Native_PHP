<?php
declare(strict_types=1);

use App\Models\Member;
use App\Models\User;
use App\Services\AuthService;

require dirname(__DIR__) . '/vendor/autoload.php';

$envFile = dirname(__DIR__) . '/.env';
if (is_file($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
            continue;
        }
        [$key, $value] = explode('=', $line, 2);
        $_ENV[trim($key)] = trim(trim($value), " \t\n\r\0\x0B\"'");
    }
}
foreach ($_ENV as $key => $value) {
    if (str_starts_with((string) $key, 'DB_')) {
        putenv($key . '=' . $value);
    }
}

$config = require dirname(__DIR__) . '/config/database.php';
$dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', $config['host'], $config['port'], $config['name']);
$db = new \PDO($dsn, $config['user'], $config['password'], [
    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
    \PDO::ATTR_EMULATE_PREPARES => false,
]);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_set_cookie_params([
        'httponly' => true,
        'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
        'samesite' => 'Lax',
    ]);
    session_start();
}

$userModel = new User($db);
$memberModel = new Member($db);
$authService = new AuthService($userModel);

function view(string $name, array $data = []): void
{
    extract($data, EXTR_SKIP);
    require dirname(__DIR__) . '/app/Views/' . $name . '.php';
}

function redirect(string $path): never
{
    $base = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
    header('Location: ' . ($base ? $base : '') . $path);
    exit;
}

function url(string $path): string
{
    $base = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
    return ($base ? $base : '') . '/' . ltrim($path, '/');
}

function require_auth(): void
{
    if (empty($_SESSION['user_id'])) {
        redirect('/login');
    }
}

function csrf_token(): string
{
    if (empty($_SESSION['_token'])) {
        $_SESSION['_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['_token'];
}

function verify_csrf(string $token): bool
{
    return isset($_SESSION['_token']) && hash_equals($_SESSION['_token'], $token);
}

require dirname(__DIR__) . '/routes/web.php';
