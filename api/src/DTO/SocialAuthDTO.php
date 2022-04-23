<?php

namespace App\DTO;

use App\Rest\DTO\AbstractDTO;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class SocialAuthDTO.
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class SocialAuthDTO extends AbstractDTO
{
    /**
     * @var null|string
     */
    #[Assert\NotBlank(message: 'socialAuth@codeIsRequired')]
    public ?string $code = null;

    /**
     * @inheritDoc
     */
    public function wrapper(): void
    {
        $this->addExpectedRequestKey('code');
    }
}