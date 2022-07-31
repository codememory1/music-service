<?php

namespace App\Dto\Transformer;

use App\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\AlbumDto;
use App\Entity\Album;
use App\Entity\Interfaces\EntityInterface;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * Class AlbumTransformer.
 *
 * @package App\Dto\Transformer
 * @template-extends AbstractDataTransformer<AlbumDto>
 *
 * @author  Codememory
 */
final class AlbumTransformer extends AbstractDataTransformer
{
    private AlbumDto $albumDto;

    #[Pure]
    public function __construct(Request $request, AlbumDto $albumDto)
    {
        parent::__construct($request);

        $this->albumDto = $albumDto;
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->albumDto
            ->setEntity($entity ?: new Album())
            ->collect([
                ...$this->request->all(),
                'image' => $this->request?->request->files->get('image')
            ]);
    }
}