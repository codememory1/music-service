<?php

namespace App\Rest;

use App\Interfaces\EntityInterface;
use App\Rest\Http\Response;
use App\Rest\Http\ResponseCollection;
use Doctrine\ORM\EntityManagerInterface;
use function call_user_func;
use Closure;

/**
 * Class ApiManager.
 *
 * @package App\Rest
 *
 * @author  Codememory
 */
class ApiManager
{

    /**
     * @var EntityManagerInterface
     */
    public readonly EntityManagerInterface $em;

    /**
     * @var null|Closure
     */
    private ?Closure $handlerAfterFlush = null;

    /**
     * @var ResponseCollection
     */
    private ResponseCollection $responseCollection;

    /**
     * @param EntityManagerInterface $em
     * @param ResponseCollection     $responseCollection
     */
    public function __construct(EntityManagerInterface $em, ResponseCollection $responseCollection)
    {
        $this->em = $em;
        $this->responseCollection = $responseCollection;
    }

    /**
     * @param callable $handler
     *
     * @return $this
     */
    public function setHandlerAfterFlush(callable $handler): self
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

        return $this->responseCollection->successCreate($successTranslationKey)->getResponse();
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

        return $this->responseCollection->successUpdate($successTranslationKey)->getResponse();
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

        return $this->responseCollection->successDelete($successTranslationKey)->getResponse();
    }

    /**
     * @param null|Closure $closure
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