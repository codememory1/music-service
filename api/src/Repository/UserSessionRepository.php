<?php

namespace App\Repository;

use App\Entity\UserSession;

/**
 * Class UserSessionRepository.
 *
 * @package App\Repository
 * @template-extends AbstractRepository<UserSession>
 *
 * @author  Codememory
 */
class UserSessionRepository extends AbstractRepository
{
    /**
     * @inheritDoc
     */
    protected ?string $entity = UserSession::class;
}
