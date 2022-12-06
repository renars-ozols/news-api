<?php declare(strict_types=1);

namespace App;

class Authentication
{
    public static function loginByEmail(string $email): void
    {
        $queryBuilder = Database::getConnection()->createQueryBuilder();
        $user = $queryBuilder
            ->select('id')
            ->from('users')
            ->where('email = ?')
            ->setParameter(0, $email)->fetchAssociative();
        if ($user) {
            $_SESSION['auth_id'] = $user['id'];
        }
    }
}
