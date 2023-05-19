<?php

namespace App\DTO;

use App\Entity\AccessKey;
use App\Enum\TranslationKey;
use Codememory\Dto\DataTransfer;
use Codememory\Dto\Constraints as DC;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @template-extends DataTransfer<AccessKey>
 */
final class AccessKeyDTO extends DataTransfer
{
    #[DC\Validation([
        new Assert\NotBlank(message: TranslationKey::MICROSERVICE_REQUIRED),
        new Assert\Length(max: 50, maxMessage: TranslationKey::MICROSERVICE_MAX_LENGTH)
    ])]
    public ?string $microservice = null;
}