<?php

namespace App\Services\Translation;

use App\Orm\Entities\LanguageEntity;
use App\Orm\Entities\LanguageTranslationEntity;
use App\Orm\Repositories\LanguageRepository;
use App\Orm\Repositories\LanguageTranslationRepository;
use App\Services\AbstractApiService;
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
     * @return array
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    public function getTranslationsWithLanguages(): array
    {

        /** @var LanguageTranslationRepository $translationRepository */
        $translationRepository = $this->getRepository(LanguageTranslationEntity::class);

        /** @var LanguageRepository $languageRepository */
        $languageRepository = $this->getRepository(LanguageEntity::class);
        $translations = [];

        /** @var LanguageEntity $language */
        foreach ($languageRepository->getAllLangs() as $language) {
            // Getting the query result to the database
            $translationResult = $translationRepository->getTranslationsWithColumns(
                $language->getLangCode(),
                ['l.lang_code', 'lt.key', 'lt.translation']
            );
            $translations[$language->getLangCode()] = $translationResult->array()->all();
        }

        return $translations;

    }

    /**
     * @param string|null $lang
     *
     * @return array
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    public function getActiveLangTranslations(?string $lang = null): array
    {

        $activeLang = $lang ?: $this->request->query()->get('lang', env('app.default-lang'));

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