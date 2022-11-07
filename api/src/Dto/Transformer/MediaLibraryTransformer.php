<?php

namespace App\Dto\Transformer;

use App\Dto\Transfer\MediaLibraryDto;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\MediaLibrary;
use App\Infrastructure\Dto\AbstractDataTransformer;
use App\Infrastructure\Dto\Interfaces\DataTransferInterface;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataTransformer<MediaLibraryDto>
 */
final class MediaLibraryTransformer extends AbstractDataTransformer
{
    #[Pure]
    public function __construct(
        Request $request,
        private readonly MediaLibraryDto $mediaLibraryDto
    ) {
        parent::__construct($request);
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->baseTransformFromRequest($this->mediaLibraryDto, $entity ?: new MediaLibrary());
    }
}