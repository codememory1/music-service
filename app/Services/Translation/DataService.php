<?php

namespace App\Services\Translation;

use App\Orm\Entities\LanguageEntity;
use App\Orm\Entities\LanguageTranslationEntity;
use App\Orm\Repositories\LanguageRepository;
use App\Orm\Repositories\LanguageTranslationRepository;
use App\Services\AbstractApiService;
use Codememory\Components\Database\Orm\Interfaces\EntityManagerInterface;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use ReflectionException;

/**
 * Class DataService
 *
 * @package App\Services\Translation
 *
 * @author  Danil
 */
class DataService extends AbstractApiService
{

    /**
     * @param EntityManagerInterface $entityManager
     *
     * @return array
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    public function getTranslationsWithLanguages(EntityManagerInterface $entityManager): array
    {

        /** @var LanguageTranslationRepository $translationRepository */
        $translationRepository = $entityManager->getRepository(LanguageTranslationEntity::class);

        /** @var LanguageRepository $languageRepository */
        $languageRepository = $entityManager->getRepository(LanguageEntity::class);
        $languages = $languageRepository->findAll();
        $translations = [];

        /** @var LanguageEntity $language */
        foreach ($languages as $language) {
            // Getting the query result to the database
            $translationResult = $translationRepository->getTranslationsWithColumns(
                $language->getLang(),
                ['l.lang', 'tk.key', 'lt.translation']
            );

            $translations[$language->getLang()] = $translationResult->array()->all();
        }

        return $translations;

    }

    /**
     * @return array
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    public function getActiveLangTranslations(): array
    {

        $activeLang = $this->translation->language->getActiveLang();

        // Checking for the existence of an active language
        if (!$this->translation->language->existLang($activeLang)) {
            $activeLang = env('app.default-lang');
        }

        /** @var CacheService $translationCacheService */
        $translationCacheService = $this->getService('Translation\Cache');

        return $translationCacheService->getAll()[$activeLang] ?? [];

    }

    /**
     * @param string $key
     *
     * @return string|int|null
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    public function getTranslationByKey(string $key): string|null|int
    {

        foreach ($this->getActiveLangTranslations() as $translation) {
            if ($translation['key'] === $key) {
                return $translation['translation'];
            }
        }

        return null;

    }

}