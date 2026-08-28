<?php
declare(strict_types=1);

function env(string $key, string $default = ''): string
{
    static $values;
    if ($values === null) {
        $values = [];
        $file = dirname(__DIR__) . '/.env';
        if (is_file($file)) {
            foreach (file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
                if (str_starts_with(trim($line), '#') || !str_contains($line, '=')) continue;
                [$name, $value] = explode('=', $line, 2);
                $values[trim($name)] = trim($value, " \t\"");
            }
        }
    }
    return $values[$key] ?? $_ENV[$key] ?? $default;
}

function db(): PDO
{
    static $pdo;
    if (!$pdo) {
        $dsn = 'mysql:host=' . env('DB_HOST', '127.0.0.1') . ';port=' . env('DB_PORT', '3306') . ';dbname=' . env('DB_NAME', 'sante') . ';charset=utf8mb4';
        $pdo = new PDO($dsn, env('DB_USER', 'root'), env('DB_PASS', ''), [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    }
    return $pdo;
}

define('BASE_URL', '/' . trim(env('APP_BASE', 'sante'), '/') . '/');
function asset(string $path): string { return BASE_URL . 'public/assets/' . ltrim($path, '/'); }
function url(string $path = ''): string { return BASE_URL . ltrim($path, '/'); }
function e(?string $value): string { return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8'); }
function flash(string $type, string $message): void { $_SESSION['flash'] = ['type' => $type, 'message' => $message]; }
function redirect(string $path, ?string $flashMessage = null, string $flashType = 'success'): never { 
    if ($flashMessage) flash($flashType, $flashMessage);
    header('Location: ' . $path); 
    exit; 
}
function csrf_token(): string { if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32)); return $_SESSION['csrf']; }
function verify_csrf(): void { if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) { http_response_code(419); exit('Session expirée.'); } }
function auth(): ?array { return $_SESSION['user'] ?? null; }
function require_auth(): void { if (!auth()) redirect(url('?page=login')); }

function has_role(string|array $roles): bool
{
    $user = auth();
    if (!$user || empty($user['role'])) {
        return false;
    }
    $roles = (array) $roles;
    return in_array(strtolower((string)$user['role']), array_map('strtolower', $roles), true);
}

function require_role(string|array $roles): void
{
    require_auth();
    if (!has_role($roles)) {
        redirect(url('?page=dashboard'), 'Accès refusé : vous ne disposez pas des permissions nécessaires.', 'danger');
    }
}
