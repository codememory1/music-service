<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Entity\MultimediaExternalService;
use App\Enum\MultimediaExternalServiceEnum;
use App\Infrastructure\Dto\AbstractDataTransfer;
use App\Validator\Constraints as AppAssert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @template-extends AbstractDataTransfer<MultimediaExternalService>
 */
final class UpdateMultimediaExternalServiceDto extends AbstractDataTransfer
{
    #[DtoConstraints\ToTypeConstraint]
    #[DtoConstraints\ValidationConstraint([
        new AppAssert\Callback('callbackParameters')
    ])]
    public array $parameters = [];

    public function callbackParameters(ExecutionContextInterface $context): void
    {
        $context
            ->getValidator()
            ->inContext($context)
            ->atPath('parameters')
            ->validate(
                $this->parameters,
                new AppAssert\JsonSchema(
                    MultimediaExternalServiceEnum::fromName($this->getEntity()->getServiceName()),
                    'multimedia_external_service.invalid_parameters'
                )
            );
    }
}