<?php

namespace App\Security\PasswordReset;

use App\DTO\PasswordRecoveryRequestDTO;
use App\Entity\PasswordReset;
use App\Rest\Http\ApiResponseSchema;
use App\Rest\Translator;
use App\Security\AbstractSecurity;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class CreatorToken.
 *
 * @package App\Security\PasswordReset
 *
 * @author  Codememory
 */
class CreatorToken extends AbstractSecurity
{
    /**
     * @var ApiResponseSchema
     */
    private ApiResponseSchema $apiResponseSchema;

    /**
     * @param ManagerRegistry   $managerRegistry
     * @param Translator        $translator
     * @param ApiResponseSchema $apiResponseSchema
     */
    public function __construct(ManagerRegistry $managerRegistry, Translator $translator, ApiResponseSchema $apiResponseSchema)
    {
        parent::__construct($managerRegistry, $translator);

        $this->apiResponseSchema = $apiResponseSchema;
    }

    /**
     * @param PasswordRecoveryRequestDTO $passwordRecoveryRequestDTO
     *
     * @return PasswordReset
     */
    public function create(PasswordRecoveryRequestDTO $passwordRecoveryRequestDTO): PasswordReset
    {
        /** @var PasswordReset $passwordResetEntity */
        $passwordResetEntity = $passwordRecoveryRequestDTO->getCollectedEntity();

        $this->em->persist($passwordResetEntity);
        $this->em->flush();

        return $passwordResetEntity;
    }
}