<?php declare(strict_types=1);

namespace App\Controllers;

use App\Authentication;
use App\FormRequests\Profile\UpdateCredentialsFormRequest;
use App\FormRequests\Profile\UpdatePasswordFormRequest;
use App\Redirect;
use App\Services\Profile\UpdateCredentialsService;
use App\Services\Profile\UpdateCredentialsServiceRequest;
use App\Services\Profile\UpdatePasswordService;
use App\Services\Profile\UpdatePasswordServiceRequest;
use App\Template;
use App\Validation\Validation;

class ProfileController
{
    public function __construct()
    {
        if (!Authentication::getAuthId()) {
            header('Location: /');
        }
    }

    public function index(): Template
    {
        return new Template('/authentication/profile.twig');
    }

    public function updateCredentials(): Redirect
    {
        $validation = new Validation();
        $validation->validateProfileCredentialsForm(new UpdateCredentialsFormRequest(
            $_POST['name'],
            $_POST['email']
        ));

        if (isset($_SESSION['errors']) && count($_SESSION['errors']) >= 1) {
            return new Redirect('/profile');
        }

        $updateCredentialsService = new UpdateCredentialsService();
        $updateCredentialsService->execute(
            new UpdateCredentialsServiceRequest(
                Authentication::getAuthId(),
                $_POST['name'],
                $_POST['email']
            ));

        return new Redirect('/profile');
    }

    public function updatePassword(): Redirect
    {
        $validation = new Validation();
        $validation->validateProfileUpdatePasswordForm(new UpdatePasswordFormRequest(
            $_POST['password'],
            $_POST['newPassword'],
            $_POST['passwordConfirm']
        ));

        if (isset($_SESSION['errors']) && count($_SESSION['errors']) >= 1) {
            return new Redirect('/profile');
        }

        $updatePasswordService = new UpdatePasswordService();
        $updatePasswordService->execute(new UpdatePasswordServiceRequest(
            Authentication::getAuthId(),
            $_POST['newPassword']
        ));

        return new Redirect('/profile');
    }
}
