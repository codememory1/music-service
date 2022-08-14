<?php

namespace App\Dto\Transformer;

use App\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\RegistrationDto;
use App\Entity\Interfaces\EntityInterface;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataTransformer<RegistrationDto>
 */
final class RegistrationTransformer extends AbstractDataTransformer
{
    private RegistrationDto $registrationDto;

    #[Pure]
    public function __construct(Request $request, RegistrationDto $registrationDto)
    {
        parent::__construct($request);

        $this->registrationDto = $registrationDto;
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->baseTransformFromRequest($this->registrationDto, $entity);
    }
}