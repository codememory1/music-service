<?php

namespace App\Services\Translation;

use App\Orm\Entities\LanguageEntity;
use App\Orm\Entities\LanguageTranslationEntity;
use App\Orm\Entities\TranslationKeyEntity;
use App\Orm\Repositories\LanguageRepository;
use App\Orm\Repositories\LanguageTranslationRepository;
use App\Orm\Repositories\TranslationKeyRepository;
use App\Services\AbstractCrudService;
use App\Validations\Translation\AddTranslationValidation;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Components\Validator\Manager;
use ReflectionException;

/**
 * Class AddTranslationService
 *
 * @package App\Services\Translation
 *
 * @author  Danil
 */
class AddTranslationService extends AbstractCrudService
{

    /**
     * @param Manager            $manager
     * @param LanguageRepository $languageRepository
     * @param string             $lang
     *
     * @return AddTranslationService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    public function make(Manager $manager, LanguageRepository $languageRepository, string $lang): static
    {

        $validatedDataManager = $this->makeInputValidation($manager, new AddTranslationValidation());

        // Input validation
        if (!$validatedDataManager->isValidation()) {
            return $this->setResponse(
                $this->apiResponse->create(400, $validatedDataManager->getErrors())
            );
        }

        // Checking for the existence of a language
        if (!$languageRepository->getLang($lang)) {
            return $this->setResponse(
                $this->createApiResponse(400, 'translation@langNotExist')
            );
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
        $translationKeyRepository = $this->getRepository($translationKeyEntity::class);
        $finedTranslationKey = $translationKeyRepository->findOne([
            'key' => $translationKeyEntity->getKey()
        ]);
        $key = $this->request->post()->get('key', escapingHtml: true);

        $translationKeyEntity->setKey($key);

        // Check the existence of the key and return its id
        if (false !== $finedTranslationKey) {
            return $finedTranslationKey->getId();
        }

        // The key does not exist, we add the key and return its id
        $this->getEntityManager()
            ->commit($translationKeyEntity)
            ->flush();

        return $translationKeyRepository->getMaxId();

    }

    /**
     * @param LanguageEntity $languageEntity
     * @param int            $translationKeyId
     *
     * @return AddTranslationService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    public function addTranslation(LanguageEntity $languageEntity, int $translationKeyId): static
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
            return $this->setResponse(
                $this->createApiResponse(400, 'translation@translationExist')
            );
        }

        $this->getEntityManager()
            ->commit($languageTranslationEntity)
            ->flush();

        return $this->setResponse(
            $this->createApiResponse(200, 'translation@successAddTranslation')
        );

    }

}