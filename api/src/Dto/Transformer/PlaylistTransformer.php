<?php

namespace App\Dto\Transformer;

use App\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\PlaylistDto;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Playlist;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * Class PlaylistTransformer.
 *
 * @package App\Dto\Transformer
 * @template-extends AbstractDataTransformer<PlaylistDto>
 *
 * @author  Codememory
 */
final class PlaylistTransformer extends AbstractDataTransformer
{
    private PlaylistDto $playlistDto;

    #[Pure]
    public function __construct(Request $request, PlaylistDto $playlistDto)
    {
        parent::__construct($request);

        $this->playlistDto = $playlistDto;
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->playlistDto
            ->setEntity($entity ?: new Playlist())
            ->collect([
                ...$this->request->all(),
                'image' => $this->request?->request->files->get('image')
            ]);
    }
}