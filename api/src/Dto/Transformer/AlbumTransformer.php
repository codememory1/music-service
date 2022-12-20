<?php

namespace App\Dto\Transformer;

use App\Dto\Transfer\AlbumDto;
use App\Entity\Album;
use App\Entity\Interfaces\EntityInterface;
use App\Infrastructure\Dto\AbstractDataTransformer;
use App\Infrastructure\Dto\Interfaces\DataTransferInterface;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

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