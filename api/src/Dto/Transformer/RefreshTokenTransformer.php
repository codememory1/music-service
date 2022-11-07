<?php

namespace App\Dto\Transformer;

use App\Dto\Transfer\RefreshTokenDto;
use App\Entity\Interfaces\EntityInterface;
use App\Infrastructure\Dto\AbstractDataTransformer;
use App\Infrastructure\Dto\Interfaces\DataTransferInterface;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataTransformer<RefreshTokenDto>
 */
final class RefreshTokenTransformer extends AbstractDataTransformer
{
    #[Pure]
    public function __construct(
        Request $request,
        private readonly RefreshTokenDto $refreshTokenDto
    ) {
        parent::__construct($request);
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->refreshTokenDto->collect([
            'refresh_token' => $this->request->getRequest()->cookies->get('refresh_token')
        ]);
    }
}