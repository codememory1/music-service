<?php

namespace App\Controllers\V1;

use App\Orm\Entities\LanguageEntity;
use App\Orm\Repositories\AccessRightNameRepository;
use App\Orm\Repositories\LanguageRepository;
use App\Services\Translation\AddTranslationService;
use App\Services\Translation\CacheService;
use App\Services\Translation\CreatorLanguageService;
use App\Services\Translation\DataService;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Profiling\Exceptions\BuilderNotCurrentSectionException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Container\ServiceProvider\Interfaces\ServiceProviderInterface;
use ErrorException;
use JetBrains\PhpStorm\NoReturn;
use ReflectionException;

/**
 * Class TranslationController
 *
 * @package App\Controllers\V1
 *
 * @author  Danil
 */
class TranslationController extends AbstractAuthorizationController
{

    /**
     * @var DataService
     */
    private DataService $translationDataService;

    /**
     * @var CacheService
     */
    private CacheService $translationCacheService;

    /**
     * @var LanguageRepository
     */
    private LanguageRepository $languageRepository;

    /**
     * @param ServiceProviderInterface $serviceProvider
     *
     * @throws ReflectionException
     * @throws BuilderNotCurrentSectionException
     * @throws ServiceNotExistException
     */
    public function __construct(ServiceProviderInterface $serviceProvider)
    {

        parent::__construct($serviceProvider);

        /** @var DataService $translationDataService */
        $translationDataService = $this->getService('Translation\Data');
        $this->translationDataService = $translationDataService;

        /** @var CacheService $translationCacheService */
        $translationCacheService = $this->getService('Translation\Cache');
        $this->translationCacheService = $translationCacheService;

        /** @var LanguageRepository $languageRepository */
        $languageRepository = $this->em->getRepository(LanguageEntity::class);
        $this->languageRepository = $languageRepository;

    }

    /**
     * @return void
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    #[NoReturn]
    public function translations(): void
    {

        $this->response->json($this->translationDataService->getActiveLangTranslations());

    }

    /**
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     * @throws ErrorException
     */
    #[NoReturn]
    public function createLanguage(): void
    {

        $this->checkAuthWithRight(AccessRightNameRepository::CREATE_LANG);

        /** @var CreatorLanguageService $creatorLanguageService */
        $creatorLanguageService = $this->getService('Translation\CreatorLanguage');

        // Creating a language and getting a response about creation
        $createResponse = $creatorLanguageService
            ->make($this->validatorManager(), $this->languageRepository)
            ->getResponseApiCollector();

        $this->response->json($createResponse->getResponse(), $createResponse->getStatus());

    }

    /**
     * @param string $lang
     *
     * @throws ErrorException
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    #[NoReturn]
    public function addTranslation(string $lang): void
    {

        $this->checkAuthWithRight(AccessRightNameRepository::ADD_TRANSLATION);

        /** @var AddTranslationService $addTranslationService */
        $addTranslationService = $this->getService('Translation\AddTranslation');

        // Answer to add translation to language
        $createResponse = $addTranslationService
            ->make($this->validatorManager(), $this->languageRepository, $lang)
            ->getResponseApiCollector();

        $this->response->json($createResponse->getResponse(), $createResponse->getStatus());

    }

    /**
     * @return void
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    #[NoReturn]
    public function updateCache(): void
    {

        $this->checkAuthWithRight(AccessRightNameRepository::UPDATE_TRANSLATION_CACHE);

        // Updating the translation cache for all languages
        $this->translationCacheService->update(
            $this->translationDataService->getTranslationsWithLanguages()
        );

        $this->response->json($this->apiResponse->create(200, [
            $this->translationDataService->getTranslationByKey('translation@successUpdateCache')
        ])->getResponse());

    }

}