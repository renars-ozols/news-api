<?php declare(strict_types=1);

namespace App\Controllers;

use App\Authentication;
use App\FormRequests\UserLoginFormRequest;
use App\Redirect;
use App\Template;
use App\Validation\Validation;

class LoginController
{
    public function showForm(): Template
    {
        return new Template('/authentication/login.twig');
    }

    public function login(): Redirect
    {
        $validation = new Validation();
        $validation->validateLoginForm(new UserLoginFormRequest(
            $_POST['email'],
            $_POST['password']
        ));

        if (isset($_SESSION['errors']) && count($_SESSION['errors']) >= 1) {
            return new Redirect('/login');
        }

        Authentication::loginByEmail($_POST['email']);

        return new Redirect('/');
    }
}
