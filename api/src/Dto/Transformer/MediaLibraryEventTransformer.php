<?php

namespace App\Dto\Transformer;

use App\Dto\Transfer\MediaLibraryEventDto;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\MediaLibraryEvent;
use App\Infrastructure\Dto\AbstractDataTransformer;
use App\Infrastructure\Dto\Interfaces\DataTransferInterface;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataTransformer<MediaLibraryEventDto>
 */
final class MediaLibraryEventTransformer extends AbstractDataTransformer
{
    #[Pure]
    public function __construct(
        Request $request,
        private readonly MediaLibraryEventDto $mediaLibraryEventDto
    ) {
        parent::__construct($request);
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->baseTransformFromRequest($this->mediaLibraryEventDto, $entity ?: new MediaLibraryEvent());
    }
}