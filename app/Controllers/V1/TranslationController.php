<?php

namespace App\Controllers\V1;

use App\Orm\Repositories\AccessRightNameRepository;
use App\Services\Translation\CacheService;
use App\Services\Translation\CreatorLanguageService;
use App\Services\Translation\CreatorTranslationService;
use App\Services\Translation\DataService;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Profiling\Exceptions\BuilderNotCurrentSectionException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Container\ServiceProvider\Interfaces\ServiceProviderInterface;
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
     */
    public function createLanguage(): void
    {

        if (false != $authorizedUser = $this->isAuthWithResponse()) {
            $this->isExistRight($authorizedUser, AccessRightNameRepository::CREATE_LANG);

            /** @var CreatorLanguageService $creatorLanguageService */
            $creatorLanguageService = $this->getService('Translation\CreatorLanguage');

            // Creating a language and getting a response about creation
            $languageCreationResponse = $creatorLanguageService->create($this->validatorManager(), $this->em);

            $this->response->json($languageCreationResponse->getResponse(), $languageCreationResponse->getStatus());
        }

    }

    public function addTranslation(string $lang): void
    {

        if (false != $authorizedUser = $this->isAuthWithResponse()) {
            $this->isExistRight($authorizedUser, AccessRightNameRepository::ADD_TRANSLATION);

            /** @var CreatorTranslationService $creatorTranslationService */
            $creatorTranslationService = $this->getService('Translation\CreatorTranslation');

            // Answer to add translation to language
            $translationCreationResponse = $creatorTranslationService->create($this->validatorManager(), $this->em, $lang);

            $this->response->json($translationCreationResponse->getResponse(), $translationCreationResponse->getStatus());
        }

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

        if (false != $authorizedUser = $this->isAuthWithResponse()) {
            $this->isExistRight($authorizedUser, AccessRightNameRepository::UPDATE_TRANSLATION_CACHE);

            $this->translationCacheService->update(
                $this->translationDataService->getTranslationsWithLanguages($this->em)
            );

            $this->response->json($this->apiResponse->create(200, [
                $this->translationDataService->getTranslationByKey('success_update_translation_cache')
            ])->getResponse());

        }

    }

}