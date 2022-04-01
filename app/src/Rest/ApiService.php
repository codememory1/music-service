<?php

namespace App\Rest;

use App\Interfaces\DTOInterface;
use App\Interfaces\EntityInterface;
use App\Rest\Http\ApiResponseSchema;
use App\Rest\Validator\Validator;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class ApiService
 *
 * @package App\Rest
 *
 * @author  Codememory
 */
class ApiService
{

	/**
	 * @var ManagerRegistry
	 */
	protected ManagerRegistry $managerRegistry;

	/**
	 * @var ObjectManager
	 */
	protected ObjectManager $em;

	/**
	 * @var ApiManager
	 */
	protected ApiManager $manager;

	/**
	 * @var Translator
	 */
	protected Translator $translator;

	/**
	 * @var ApiResponseSchema
	 */
	protected ApiResponseSchema $apiResponseSchema;

	/**
	 * @var Validator
	 */
	protected Validator $validator;

	/**
	 * @param ManagerRegistry    $managerRegistry
	 * @param ApiManager         $apiManager
	 * @param Translator         $translator
	 * @param ApiResponseSchema  $apiResponseSchema
	 * @param ValidatorInterface $validator
	 */
	public function __construct(
		ManagerRegistry $managerRegistry,
		ApiManager $apiManager,
		Translator $translator,
		ApiResponseSchema $apiResponseSchema,
		Validator $validator
	)
	{

		$this->managerRegistry = $managerRegistry;
		$this->em = $managerRegistry->getManager();
		$this->manager = $apiManager;
		$this->translator = $translator;
		$this->apiResponseSchema = $apiResponseSchema;
		$this->validator = $validator;

	}

	/**
	 * @param string $key
	 * @param string $default
	 *
	 * @return string
	 */
	protected function getTranslation(string $key, string $default = ''): string
	{

		return $this->translator->getTranslation($key, $default);

	}

	/**
	 * @param EntityInterface|DTOInterface $entityOrDTO
	 *
	 * @return Validator
	 */
	public function inputValidation(EntityInterface|DTOInterface $entityOrDTO): Validator
	{

		$this->validator->validate($entityOrDTO);

		return $this->validator;

	}

}