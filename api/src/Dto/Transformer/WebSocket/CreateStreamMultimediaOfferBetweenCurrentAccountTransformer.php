<?php

namespace App\Dto\Transformer\WebSocket;

use App\Dto\Transfer\WebSocket\CreateStreamMultimediaOfferBetweenCurrentAccountDto;
use App\Entity\Interfaces\EntityInterface;
use App\Infrastructure\Dto\AbstractDataTransformer;
use Codememory\Dto\Interfaces\DataTransferInterface;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataTransformer<CreateStreamMultimediaOfferBetweenCurrentAccountDto>
 */
final class CreateStreamMultimediaOfferBetweenCurrentAccountTransformer extends AbstractDataTransformer
{
    #[Pure]
    public function __construct(
        Request $request,
        private readonly CreateStreamMultimediaOfferBetweenCurrentAccountDto $streamMultimediaBetweenCurrentAccountDto
    ) {
        parent::__construct($request);
    }

    public function transformFromArray(array $data, ?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->streamMultimediaBetweenCurrentAccountDto->collect($data);
    }
}