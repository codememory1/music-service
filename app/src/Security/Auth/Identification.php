<?php

namespace App\Security\Auth;

use App\DTO\AuthorizationDTO;
use App\Entity\User;
use App\Enum\ApiResponseTypeEnum;
use App\Enum\StatusEnum;
use App\Repository\UserRepository;
use App\Rest\Http\Response;
use App\Security\AbstractSecurity;
use Doctrine\ORM\NonUniqueResultException;

/**
 * Class Identification.
 *
 * @package App\Security\Auth
 *
 * @author  Codememory
 */
class Identification extends AbstractSecurity
{
    /**
     * @param AuthorizationDTO $authorizationDTO
     *
     * @throws NonUniqueResultException
     *
     * @return Response|User
     */
    public function identify(AuthorizationDTO $authorizationDTO): Response|User
    {
        /** @var UserRepository $userRepository */
        $userRepository = $this->em->getRepository(User::class);

        // Checking the existence of a user by email or username
        if (null === $finedUser = $userRepository->findByLogin($authorizationDTO->login)) {
            $this->apiResponseSchema->setMessage(
                ApiResponseTypeEnum::CHECK_EXIST,
                $this->translator->getTranslation('user@failedToIdentityUser')
            );

            return new Response($this->apiResponseSchema, 'error', 404);
        }

        // Checking the active account
        if ($finedUser->getStatus() !== StatusEnum::ACTIVE->value) {
            $this->apiResponseSchema->setMessage(
                ApiResponseTypeEnum::CHECK_ACTIVE,
                $this->translator->getTranslation('user@accountNotActive')
            );

            return new Response($this->apiResponseSchema, 'error', 400);
        }

        return $finedUser;
    }
}