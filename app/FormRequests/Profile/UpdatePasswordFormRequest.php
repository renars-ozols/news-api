<?php declare(strict_types=1);

namespace App\FormRequests\Profile;

class UpdatePasswordFormRequest
{
    private string $password;
    private string $newPassword;
    private string $passwordConfirm;

    public function __construct(string $password, string $newPassword, string $passwordConfirm)
    {
        $this->password = $password;
        $this->newPassword = $newPassword;
        $this->passwordConfirm = $passwordConfirm;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getNewPassword(): string
    {
        return $this->newPassword;
    }

    public function getPasswordConfirm(): string
    {
        return $this->passwordConfirm;
    }
}
