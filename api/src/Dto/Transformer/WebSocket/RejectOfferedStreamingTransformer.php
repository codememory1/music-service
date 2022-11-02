<?php

namespace App\Dto\Transformer\WebSocket;

use App\Infrastucture\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\WebSocket\RejectOfferedStreamingDto;
use App\Infrastucture\Dto\AbstractDataTransformer;
use App\Entity\Interfaces\EntityInterface;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataTransformer<RejectOfferedStreamingDto>
 */
final class RejectOfferedStreamingTransformer extends AbstractDataTransformer
{
    #[Pure]
    public function __construct(
        Request $request,
        private readonly RejectOfferedStreamingDto $rejectOfferedStreamingDto
    ) {
        parent::__construct($request);
    }

    public function transformFromArray(array $data, ?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->rejectOfferedStreamingDto->collect($data);
    }
}