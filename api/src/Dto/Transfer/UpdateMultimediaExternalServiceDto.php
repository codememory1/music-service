<?php

namespace App\Dto\Transfer;

use Codememory\Dto\Constraints as DC;
use App\Entity\MultimediaExternalService;
use App\Enum\MultimediaExternalServiceEnum;
use App\Validator\Constraints as AppAssert;
use Codememory\Dto\DataTransfer;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @template-extends DataTransfer<MultimediaExternalService>
 */
final class UpdateMultimediaExternalServiceDto extends DataTransfer
{
    #[DC\ToType]
    #[DC\Validation([
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
                    MultimediaExternalServiceEnum::fromName($this->getObject()->getServiceName()),
                    'multimedia_external_service.invalid_parameters'
                )
            );
    }
}