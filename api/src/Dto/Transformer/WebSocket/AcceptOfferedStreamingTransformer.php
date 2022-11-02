<?php

namespace App\Dto\Transformer\WebSocket;

use App\Infrastucture\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\WebSocket\AcceptOfferedStreamingDto;
use App\Entity\Interfaces\EntityInterface;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;
use App\Infrastucture\Dto\AbstractDataTransformer;

/**
 * @template-extends AbstractDataTransformer<AcceptOfferedStreamingDto>
 */
final class AcceptOfferedStreamingTransformer extends AbstractDataTransformer
{
    #[Pure]
    public function __construct(
        Request $request,
        private readonly AcceptOfferedStreamingDto $acceptOfferedStreamingDto
    ) {
        parent::__construct($request);
    }

    public function transformFromArray(array $data, ?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->acceptOfferedStreamingDto->collect($data);
    }
}