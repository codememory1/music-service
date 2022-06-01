<?php

namespace App\Rest\Http;

use App\Enum\ResponseTypeEnum;
use App\Rest\Http\Interfaces\ResponseSchemaInterface;
use App\Service\TranslationService;
use function is_array;

/**
 * Class ResponseSchema.
 *
 * @package App\Rest\Http
 *
 * @author  Codememory
 */
class ResponseSchema implements ResponseSchemaInterface
{
    /**
     * @var array
     */
    private array $schema = [
        'status_code' => null,
        'type' => null,
        'message' => [],
        'data' => []
    ];

    /**
     * @var TranslationService
     */
    private TranslationService $translationService;

    /**
     * @param TranslationService $translationService
     */
    public function __construct(TranslationService $translationService)
    {
        $this->translationService = $translationService;
    }

    /**
     * @param int $code
     *
     * @return $this
     */
    public function setStatusCode(int $code): self
    {
        $this->schema['status_code'] = $code;

        return $this;
    }

    /**
     * @param ResponseTypeEnum $type
     *
     * @return $this
     */
    public function setType(ResponseTypeEnum $type): self
    {
        $this->schema['type'] = $type->name;

        return $this;
    }

    /**
     * @param array|string $message
     * @param array        $parameters
     *
     * @return $this
     */
    public function setMessage(string|array $message, array $parameters = []): self
    {
        if (is_array($message)) {
            $message = array_map(fn(string $translationKey) => $this->translationService->get($translationKey, $parameters), $message);
        } else {
            $message = $this->translationService->get($message, $parameters);
        }

        $this->schema['message'] = $message;

        return $this;
    }

    /**
     * @param array $data
     *
     * @return $this
     */
    public function setData(array $data): self
    {
        $this->schema['data'] = $data;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getSchema(): array
    {
        return $this->schema;
    }

    /**
     * @inheritDoc
     */
    public function getStatusCode(): int
    {
        $statusCode = $this->schema['status_code'];

        return empty($statusCode) ? 200 : $statusCode;
    }

    public function __clone(): void
    {
        $this->schema['status_code'] = null;
        $this->schema['type'] = null;
        $this->schema['message'] = [];
        $this->schema['data'] = [];
    }
}