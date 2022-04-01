<?php

namespace App\Controller\Api;

use App\Enum\ApiResponseTypeEnum;
use App\Rest\Http\ApiResponseSchema;
use App\Rest\Http\Response;
use App\Rest\Translator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class ApiController
 *
 * @package App\Controller\Api
 *
 * @author  Codememory
 */
class ApiController extends AbstractController
{

	/**
	 * @var ManagerRegistry
	 */
	protected ManagerRegistry $managerRegistry;

	/**
	 * @var Translator
	 */
	protected Translator $translator;

	/**
	 * @param ManagerRegistry $managerRegistry
	 * @param Translator      $translator
	 */
	public function __construct(ManagerRegistry $managerRegistry, Translator $translator)
	{

		$this->managerRegistry = $managerRegistry;
		$this->translator = $translator;

	}

	/**
	 * @param string $entityNamespace
	 * @param string $dtoNamespace
	 *
	 * @return JsonResponse
	 */
	protected function showAllFromDatabase(string $entityNamespace, string $dtoNamespace): JsonResponse
	{

		$DTO = new $dtoNamespace(managerRegistry: $this->managerRegistry);
		$apiResponseSchema = new ApiResponseSchema();
		$entityRepository = $this->managerRegistry->getRepository($entityNamespace);

		$apiResponseSchema
			->setMessage(
				ApiResponseTypeEnum::SHOW,
				$this->translator->getTranslation('common@getInfo')
			)
			->setData($DTO->transform($entityRepository->findAll()));

		return (new Response($apiResponseSchema, 'success', 200))->make();

	}

}