<?php

namespace App\Dto\Transformer;

use App\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\RegistrationDto;
use App\Entity\Interfaces\EntityInterface;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * Class PlaylistTransformer.
 *
 * @package App\Dto\Transformer
 * @template-extends AbstractDataTransformer<RegistrationDto>
 *
 * @author  Codememory
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
        return $this->registrationDto->collect($this->request->all());
    }
}