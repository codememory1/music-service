<?php

namespace App\Services;

use Codememory\Components\Services\AbstractService;
use Codememory\Components\Translator\Interfaces\TranslationInterface;
use Codememory\Container\ServiceProvider\Interfaces\ServiceProviderInterface;
use Codememory\HttpFoundation\Interfaces\RequestInterface;
use Codememory\HttpFoundation\Interfaces\ResponseInterface;

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
     */
    public function __construct(ServiceProviderInterface $serviceProvider)
    {

        parent::__construct($serviceProvider);

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
     */
    protected function createApiResponse(int $status, string $translationKey, array $data = []): ResponseApiCollectorService
    {

        return $this->apiResponse->create($status, [
            $this->translation->getTranslationActiveLang($translationKey)
        ], $data);

    }

}