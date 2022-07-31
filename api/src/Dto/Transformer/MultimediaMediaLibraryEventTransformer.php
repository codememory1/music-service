<?php

namespace App\Dto\Transformer;

use App\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\MultimediaMediaLibraryEventDto;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\MultimediaMediaLibraryEvent;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * Class MultimediaMediaLibraryEventTransformer.
 *
 * @package App\Dto\Transformer
 * @template-extends AbstractDataTransformer<MultimediaMediaLibraryEventDto>
 *
 * @author  Codememory
 */
final class MultimediaMediaLibraryEventTransformer extends AbstractDataTransformer
{
    private MultimediaMediaLibraryEventDto $multimediaMediaLibraryEventDto;

    #[Pure]
    public function __construct(Request $request, MultimediaMediaLibraryEventDto $multimediaMediaLibraryEventDto)
    {
        parent::__construct($request);

        $this->multimediaMediaLibraryEventDto = $multimediaMediaLibraryEventDto;
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->multimediaMediaLibraryEventDto
            ->setEntity($entity ?: new MultimediaMediaLibraryEvent())
            ->collect($this->request->all());
    }
}