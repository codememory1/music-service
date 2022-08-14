<?php

namespace App\Dto\Transformer;

use App\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\RestorePasswordDto;
use App\Entity\Interfaces\EntityInterface;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataTransformer<RestorePasswordDto>
 */
final class RestorePasswordTransformer extends AbstractDataTransformer
{
    private RestorePasswordDto $restorePasswordDto;

    #[Pure]
    public function __construct(Request $request, RestorePasswordDto $restorePasswordDto)
    {
        parent::__construct($request);

        $this->restorePasswordDto = $restorePasswordDto;
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->baseTransformFromRequest($this->restorePasswordDto, $entity);
    }
}