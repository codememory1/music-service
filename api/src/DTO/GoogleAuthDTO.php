<?php

namespace App\DTO;

use App\DTO\Interfaces\ServiceAuthorizationDTOInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class GoogleAuthDTO.
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class GoogleAuthDTO extends AbstractDTO implements ServiceAuthorizationDTOInterface
{
    #[Assert\NotBlank(message: 'serviceAuth@authorizationCodeIsRequired')]
    public ?string $code = null;

    /**
     * @inheritDoc
     */
    protected function wrapper(): void
    {
        $this->addExpectKey('code');
    }
}