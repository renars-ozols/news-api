<?php declare(strict_types=1);

namespace App\Services\Profile;

use App\Database;

class UpdatePasswordService
{
    public function execute(UpdatePasswordServiceRequest $request): void
    {
        $queryBuilder = Database::getConnection()->createQueryBuilder();
        $queryBuilder->update('users')
            ->set('password', '?')
            ->where('id = ?')
            ->setParameter(0,password_hash($request->getPassword(), PASSWORD_DEFAULT))
            ->setParameter(1, $request->getId())
            ->executeQuery();
    }
}
