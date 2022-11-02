<?php

namespace App\Dto\Transformer;

use App\Infrastucture\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\AlbumDto;
use App\Entity\Album;
use App\Entity\Interfaces\EntityInterface;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;
use App\Infrastucture\Dto\AbstractDataTransformer;

/**
 * @template-extends AbstractDataTransformer<AlbumDto>
 */
final class AlbumTransformer extends AbstractDataTransformer
{
    #[Pure]
    public function __construct(
        Request $request,
        private readonly AlbumDto $albumDto
    ) {
        parent::__construct($request);
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->albumDto
            ->setEntity($entity ?: new Album())
            ->collect([
                ...$this->request->all(),
                'image' => $this->request->getRequest()->files->get('image')
            ]);
    }
}