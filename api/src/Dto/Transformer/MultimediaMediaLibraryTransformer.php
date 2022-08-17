<?php

namespace App\Dto\Transformer;

use App\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\MultimediaMediaLibraryDto;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\MultimediaMediaLibrary;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataTransformer<MultimediaMediaLibraryDto>
 */
final class MultimediaMediaLibraryTransformer extends AbstractDataTransformer
{
    private MultimediaMediaLibraryDto $multimediaMediaLibraryDto;

    #[Pure]
    public function __construct(Request $request, MultimediaMediaLibraryDto $multimediaMediaLibraryDto)
    {
        parent::__construct($request);

        $this->multimediaMediaLibraryDto = $multimediaMediaLibraryDto;
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->multimediaMediaLibraryDto
            ->setEntity($entity ?: new MultimediaMediaLibrary())
            ->collect([
                ...$this->request->all(),
                'image' => $this->request->getRequest()->files->get('image'),
            ]);
    }
}