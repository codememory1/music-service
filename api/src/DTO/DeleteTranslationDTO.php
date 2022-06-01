<?php

namespace App\DTO;

use App\DTO\Interceptors\AsBooleanInterceptor;

/**
 * Class DeleteTranslationDTO.
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class DeleteTranslationDTO extends AbstractDTO
{
    /**
     * @var bool
     */
    public bool $deleteKey = false;

    /**
     * @inheritDoc
     */
    protected function wrapper(): void
    {
        $this->addExpectKey('delete-key', 'deleteKey');

        $this->addInterceptor('deleteKey', new AsBooleanInterceptor());
    }
}