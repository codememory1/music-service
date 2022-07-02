<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\UserSession;
use App\Enum\UserSessionTypeEnum;
use App\Security\AuthorizedUser;
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

    /**
     * @inheritDoc
     */
    protected ?string $alias = 'us';

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

        return $this->findByCriteria([
            'us.user' => $this->authorizedUser->getUser(),
            'us.type' => UserSessionTypeEnum::TEMP->name
        ]);
    }

    /**
     * @param User $user
     *
     * @return array
     */
    public function allByUser(User $user): array
    {
        return $this->findByCriteria(['us.user' => $user]);
    }

    /**
     * @inheritDoc
     */
    public function findByCriteria(array $criteria, array $orderBy = []): array
    {
        if (false !== $sortByCreatedAt = $this->sortService->get('createdAt')) {
            $orderBy['us.createdAt'] = $this->getOrderType($sortByCreatedAt);
        }

        if (false !== $sortByLastActivity = $this->sortService->get('lastActivity')) {
            $orderBy['us.lastActivity'] = $this->getOrderType($sortByLastActivity);
        }

        if (false !== $sortByCountry = $this->sortService->get('country')) {
            $orderBy['us.country'] = $this->getOrderType($sortByCountry);
        }

        if (false !== $sortByCity = $this->sortService->get('city')) {
            $orderBy['us.city'] = $this->getOrderType($sortByCity);
        }

        if (false !== $filterByIsActive = $this->filterService->get('isActive')) {
            $this->qb->andWhere('us.isActive = :isActive');
            $this->qb->setParameter('isActive', $filterByIsActive);
        }

        return parent::findByCriteria($criteria, $orderBy);
    }
}
