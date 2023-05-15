<?php

namespace App\Dto\Transfer;

use Codememory\Dto\Constraints as DC;
use App\Entity\MultimediaExternalService;
use App\Enum\MultimediaExternalServiceEnum;
use App\Validator\Constraints as AppAssert;
use Codememory\Dto\DataTransfer;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @template-extends DataTransfer<MultimediaExternalService>
 */
final class MultimediaExternalServiceDto extends DataTransfer
{
    #[DC\ToEnum]
    #[DC\Validation([
        new Assert\NotBlank(message: 'multimedia_external_service.service_name.is_required')
    ])]
    public ?MultimediaExternalServiceEnum $serviceName = null;

    #[DC\ToType]
    #[DC\Validation([
        new AppAssert\Callback('callbackParameters')
    ])]
    public array $parameters = [];

    public function callbackParameters(ExecutionContextInterface $context): void
    {
        if (null !== $this->serviceName) {
            $context
                ->getValidator()
                ->inContext($context)
                ->atPath('parameters')
                ->validate(
                    $this->parameters,
                    new AppAssert\JsonSchema($this->serviceName->value, 'multimedia_external_service.invalid_parameters')
                );
        }
    }
}