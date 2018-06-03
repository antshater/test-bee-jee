<?php


namespace App\Controllers;

use Core\Auth;
use Core\Controller;
use Core\Helpers\ArrayHelper;
use Core\Session;

class AuthController extends Controller
{
    public function login()
    {
        if ($form = $this->request->post('auth')) {
            $login = ArrayHelper::extract($form, 'login');
            $password = ArrayHelper::extract($form, 'password');
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
