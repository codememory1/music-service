<?php

namespace App\Services;

use App\Services\Translation\DataService;
use Codememory\Components\Database\Pack\DatabasePack;
use Codememory\Components\Services\AbstractService;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Components\Translator\Interfaces\TranslationInterface;
use Codememory\Container\ServiceProvider\Interfaces\ServiceProviderInterface;
use Codememory\HttpFoundation\Interfaces\RequestInterface;
use Codememory\HttpFoundation\Interfaces\ResponseInterface;
use ReflectionException;

/**
 * Class AbstractApiService
 *
 * @package App\Services
 *
 * @author  Danil
 */
abstract class AbstractApiService extends AbstractService
{

    /**
     * @var RequestInterface
     */
    protected RequestInterface $request;

    /**
     * @var ResponseInterface
     */
    protected ResponseInterface $response;

    /**
     * @var ResponseApiCollectorService
     */
    protected ResponseApiCollectorService $apiResponse;

    /**
     * @var TranslationInterface
     */
    protected TranslationInterface $translation;

    /**
     * @param ServiceProviderInterface $serviceProvider
     * @param DatabasePack             $databasePack
     */
    public function __construct(ServiceProviderInterface $serviceProvider, DatabasePack $databasePack)
    {

        parent::__construct($serviceProvider, $databasePack);

        /** @var RequestInterface $request */
        $request = $this->get('request');
        $this->request = $request;

        /** @var ResponseInterface $response */
        $response = $this->get('response');
        $this->response = $response;

        /** @var ResponseApiCollectorService $apiResponse */
        $apiResponse = $this->get('api-response');
        $this->apiResponse = $apiResponse;

        /** @var TranslationInterface $translation */
        $translation = $this->get('translator');
        $this->translation = $translation;

    }

    /**
     * @param int    $status
     * @param string $translationKey
     * @param array  $data
     *
     * @return ResponseApiCollectorService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    protected function createApiResponse(int $status, string $translationKey, array $data = []): ResponseApiCollectorService
    {

        /** @var DataService $translationsFromDb */
        $translationsFromDb = $this->getService('Translation\Data');

        return $this->apiResponse->create($status, [
            $translationsFromDb->getTranslationByKey($translationKey)
        ], $data);

    }

}