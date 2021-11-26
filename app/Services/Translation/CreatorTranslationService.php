<?php

namespace App\Services\Translation;

use App\Orm\Entities\LanguageEntity;
use App\Orm\Entities\LanguageTranslationEntity;
use App\Orm\Entities\TranslationKeyEntity;
use App\Orm\Repositories\LanguageRepository;
use App\Orm\Repositories\LanguageTranslationRepository;
use App\Orm\Repositories\TranslationKeyRepository;
use App\Services\AbstractApiService;
use App\Services\ResponseApiCollectorService;
use App\Validations\Translation\AddTranslationValidation;
use Codememory\Components\Database\Orm\Interfaces\EntityManagerInterface;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Validator\Interfaces\ValidationManagerInterface;
use Codememory\Components\Validator\Manager as ValidationManager;
use ReflectionException;

/**
 * Class CreatorTranslationService
 *
 * @package App\Services\Translation
 *
 * @author  Danil
 */
class CreatorTranslationService extends AbstractApiService
{

    /**
     * @param ValidationManager      $validationManager
     * @param EntityManagerInterface $entityManager
     * @param string                 $lang
     *
     * @return ResponseApiCollectorService
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    public function create(ValidationManager $validationManager, EntityManagerInterface $entityManager, string $lang): ResponseApiCollectorService
    {

        /** @var LanguageRepository $languageRepository */
        $languageRepository = $entityManager->getRepository(LanguageEntity::class);
        $creationValidationManager = $this->inputValidation($validationManager);

        // Input validation
        if (!$creationValidationManager->isValidation()) {
            return $this->apiResponse->create(400, $creationValidationManager->getErrors());
        }

        // Checking for the existence of a language
        if (!$languageRepository->getLang($lang)) {
            return $this->createApiResponse(400, 'translation.langNotExist');
        }

        return $this->addTranslation($entityManager, $languageRepository->getLang($lang), $this->addKey($entityManager));

    }

    /**
     * @param EntityManagerInterface $entityManager
     *
     * @return int
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    public function addKey(EntityManagerInterface $entityManager): int
    {

        $translationKeyEntity = new TranslationKeyEntity();

        /** @var TranslationKeyRepository $translationKeyRepository */
        $translationKeyRepository = $entityManager->getRepository($translationKeyEntity);
        $finedTranslationKey = $translationKeyRepository->findOne([
            'key' => $translationKeyEntity->getKey()
        ]);
        $key = $this->request->post()->get('key');

        $translationKeyEntity->setKey($key);

        // Check the existence of the key and return its id
        if (false !== $finedTranslationKey) {
            return $finedTranslationKey->getId();
        }

        // The key does not exist, we add the key and return its id
        $entityManager->commit($translationKeyEntity)->flush();

        return $translationKeyRepository->getMaxId();

    }

    /**
     * @param EntityManagerInterface $entityManager
     * @param LanguageEntity         $languageEntity
     * @param int                    $translationKeyId
     *
     * @return ResponseApiCollectorService
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    public function addTranslation(EntityManagerInterface $entityManager, LanguageEntity $languageEntity, int $translationKeyId): ResponseApiCollectorService
    {

        $languageTranslationEntity = new LanguageTranslationEntity();

        /** @var LanguageTranslationRepository $languageTranslationRepository */
        $languageTranslationRepository = $entityManager->getRepository($languageTranslationEntity);

        $languageTranslationEntity
            ->setLangId($languageEntity->getId())
            ->setTranslationKeyId($translationKeyId)
            ->setTranslation($this->request->post()->get('translation'));

        if ($languageTranslationRepository->findBy([
            'lang_id'            => $languageEntity->getId(),
            'translation_key_id' => $translationKeyId
        ])) {
            return $this->createApiResponse(400, 'translation.translationExist');
        }

        $entityManager->commit($languageTranslationEntity)->flush();

        return $this->createApiResponse(200, 'translation.successAddTranslation');

    }

    /**
     * @param ValidationManager $validationManager
     *
     * @return ValidationManagerInterface
     */
    private function inputValidation(ValidationManager $validationManager): ValidationManagerInterface
    {

        return $validationManager->create(new AddTranslationValidation(), $this->request->post()->all());

    }

}