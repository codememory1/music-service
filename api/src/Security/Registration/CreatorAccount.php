<?php

namespace App\Security\Registration;

use App\Entity\Role;
use App\Entity\User;
use App\Enum\EventEnum;
use App\Enum\RoleEnum;
use App\Enum\UserStatusEnum;
use App\Event\CreateUserAccountEvent;
use App\Rest\Http\Response;
use App\Rest\Validator\Validator;
use App\Security\AbstractSecurity;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class CreatorAccount.
 *
 * @package App\Security\Registration
 *
 * @author  Codememory
 */
class CreatorAccount extends AbstractSecurity
{
    /**
     * @var null|Validator
     */
    private ?Validator $validator = null;

    /**
     * @param Validator $validator
     *
     * @return $this
     */
    #[Required]
    public function setValidator(Validator $validator): self
    {
        $this->validator = $validator;

        return $this;
    }

    /**
     * @param User                     $user
     * @param EventDispatcherInterface $eventDispatcher
     *
     * @return Response|User
     */
    public function create(User $user, EventDispatcherInterface $eventDispatcher): Response|User
    {
        $roleRepository = $this->em->getRepository(Role::class);

        $user->setStatus(UserStatusEnum::NOT_ACTIVE);
        $user->setRole($roleRepository->findByKey(RoleEnum::USER));

        if (false === $this->validator->validate($user)->isValidate()) {
            return $this->validator->getResponse();
        }

        $this->em->persist($user);
        $this->em->flush();

        $eventDispatcher->dispatch(
            new CreateUserAccountEvent($user),
            EventEnum::USER_CREATE_ACCOUNT->value
        );

        return $user;
    }

    /**
     * @return Response
     */
    public function successCreateResponse(): Response
    {
        return $this->responseCollection
            ->successCreate('user@successCreateAccount')
            ->getResponse();
    }
}