<?php declare(strict_types=1);

namespace App\Validation;

use App\Authentication;
use App\FormRequests\Profile\UpdateCredentialsFormRequest;
use App\FormRequests\Profile\UpdatePasswordFormRequest;
use App\FormRequests\UserLoginFormRequest;
use App\FormRequests\UserRegistrationFormRequest;

class Validation extends Rules
{
    public function validateRegistrationForm(UserRegistrationFormRequest $request): void
    {
        $this->validateUserName($request->getName());
        $this->validateEmail($request->getEmail());
        $this->validateEmailExists($request->getEmail());
        $this->validatePassword($request->getPassword());
        $this->validateEqualPasswords($request->getPassword(), $request->getPasswordConfirm());
    }

    public function validateLoginForm(UserLoginFormRequest $request): void
    {
        $this->validateEmail($request->getEmail());
        $this->validatePassword($request->getPassword());
        $this->validateLoginCredentials($request->getEmail(), $request->getPassword());
    }

    public function validateProfileCredentialsForm(UpdateCredentialsFormRequest $request): void
    {
        $this->validateUserName($request->getName());
        $this->validateEmail($request->getEmail());
        if ($request->getEmail() !== Authentication::getUser()->getEmail()) {
            $this->validateEmailExists($request->getEmail());
        }
    }

    public function validateProfileUpdatePasswordForm(UpdatePasswordFormRequest $request): void
    {
        $this->validateCurrentPassword($request->getPassword());
        $this->validatePassword($request->getPassword());
        $this->validatePassword($request->getNewPassword(), 'newPassword');
        $this->validatePassword($request->getPasswordConfirm(), 'passwordConfirm');
        $this->validateEqualPasswords($request->getNewPassword(), $request->getPasswordConfirm());
    }
}