<?php

namespace App\Dto\Transformer\WebSocket;

use App\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\WebSocket\AcceptOfferedStreamingDto;
use App\Dto\Transformer\AbstractDataTransformer;
use App\Entity\Interfaces\EntityInterface;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataTransformer<AcceptOfferedStreamingDto>
 */
final class AcceptOfferedStreamingTransformer extends AbstractDataTransformer
{
    private AcceptOfferedStreamingDto $acceptOfferedStreamingDto;

    #[Pure]
    public function __construct(Request $request, AcceptOfferedStreamingDto $acceptOfferedStreamingDto)
    {
        parent::__construct($request);

        $this->acceptOfferedStreamingDto = $acceptOfferedStreamingDto;
    }

    public function transformFromArray(array $data, ?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->acceptOfferedStreamingDto->collect($data);
    }
}