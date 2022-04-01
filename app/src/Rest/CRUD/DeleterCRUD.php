<?php

namespace App\Rest\CRUD;

use App\Enum\ApiResponseTypeEnum;
use App\Interfaces\DTOInterface;
use App\Interfaces\EntityInterface;
use App\Rest\Http\Response;
use Exception;

/**
 * Class DeleterCRUD
 *
 * @package App\Service\CRUD
 *
 * @author  Codememory
 */
class DeleterCRUD extends AbstractCRUD
{

	/**
	 * @var string|null
	 */
	protected ?string $translationKeyNotExist = null;

	/**
	 * @inheritDoc
	 * @throws Exception
	 */
	protected function make(DTOInterface|string $entityOrDTO, array $manipulationBy = []): Response|EntityInterface
	{

		$finedEntity = $this->getRepository($entityOrDTO)->findOneBy($manipulationBy);

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