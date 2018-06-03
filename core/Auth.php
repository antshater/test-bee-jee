<?php


namespace Core;

class Auth
{
    private static $instance;

    private function __construct()
    {
    }

    public static function instance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function tryLogin($login, $password): bool
    {
        if (
            App::config('auth.login') === $login &&
            App::config('auth.password') === $password
        ) {
            Session::instance()->set('is_admin', true);
            return true;
        }

        return false;
    }

    public function logout()
    {
        Session::instance()->remove('is_admin');
    }

    public static function isAdmin(): bool
    {
        return Session::instance()->get('is_admin');
    }
}
