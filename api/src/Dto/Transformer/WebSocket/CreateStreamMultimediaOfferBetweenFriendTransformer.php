<?php

namespace App\Dto\Transformer\WebSocket;

use App\Dto\Transfer\WebSocket\CreateStreamMultimediaOfferBetweenFriendDto;
use App\Entity\Interfaces\EntityInterface;
use App\Infrastructure\Dto\AbstractDataTransformer;
use App\Infrastructure\Dto\Interfaces\DataTransferInterface;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataTransformer<CreateStreamMultimediaOfferBetweenFriendDto>
 */
final class CreateStreamMultimediaOfferBetweenFriendTransformer extends AbstractDataTransformer
{
    #[Pure]
    public function __construct(
        Request $request,
        private readonly CreateStreamMultimediaOfferBetweenFriendDto $createStreamMultimediaOfferBetweenFriendDto
    ) {
        parent::__construct($request);
    }

    public function transformFromArray(array $data, ?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->createStreamMultimediaOfferBetweenFriendDto->collect($data);
    }
}