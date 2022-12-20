<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Entity\MultimediaExternalService;
use App\Enum\MultimediaExternalServiceEnum;
use App\Infrastructure\Dto\AbstractDataTransfer;
use App\Validator\Constraints as AppAssert;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @template-extends AbstractDataTransfer<MultimediaExternalService>
 */
final class MultimediaExternalServiceDto extends AbstractDataTransfer
{
    #[DtoConstraints\ToEnumConstraint(MultimediaExternalServiceEnum::class)]
    #[DtoConstraints\ValidationConstraint([
        new Assert\NotBlank(message: 'multimedia_external_service.service_name.is_required')
    ])]
    public ?MultimediaExternalServiceEnum $serviceName = null;

    #[DtoConstraints\ToTypeConstraint]
    #[DtoConstraints\ValidationConstraint([
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