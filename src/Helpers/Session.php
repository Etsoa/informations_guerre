<?php
// Gestion des sessions

class Session {
    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public static function get($key) {
        return $_SESSION[$key] ?? null;
    }

    public static function isAdmin() {
        return isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin';
    }

    public static function logout() {
        session_destroy();
        redirect(BASE_URL);
    }
}
