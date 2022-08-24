<?php

namespace App\Dto\Transformer\WebSocket;

use App\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\WebSocket\RejectOfferedStreamingDto;
use App\Dto\Transformer\AbstractDataTransformer;
use App\Entity\Interfaces\EntityInterface;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataTransformer<RejectOfferedStreamingDto>
 */
final class RejectOfferedStreamingTransformer extends AbstractDataTransformer
{
    private RejectOfferedStreamingDto $rejectOfferedStreamingDto;

    #[Pure]
    public function __construct(Request $request, RejectOfferedStreamingDto $rejectOfferedStreamingDto)
    {
        parent::__construct($request);

        $this->rejectOfferedStreamingDto = $rejectOfferedStreamingDto;
    }

    public function transformFromArray(array $data, ?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->rejectOfferedStreamingDto->collect($data);
    }
}