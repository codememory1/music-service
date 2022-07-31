<?php

namespace App\Dto\Transformer;

use App\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\MediaLibraryEventDto;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\MediaLibraryEvent;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * Class MediaLibraryEventTransformer.
 *
 * @package App\Dto\Transformer
 * @template-extends AbstractDataTransformer<MediaLibraryEventDto>
 *
 * @author  Codememory
 */
final class MediaLibraryEventTransformer extends AbstractDataTransformer
{
    private MediaLibraryEventDto $mediaLibraryEventDto;

    #[Pure]
    public function __construct(Request $request, MediaLibraryEventDto $mediaLibraryEventDto)
    {
        parent::__construct($request);

        $this->mediaLibraryEventDto = $mediaLibraryEventDto;
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->mediaLibraryEventDto
            ->setEntity($entity ?: new MediaLibraryEvent())
            ->collect($this->request->all());
    }
}