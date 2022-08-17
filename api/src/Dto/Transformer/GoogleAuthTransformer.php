<?php

namespace App\Dto\Transformer;

use App\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\GoogleAuthDto;
use App\Entity\Interfaces\EntityInterface;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataTransformer<GoogleAuthDto>
 */
final class GoogleAuthTransformer extends AbstractDataTransformer
{
    private GoogleAuthDto $googleAuthDto;

    #[Pure]
    public function __construct(Request $request, GoogleAuthDto $googleAuthDto)
    {
        parent::__construct($request);

        $this->googleAuthDto = $googleAuthDto;
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->baseTransformFromRequest($this->googleAuthDto, $entity);
    }
}