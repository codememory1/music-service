<?php

namespace App\Rest\Response\Meta;

use App\Infrastructure\Doctrine\Paginator;
use App\Rest\Response\Interfaces\ResponseMetaInterface;

final class ResponseMetaPagination implements ResponseMetaInterface
{
    public function __construct(
        private readonly Paginator $paginator
    ) {
    }

    public function getKey(): string
    {
        return 'pagination';
    }

    public function getMeta(): array
    {
        return [
            'total_pages' => $this->paginator->getTotalPages(),
            'current_page' => $this->paginator->getCurrentPage(),
            'current_limit' => $this->paginator->getLimit()
        ];
    }
}