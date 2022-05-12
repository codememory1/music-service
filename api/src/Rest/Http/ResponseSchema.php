<?php

namespace App\Rest\Http;

use App\Entity\Language;
use App\Entity\Translation;
use App\Entity\TranslationKey;
use App\Repository\LanguageRepository;
use App\Repository\TranslationKeyRepository;
use App\Repository\TranslationRepository;
use App\Rest\Http\Interfaces\ResponseSchemaInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class ResponseSchema
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
     * @var Request|null
     */
    private ?Request $request;

    /**
     * @var LanguageRepository
     */
    private LanguageRepository $languageRepository;

    /**
     * @var TranslationKeyRepository
     */
    private TranslationKeyRepository $translationKeyRepository;

    /**
     * @var TranslationRepository
     */
    private TranslationRepository $translationRepository;

    /**
     * @param EntityManagerInterface $entityManager
     * @param RequestStack           $requestStack
     */
    public function __construct(RequestStack $requestStack, EntityManagerInterface $entityManager)
    {
        $this->request = $requestStack->getCurrentRequest();

        $this->languageRepository = $entityManager->getRepository(Language::class);
        $this->translationKeyRepository = $entityManager->getRepository(TranslationKey::class);
        $this->translationRepository = $entityManager->getRepository(Translation::class);
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
     * @param string $type
     *
     * @return $this
     */
    public function setType(string $type): self
    {
        $this->schema['type'] = $type;

        return $this;
    }

    /**
     * @param string|array $message
     *
     * @return $this
     */
    public function setMessage(string|array $message): self
    {
        if (is_array($message)) {
            $message = array_map(function(string $translationKey) {
                return $this->getTranslation($translationKey);
            }, $message);
        } else {
            $message = $this->getTranslation($message);
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

    /**
     * @param string $translationKey
     *
     * @return string|null
     */
    private function getTranslation(string $translationKey): ?string
    {
        return $this->translationRepository->findOneBy([
            'language' => $this->languageRepository->findOneBy(['code' => $this->request->getLocale()]),
            'translationKey' => $this->translationKeyRepository->findOneBy(['key' => $translationKey])
        ])?->getTranslation();
    }
}