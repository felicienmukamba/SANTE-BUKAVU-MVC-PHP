<?php
class AuthController
{
    public function login(): void
    {
        if (auth()) redirect('/?page=dashboard');
        $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            verify_csrf();
            $stmt = db()->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
            $stmt->execute([trim($_POST['email'] ?? '')]);
            $user = $stmt->fetch();
            if ($user && password_verify($_POST['password'] ?? '', $user['password'] ?? '')) {
                session_regenerate_id(true);
                $_SESSION['user'] = ['id' => $user['id'], 'name' => $user['name'], 'role' => $user['role']];
                redirect('/?page=dashboard');
            }
            $error = 'Email ou mot de passe incorrect.';
        }
        require dirname(__DIR__) . '/Views/auth/login.php';
    }

    public function logout(): void { session_destroy(); redirect('/?page=login'); }
}
