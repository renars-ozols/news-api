<?php declare(strict_types=1);

namespace App\Controllers;

use App\Database;
use App\Redirect;
use App\Template;

class LoginController
{
    public function showForm(): Template
    {
        return new Template('/authentication/login.twig');
    }

    public function login()
    {
        $queryBuilder = (new Database())->getConnection()->createQueryBuilder();
        $user = $queryBuilder
            ->select('id', 'name', 'password')
            ->from('users')
            ->where('email = ?')
            ->setParameter(0, $_POST['email'])->fetchAssociative();
        if ($user) {
            $validPassword = password_verify($_POST['password'], $user['password']);
            if ($validPassword) {
                $_SESSION['userId'] = $user['id'];
                return new Redirect('/');
            }
        }
        $_SESSION['errors'][] = 'wrong username or password';
        return new Redirect('/login');
    }
}
