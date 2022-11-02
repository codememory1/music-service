<?php

namespace App\Dto\Transformer;

use App\Infrastucture\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\MediaLibraryEventDto;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\MediaLibraryEvent;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;
use App\Infrastucture\Dto\AbstractDataTransformer;

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