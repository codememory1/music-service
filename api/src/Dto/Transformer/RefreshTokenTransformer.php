<?php

namespace App\Dto\Transformer;

use App\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\RefreshTokenDto;
use App\Entity\Interfaces\EntityInterface;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * Class RefreshTokenTransformer.
 *
 * @package App\Dto\Transformer
 * @template-extends AbstractDataTransformer<RefreshTokenDto>
 *
 * @author  Codememory
 */
final class RefreshTokenTransformer extends AbstractDataTransformer
{
    private RefreshTokenDto $refreshTokenDto;

    #[Pure]
    public function __construct(Request $request, RefreshTokenDto $refreshTokenDto)
    {
        parent::__construct($request);

        $this->refreshTokenDto = $refreshTokenDto;
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->refreshTokenDto->collect([
            'refresh_token' => $this->request?->request->cookies->get('refresh_token')
        ]);
    }
}