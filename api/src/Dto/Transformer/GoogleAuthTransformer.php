<?php

namespace App\Dto\Transformer;

use App\Infrastucture\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\GoogleAuthDto;
use App\Entity\Interfaces\EntityInterface;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;
use App\Infrastucture\Dto\AbstractDataTransformer;

/**
 * @template-extends AbstractDataTransformer<GoogleAuthDto>
 */
final class GoogleAuthTransformer extends AbstractDataTransformer
{
    #[Pure]
    public function __construct(
        Request $request,
        private readonly GoogleAuthDto $googleAuthDto
    ) {
        parent::__construct($request);
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->baseTransformFromRequest($this->googleAuthDto, $entity);
    }
}