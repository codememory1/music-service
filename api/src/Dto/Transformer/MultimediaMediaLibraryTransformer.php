<?php

namespace App\Dto\Transformer;

use App\Infrastucture\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\MultimediaMediaLibraryDto;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\MultimediaMediaLibrary;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;
use App\Infrastucture\Dto\AbstractDataTransformer;

/**
 * @template-extends AbstractDataTransformer<MultimediaMediaLibraryDto>
 */
final class MultimediaMediaLibraryTransformer extends AbstractDataTransformer
{
    #[Pure]
    public function __construct(
        Request $request,
        private readonly MultimediaMediaLibraryDto $multimediaMediaLibraryDto
    ) {
        parent::__construct($request);
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