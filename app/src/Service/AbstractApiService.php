<?php

namespace App\Service;

use App\Enums\ApiResponseTypeEnum;
use App\Service\Response\ApiResponseSchema;
use App\Service\Response\ApiResponseService;
use App\Service\Translator\TranslationService;
use Closure;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Exception;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class AbstractApiService
 *
 * @package App\Service
 *
 * @author  Codememory
 */
abstract class AbstractApiService
{

    /**
     * @var Request
     */
    protected Request $request;

    /**
     * @var Response
     */
    protected Response $response;

    /**
     * @var ManagerRegistry
     */
    protected ManagerRegistry $managerRegistry;

    /**
     * @var ObjectManager
     */
    protected ObjectManager $em;

    /**
     * @var TranslationService
     */
    protected TranslationService $translationService;

    /**
     * @var ApiResponseSchema|null
     */
    private ?ApiResponseSchema $preparedApiResponse = null;

    /**
     * @var Closure|null
     */
    private ?Closure $handler = null;

    /**
     * @param Request         $request
     * @param Response        $response
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(Request $request, Response $response, ManagerRegistry $managerRegistry)
    {

        $this->request = $request;
        $this->response = $response;
        $this->managerRegistry = $managerRegistry;
        $this->em = $this->managerRegistry->getManager();
        $this->translationService = new TranslationService($request, $managerRegistry);

    }

    /**
     * @param string $status
     * @param int    $code
     *
     * @return ApiResponseSchema
     */
    protected function prepareApiResponse(string $status, int $code): ApiResponseSchema
    {

        $apiResponseSchema = new ApiResponseSchema($status, $code);

        $this->preparedApiResponse = $apiResponseSchema;

        return $apiResponseSchema;

    }

    /**
     * @param string $key
     *
     * @return string|null
     * @throws Exception
     */
    protected function getTranslation(string $key): ?string
    {

        return $this->translationService->getActiveLanguageTranslation($key)?->getTranslation();

    }

    /**
     * @param ConstraintViolationListInterface $constraintViolationList
     *
     * @return array
     */
    #[ArrayShape([
        'name'    => "string",
        'type'    => ApiResponseTypeEnum::class,
        'message' => "string"
    ])]
    protected function getValidateInfo(ConstraintViolationListInterface $constraintViolationList): array
    {

        /** @var ConstraintViolation $constraint */
        $constraint = $constraintViolationList->get(0);
        $payload = $constraint->getConstraint()->payload;

        return [
            'name'    => is_array($payload) ? $payload[1] : $payload,
            'type'    => is_array($payload) ? $payload[0] : null,
            'message' => $constraint->getMessage()
        ];

    }

    /**
     * @param object             $entity
     * @param ValidatorInterface $validator
     *
     * @return ApiResponseService|bool
     * @throws Exception
     */
    protected function inputValidation(object $entity, ValidatorInterface $validator): ApiResponseService|bool
    {

        // Input Validation
        if (count($errors = $validator->validate($entity)) > 0) {
            $validateInfo = $this->getValidateInfo($errors);

            $this
                ->prepareApiResponse('error', 400)
                ->setMessage(
                    $validateInfo['type'] ?? ApiResponseTypeEnum::INPUT_VALIDATION,
                    $validateInfo['name'],
                    $this->getTranslation($validateInfo['message']) ?? ''
                );

            return $this->getPreparedApiResponse();
        }

        return true;

    }

    /**
     * @param callable $handler
     *
     * @return $this
     */
    protected function setHandler(callable $handler): AbstractApiService
    {

        $this->handler = $handler;

        return $this;

    }

    /**
     * @param object $entity
     * @param string $successTranslationKey
     * @param bool   $asUpdate
     *
     * @return ApiResponseService
     * @throws Exception
     */
    public function push(object $entity, string $successTranslationKey, bool $asUpdate = false): ApiResponseService
    {

        $messageName = $asUpdate ? 'success_update' : 'success_create';
        $type = $asUpdate ? ApiResponseTypeEnum::UPDATE : ApiResponseTypeEnum::CREATE;
        $translation = $this->getTranslation($successTranslationKey);

        if (!$asUpdate) {
            $this->em->persist($entity);
        }

        $this->em->flush();

        $this->callHandler($entity);

        $this
            ->prepareApiResponse('success', 200)
            ->setMessage($type, $messageName, $translation);

        return $this->getPreparedApiResponse();

    }

    /**
     * @param object $entity
     * @param string $successTranslationKey
     *
     * @return ApiResponseService
     * @throws Exception
     */
    public function remove(object $entity, string $successTranslationKey): ApiResponseService
    {

        $translation = $this->getTranslation($successTranslationKey);

        $this->em->remove($entity);
        $this->em->flush();

        $this->callHandler($entity);

        $this
            ->prepareApiResponse('success', 200)
            ->setMessage(ApiResponseTypeEnum::DELETE, 'success_delete', $translation);

        return $this->getPreparedApiResponse();

    }

    /**
     * @return ApiResponseService
     */
    #[Pure]
    public function getPreparedApiResponse(): ApiResponseService
    {

        return new ApiResponseService($this->preparedApiResponse);

    }

    /**
     * @param object $entity
     *
     * @return void
     */
    private function callHandler(object $entity): void
    {

        if (null !== $this->handler) {
            call_user_func($this->handler, $entity);
        }

    }

}