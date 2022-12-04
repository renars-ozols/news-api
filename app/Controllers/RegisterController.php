<?php declare(strict_types=1);

namespace App\Controllers;

use App\Database;
use App\Redirect;
use App\Services\RegisterService;
use App\Services\RegisterServiceRequest;
use App\Template;

class RegisterController
{
    public function showForm(): Template
    {
        return new Template('/authentication/register.twig');
    }

    public function store(): Redirect
    {
        if ($_POST['password'] !== $_POST['passwordConfirm']) {
            $_SESSION['errors'][] = "passwords don't match!";
            return new Redirect('/register');
        }
        $queryBuilder = (new Database())->getConnection()->createQueryBuilder();
        $checkIfEmailExists = $queryBuilder
            ->select('email')
            ->from('users')
            ->where('email = ?')
            ->setParameter(0, $_POST['email'])
            ->fetchAssociative();

        if (!$checkIfEmailExists) {
            $registerService = new RegisterService();
            $registerService->execute(new RegisterServiceRequest(
                $_POST['name'],
                $_POST['email'],
                $_POST['password']
            ));
            return new Redirect('/login');
        }
        $_SESSION['errors'][] = "this email is already taken!";
        return new Redirect('/register');
    }
}
