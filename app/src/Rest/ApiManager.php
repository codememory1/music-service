<?php

namespace App\Rest;

use App\Enum\ApiResponseTypeEnum;
use App\Interfaces\EntityInterface;
use App\Rest\Http\ApiResponseSchema;
use App\Rest\Http\Response;
use Closure;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;

/**
 * Class ApiManager
 *
 * @package App\Rest
 *
 * @author  Codememory
 */
class ApiManager
{

	/**
	 * @var ObjectManager
	 */
	private ObjectManager $em;

	/**
	 * @var Closure|null
	 */
	private ?Closure $handlerAfterFlush = null;

	/**
	 * @var Translator
	 */
	private Translator $translator;

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

		$this->em = $managerRegistry->getManager();
		$this->translator = $translator;
		$this->apiResponseSchema = $apiResponseSchema;

	}

	/**
	 * @param callable $handler
	 *
	 * @return $this
	 */
	public function setHandlerAfterFlush(callable $handler): ApiManager
	{

		$this->handlerAfterFlush = $handler;

		return $this;

	}

	/**
	 * @param EntityInterface $entity
	 * @param string          $successTranslationKey
	 *
	 * @return Response
	 */
	public function push(EntityInterface $entity, string $successTranslationKey): Response
	{

		$this->em->persist($entity);
		$this->em->flush();

		$this->callHandler($this->handlerAfterFlush, $entity);

		$this->apiResponseSchema->setMessage(
			ApiResponseTypeEnum::CREATE,
			$this->translator->getTranslation($successTranslationKey)
		);

		return new Response($this->apiResponseSchema, 'success', 200);

	}

	/**
	 * @param EntityInterface $entity
	 * @param string          $successTranslationKey
	 *
	 * @return Response
	 */
	public function update(EntityInterface $entity, string $successTranslationKey): Response
	{

		$this->em->flush();

		$this->callHandler($this->handlerAfterFlush, $entity);

		$this->apiResponseSchema->setMessage(
			ApiResponseTypeEnum::UPDATE,
			$this->translator->getTranslation($successTranslationKey)
		);

		return new Response($this->apiResponseSchema, 'success', 200);

	}

	/**
	 * @param EntityInterface $entity
	 * @param string          $successTranslationKey
	 *
	 * @return Response
	 */
	public function remove(EntityInterface $entity, string $successTranslationKey): Response
	{

		$this->em->remove($entity);
		$this->em->flush();

		$this->callHandler($this->handlerAfterFlush, $entity);

		$this->apiResponseSchema->setMessage(
			ApiResponseTypeEnum::DELETE,
			$this->translator->getTranslation($successTranslationKey)
		);

		return new Response($this->apiResponseSchema, 'success', 200);

	}

	/**
	 * @param Closure|null $closure
	 * @param mixed        ...$arguments
	 *
	 * @return void
	 */
	private function callHandler(?Closure $closure, mixed ...$arguments): void
	{

		if (null !== $closure) {
			call_user_func($closure, ...$arguments);
		}

	}

}