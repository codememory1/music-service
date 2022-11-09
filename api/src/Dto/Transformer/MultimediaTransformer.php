<?php

namespace App\Dto\Transformer;

use App\Dto\Transfer\MultimediaDto;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Multimedia;
use App\Infrastructure\Dto\AbstractDataTransformer;
use App\Infrastructure\Dto\Interfaces\DataTransferInterface;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataTransformer<MultimediaDto>
 */
final class MultimediaTransformer extends AbstractDataTransformer
{
    #[Pure]
    public function __construct(
        Request $request,
        private readonly MultimediaDto $multimediaDto
    ) {
        parent::__construct($request);
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->multimediaDto
            ->setEntity($entity ?: new Multimedia())
            ->collect([
                ...$this->request->all(),
                'image' => $this->request->getRequest()->files->get('image'),
                'multimedia' => $this->request->getRequest()->files->get('multimedia'),
                'subtitles' => $this->request->getRequest()->files->get('subtitles'),
            ]);
    }
}