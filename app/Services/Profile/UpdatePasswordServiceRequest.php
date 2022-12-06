<?php declare(strict_types=1);

namespace App\Services\Profile;

class UpdatePasswordServiceRequest
{
    private string $id;
    private string $password;

    public function __construct(string $id, string $password)
    {
        $this->id = $id;
        $this->password = $password;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
