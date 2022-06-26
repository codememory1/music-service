<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\UserSession;
use App\Enum\UserSessionTypeEnum;
use App\Security\Auth\AuthorizedUser;
use Symfony\Contracts\Service\Attribute\Required;

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

    #[Required]
    public ?AuthorizedUser $authorizedUser = null;

    /**
     * @return array
     */
    public function authorizedUserSessions(): array
    {
        if (null === $this->authorizedUser->getUser()) {
            return [];
        }

        return $this->findBy([
            'user' => $this->authorizedUser->getUser(),
            'type' => UserSessionTypeEnum::TEMP->name
        ]);
    }

    /**
     * @param User $user
     *
     * @return array
     */
    public function allByUser(User $user): array
    {
        return $this->findBy(['user' => $user]);
    }
}
