<?php

namespace App\Dto\Transformer;

use App\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\MediaLibraryDto;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\MediaLibrary;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataTransformer<MediaLibraryDto>
 */
final class MediaLibraryTransformer extends AbstractDataTransformer
{
    private MediaLibraryDto $mediaLibraryDto;

    #[Pure]
    public function __construct(Request $request, MediaLibraryDto $mediaLibraryDto)
    {
        parent::__construct($request);

        $this->mediaLibraryDto = $mediaLibraryDto;
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->baseTransformFromRequest($this->mediaLibraryDto, $entity ?: new MediaLibrary());
    }
}