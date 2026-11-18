<?php
declare(strict_types=1);
session_start();

const DB_HOST = '127.0.0.1';
const DB_NAME = 'voidloot';
const DB_USER = 'root';
const DB_PASS = '';

function db(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $pdo = new PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
            DB_USER, DB_PASS,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
        );
    }
    return $pdo;
}
function e(?string $value): string { return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8'); }
function admin_password(): string { return getenv('VOIDLOOT_ADMIN_PASSWORD') ?: 'ChangeThis-VOIDLOOT-2026!'; }
function is_admin(): bool { return !empty($_SESSION['voidloot_admin']); }
function csrf_token(): string {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}
function verify_csrf(): void {
    if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) {
        http_response_code(403); exit('Invalid request token.');
    }
}
function safe_url(string $url): string {
    $url = trim($url);
    return filter_var($url, FILTER_VALIDATE_URL) && in_array(strtolower(parse_url($url, PHP_URL_SCHEME) ?: ''), ['http','https'], true) ? $url : '';
}
function youtube_embed(string $url): string {
    $host = strtolower(parse_url($url, PHP_URL_HOST) ?: '');
    $path = trim(parse_url($url, PHP_URL_PATH) ?: '', '/');
    $id = '';
    if (str_contains($host, 'youtu.be')) $id = explode('/', $path)[0] ?? '';
    if (str_contains($host, 'youtube.com')) {
        parse_str(parse_url($url, PHP_URL_QUERY) ?: '', $q);
        $id = $q['v'] ?? (str_starts_with($path, 'embed/') ? substr($path, 6) : '');
    }
    return preg_match('/^[A-Za-z0-9_-]{11}$/', $id) ? 'https://www.youtube-nocookie.com/embed/' . $id : '';
}
