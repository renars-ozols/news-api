<?php declare(strict_types=1);

namespace App\Services\Profile;

use App\Database;

class UpdateCredentialsService
{
    public function execute(UpdateCredentialsServiceRequest $request): void
    {
        $queryBuilder = Database::getConnection()->createQueryBuilder();
        $queryBuilder->update('users')
            ->set('name', '?')
            ->set('email', '?')
            ->where('id = ?')
            ->setParameter(0,$request->getName())
            ->setParameter(1, $request->getEmail())
            ->setParameter(2, $request->getId())
            ->executeQuery();
    }
}
