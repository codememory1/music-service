<?php

namespace App\Dto\Transformer\WebSocket;

use App\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\WebSocket\CreateStreamMultimediaOfferBetweenCurrentAccountDto;
use App\Dto\Transformer\AbstractDataTransformer;
use App\Entity\Interfaces\EntityInterface;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataTransformer<CreateStreamMultimediaOfferBetweenCurrentAccountDto>
 */
final class CreateStreamMultimediaOfferBetweenCurrentAccountTransformer extends AbstractDataTransformer
{
    private CreateStreamMultimediaOfferBetweenCurrentAccountDto $streamMultimediaBetweenCurrentAccountDto;

    #[Pure]
    public function __construct(Request $request, CreateStreamMultimediaOfferBetweenCurrentAccountDto $streamMultimediaBetweenCurrentAccountDto)
    {
        parent::__construct($request);

        $this->streamMultimediaBetweenCurrentAccountDto = $streamMultimediaBetweenCurrentAccountDto;
    }

    public function transformFromArray(array $data, ?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->streamMultimediaBetweenCurrentAccountDto->collect($data);
    }
}