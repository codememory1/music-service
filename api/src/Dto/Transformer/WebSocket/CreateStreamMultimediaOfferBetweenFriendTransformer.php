<?php

namespace App\Dto\Transformer\WebSocket;

use App\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\WebSocket\CreateStreamMultimediaOfferBetweenFriendDto;
use App\Dto\Transformer\AbstractDataTransformer;
use App\Entity\Interfaces\EntityInterface;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataTransformer<CreateStreamMultimediaOfferBetweenFriendDto>
 */
final class CreateStreamMultimediaOfferBetweenFriendTransformer extends AbstractDataTransformer
{
    private CreateStreamMultimediaOfferBetweenFriendDto $createStreamMultimediaOfferBetweenFriendDto;

    #[Pure]
    public function __construct(Request $request, CreateStreamMultimediaOfferBetweenFriendDto $createStreamMultimediaOfferBetweenFriendDto)
    {
        parent::__construct($request);

        $this->createStreamMultimediaOfferBetweenFriendDto = $createStreamMultimediaOfferBetweenFriendDto;
    }

    public function transformFromArray(array $data, ?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->createStreamMultimediaOfferBetweenFriendDto->collect($data);
    }
}