<?php

namespace App\Rest\CRUD;

use App\Enum\ApiResponseTypeEnum;
use App\Interfaces\DTOInterface;
use App\Interfaces\EntityInterface;
use App\Rest\Http\Response;

/**
 * Class UpdaterCRUD
 *
 * @package App\Service\CRUD
 *
 * @author  Codememory
 */
class UpdaterCRUD extends AbstractCRUD
{

	/**
	 * @var string|null
	 */
	protected ?string $translationKeyNotExist = null;

	/**
	 * @var bool
	 */
	protected bool $validateEntity = false;

	/**
	 * @var EntityInterface|null
	 */
	protected ?EntityInterface $finedEntity = null;

	/**
	 * @inheritDoc
	 */
	protected function make(DTOInterface|string $entityOrDTO, array $manipulationBy = []): Response|EntityInterface
	{

		// Check exist translation
		$finedEntity = $this->exist($entityOrDTO, $manipulationBy);

		// Check for the existence of an entity
		if ($finedEntity instanceof Response) {
			return $finedEntity;
		}

		$this->finedEntity = $finedEntity;

		$collectedEntity = $entityOrDTO->updateEntity($finedEntity)->getCollectedEntity();
		$validator = $this->inputValidation($entityOrDTO);

		// Validation of input POST data
		if (!$validator->isValidate()) {
			return $validator->getResponse();
		}

		// Validation when inserting into the database
		if ($this->validateEntity) {
			$validator = $this->inputValidation($collectedEntity);

			if (!$validator->isValidate()) {
				return $validator->getResponse();
			}
		}

		return $collectedEntity;

	}

	/**
	 * @param DTOInterface $DTO
	 * @param array        $manipulationBy
	 *
	 * @return Response|EntityInterface
	 */
	private function exist(DTOInterface $DTO, array $manipulationBy): Response|EntityInterface
	{

		$finedEntity = $this->getRepository($DTO)->findOneBy($manipulationBy);

		if (null === $finedEntity) {
			$this->apiResponseSchema->setMessage(
				ApiResponseTypeEnum::CHECK_EXIST,
				$this->getTranslation($this->translationKeyNotExist)
			);

			return new Response($this->apiResponseSchema, 'error', 404);
		}

		return $finedEntity;

	}

}