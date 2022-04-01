<?php

namespace App\Security\Auth;

use App\DTO\AuthorizationDTO;
use App\Entity\User;
use App\Enum\ApiResponseTypeEnum;
use App\Rest\Http\ApiResponseSchema;
use App\Rest\Http\Response;
use App\Security\AbstractSecurity;
use App\Security\Session\CreatorSession;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class Authorization
 *
 * @package App\Security\Auth
 *
 * @author  Codememory
 */
class Authorization extends AbstractSecurity
{

	/**
	 * @param User             $identifiedUser
	 * @param AuthorizationDTO $authorizationDTO
	 *
	 * @return array
	 */
	#[ArrayShape([
		'access_token'  => "string",
		'refresh_token' => "string"
	])]
	public function auth(User $identifiedUser, AuthorizationDTO $authorizationDTO): Response
	{

		$apiResponseSchema = new ApiResponseSchema();
		$creatorSession = new CreatorSession($this->managerRegistry, $this->translator);

		$generatedTokens = $creatorSession->create($identifiedUser, $authorizationDTO);

		return $this->successResponse($apiResponseSchema, $generatedTokens);


	}

	/**
	 * @param ApiResponseSchema $apiResponseSchema
	 * @param array             $tokens
	 *
	 * @return Response
	 */
	private function successResponse(ApiResponseSchema $apiResponseSchema, array $tokens): Response
	{

		$apiResponseSchema
			->setMessage(
				ApiResponseTypeEnum::AUTH,
				$this->translator->getTranslation('common@successAuth')
			)
			->setData($tokens);

		return new Response($apiResponseSchema, 'success', 200);

	}

}