<?php declare(strict_types=1);

namespace App;

use App\FormRequests\UserLoginFormRequest;
use App\FormRequests\UserRegistrationFormRequest;
use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Validator as v;

class Validation
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

    private function validateUserName(string $name): void
    {
        $userNameValidator = v::alpha()->length(3, 15);
        try {
            $userNameValidator->check($name);
        } catch (ValidationException $exception) {
            $this->addError('name', $exception->getMessage());
        }
    }

    private function validateEmail(string $email): void
    {
        $emailValidator = v::email();
        try {
            $emailValidator->check($email);
        } catch (ValidationException $exception) {
            $this->addError('email', $exception->getMessage());
        }
    }

    private function validateEmailExists(string $email): void
    {
        $queryBuilder = Database::getConnection()->createQueryBuilder();
        $checkIfEmailExists = $queryBuilder
            ->select('email')
            ->from('users')
            ->where('email = ?')
            ->setParameter(0, $email)
            ->fetchAssociative();

        if ($checkIfEmailExists) {
            $this->addError('email', 'this email is already taken!');
        }
    }

    private function validatePassword(string $password): void
    {
        $passwordValidator = v::alnum()->length(5);
        try {
            $passwordValidator->check($password);
        } catch (ValidationException $exception) {
            $this->addError('password', $exception->getMessage());
        }
    }

    private function validateEqualPasswords(string $firstPassword, string $secondPassword): void
    {
        $EqualPasswordValidator = v::identical($firstPassword);
        try {
            $EqualPasswordValidator->check($secondPassword);
        } catch (ValidationException $exception) {
            $this->addError('passwordConfirm', $exception->getMessage());
        }
    }

    private function validateLoginCredentials(string $email, string $password): void
    {
        $queryBuilder = Database::getConnection()->createQueryBuilder();
        $user = $queryBuilder
            ->select('id', 'password')
            ->from('users')
            ->where('email = ?')
            ->setParameter(0, $email)->fetchAssociative();
        if ($user) {
            $validPassword = password_verify($password, $user['password']);
            if ($validPassword) {
                return;
            }
        }
        $this->addError('email', 'wrong email or password');
    }

    private function addError(string $name, string $message): void
    {
        $_SESSION['errors'][$name] = $message;
    }
}
