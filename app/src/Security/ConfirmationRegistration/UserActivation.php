<?php

namespace App\Security\ConfirmationRegistration;

use App\Entity\UserActivationToken;
use App\Enum\ApiResponseTypeEnum;
use App\Enum\StatusEnum;
use App\Repository\UserActivationTokenRepository;
use App\Rest\Http\ApiResponseSchema;
use App\Rest\Http\Response;
use App\Rest\Translator;
use App\Security\AbstractSecurity;
use App\Service\JwtTokenGenerator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class UserActivation
 *
 * @package App\Security\ConfirmationRegistration
 *
 * @author  Codememory
 */
class UserActivation extends AbstractSecurity
{

	/**
	 * @var UserActivationTokenRepository
	 */
	private UserActivationTokenRepository $userActivationTokenRepository;

	/**
	 * @var JwtTokenGenerator
	 */
	private JwtTokenGenerator $jwtTokenGenerator;

	/**
	 * @var ApiResponseSchema
	 */
	private ApiResponseSchema $apiResponseSchema;

	/**
	 * @param ManagerRegistry   $managerRegistry
	 * @param Translator        $translator
	 * @param JwtTokenGenerator $jwtTokenGenerator
	 * @param ApiResponseSchema $apiResponseSchema
	 */
	public function __construct(
		ManagerRegistry $managerRegistry,
		Translator $translator,
		JwtTokenGenerator $jwtTokenGenerator,
		ApiResponseSchema $apiResponseSchema
	)
	{

		parent::__construct($managerRegistry, $translator);

		/** @var UserActivationTokenRepository $userActivationTokenRepository */
		$userActivationTokenRepository = $this->em->getRepository(UserActivationToken::class);

		$this->userActivationTokenRepository = $userActivationTokenRepository;
		$this->jwtTokenGenerator = $jwtTokenGenerator;
		$this->apiResponseSchema = $apiResponseSchema;

	}

	/**
	 * @param string $token
	 *
	 * @return UserActivationToken
	 */
	public function activate(string $token): UserActivationToken
	{

		/** @var UserActivationToken $finedUserActivationToken */
		$finedUserActivationToken = $this->userActivationTokenRepository->findOneBy(['token' => $token]);
		$user = $finedUserActivationToken->getUser();

		$user->setStatus(StatusEnum::ACTIVE->value);

		$this->em->flush();

		return $finedUserActivationToken;

	}

	/**
	 * @param string $token
	 *
	 * @return bool
	 */
	public function existToken(string $token): bool
	{

		return null !== $this->userActivationTokenRepository->findOneBy([
				'token' => $token
			]);

	}

	/**
	 * @param string $token
	 *
	 * @return Response|bool
	 */
	public function isValid(string $token): Response|bool
	{

		$decodedToken = $this->jwtTokenGenerator->decode($token, 'JWT_ACCOUNT_ACTIVATION_PUBLIC_KEY');

		if (!$decodedToken) {
			$this->apiResponseSchema->setMessage(
				ApiResponseTypeEnum::CHECK_VALID,
				$this->translator->getTranslation('userActivationAccount@tokenIsNotValid')
			);

			return new Response($this->apiResponseSchema, 'error', 400);
		}

		return true;

	}

	/**
	 * @return Response
	 */
	public function successActivationResponse(): Response
	{

		$this->apiResponseSchema->setMessage(
			ApiResponseTypeEnum::ACTIVATION_ACCOUNT,
			$this->translator->getTranslation('userActivationAccount@successActivation')
		);

		return new Response($this->apiResponseSchema, 'success', 200);

	}

}