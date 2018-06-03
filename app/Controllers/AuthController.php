<?php


namespace App\Controllers;

use Core\Auth;
use Core\Controller;
use Core\Session;

class AuthController extends Controller
{
    public function login()
    {
        if ($form = $this->request->post('auth')) {
            $login = $this->request->post('auth.login');
            $password = $this->request->post('auth.password');
            if (Auth::instance()->tryLogin($login, $password)) {
                $this->redirect('/');
            } else {
                Session::instance()->oneOffMessage('auth_failed', true);
            }
        }

        $this->view('auth/form');
    }

    public function logout()
    {
        Auth::instance()->logout();
        $this->redirect('/');
    }
}
