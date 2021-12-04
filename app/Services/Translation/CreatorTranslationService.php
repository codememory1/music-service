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
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
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
     * @param ValidationManager $validationManager
     * @param string            $lang
     *
     * @return ResponseApiCollectorService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    public function create(ValidationManager $validationManager, string $lang): ResponseApiCollectorService
    {

        /** @var LanguageRepository $languageRepository */
        $languageRepository = $this->getRepository(LanguageEntity::class);
        $creationValidationManager = $this->inputValidation($validationManager);

        // Input validation
        if (!$creationValidationManager->isValidation()) {
            return $this->apiResponse->create(400, $creationValidationManager->getErrors());
        }

        // Checking for the existence of a language
        if (!$languageRepository->getLang($lang)) {
            return $this->createApiResponse(400, 'translation@langNotExist');
        }

        return $this->addTranslation($languageRepository->getLang($lang), $this->addKey());

    }

    /**
     * @return int
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    public function addKey(): int
    {

        $translationKeyEntity = new TranslationKeyEntity();

        /** @var TranslationKeyRepository $translationKeyRepository */
        $translationKeyRepository = $this->getEntityManager()->getRepository($translationKeyEntity);
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
        $this->getEntityManager()->commit($translationKeyEntity)->flush();

        return $translationKeyRepository->getMaxId();

    }

    /**
     * @param LanguageEntity $languageEntity
     * @param int            $translationKeyId
     *
     * @return ResponseApiCollectorService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    public function addTranslation(LanguageEntity $languageEntity, int $translationKeyId): ResponseApiCollectorService
    {

        /** @var LanguageTranslationRepository $languageTranslationRepository */
        $languageTranslationRepository = $this->getRepository(LanguageTranslationEntity::class);

        $languageTranslationEntity = new LanguageTranslationEntity();
        $languageTranslationEntity
            ->setLangId($languageEntity->getId())
            ->setTranslationKeyId($translationKeyId)
            ->setTranslation($this->request->post()->get('translation'));

        // Checking the existence of a translation for the selected language
        if ($languageTranslationRepository->findBy([
            'lang_id'            => $languageEntity->getId(),
            'translation_key_id' => $translationKeyId
        ])) {
            return $this->createApiResponse(400, 'translation@translationExist');
        }

        $this->getEntityManager()->commit($languageTranslationEntity)->flush();

        return $this->createApiResponse(200, 'translation@successAddTranslation');

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