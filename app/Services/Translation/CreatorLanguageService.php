<?php

namespace App\Services\Translation;

use App\Orm\Entities\LanguageEntity;
use App\Orm\Repositories\LanguageRepository;
use App\Services\AbstractCrudService;
use App\Validations\Translation\CreateLanguageValidation;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Components\Validator\Manager;
use Codememory\Components\Validator\Manager as ValidationManager;
use Codememory\Support\Str;
use ReflectionException;

/**
 * Class CreatorLanguageService
 *
 * @package App\Services\Translation
 *
 * @author  Danil
 */
class CreatorLanguageService extends AbstractCrudService
{

    /**
     * @param ValidationManager  $manager
     * @param LanguageRepository $languageRepository
     *
     * @return CreatorLanguageService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    public function make(Manager $manager, LanguageRepository $languageRepository): static
    {

        $languageCode = Str::toLowercase($this->request->post()->get('lang_code', escapingHtml: true) ?: '');
        $validatedDataManager = $this->makeInputValidation($manager, new CreateLanguageValidation());

        // Input validation
        if (!$validatedDataManager->isValidation()) {
            return $this->setResponse(
                $this->apiResponse->create(400, $validatedDataManager->getErrors())
            );
        }

        // Checking for the existence of a language
        if ($languageRepository->getLang($languageCode)) {
            return $this->setResponse(
                $this->createApiResponse(400, 'translation@langExist')
            );
        }

        // Push tongue to base
        return $this->push($languageCode);

    }

    /**
     * @param string $languageCode
     *
     * @return CreatorLanguageService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    private function push(string $languageCode): static
    {

        $languageEntity = new LanguageEntity();

        $languageEntity->setLangCode($languageCode);

        $this->getEntityManager()->commit($languageEntity)->flush();

        return $this->setResponse(
            $this->createApiResponse(200, 'translation@successCreateLang')
        );

    }

}