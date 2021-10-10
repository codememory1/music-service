<?php

namespace App\Services\Sorting;

use Codememory\Components\Services\AbstractService;
use Codememory\Container\ServiceProvider\Interfaces\ServiceProviderInterface;
use Codememory\HttpFoundation\Interfaces\RequestInterface;

/**
 * Class DataService
 *
 * @package App\Services\Sorting
 *
 * @author  Danil
 */
class DataService extends AbstractService
{

    /**
     * @var RequestInterface
     */
    private RequestInterface $request;

    /**
     * @param ServiceProviderInterface $serviceProvider
     */
    public function __construct(ServiceProviderInterface $serviceProvider)
    {

        parent::__construct($serviceProvider);

        /** @var RequestInterface $request */
        $request = $this->get('request');
        $this->request = $request;

    }

    /**
     * @return array
     */
    final public function getColumns(): array
    {

        $columnsToString = $this->request->query()->get('sorting');

        if (null === $columnsToString) {
            return [];
        }

        return explode(',', $columnsToString);

    }

    /**
     * @return string
     */
    final public function getType(): string
    {

        $type = $this->request->query()->get('sorting-type');

        if (empty($type) || !in_array($type, ['ask', 'desc'])) {
            return 'desc';
        }

        return $type;

    }

}