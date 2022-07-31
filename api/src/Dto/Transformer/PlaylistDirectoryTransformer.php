<?php

namespace App\Dto\Transformer;

use App\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\PlaylistDirectoryDto;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\PlaylistDirectory;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * Class PlaylistDirectoryTransformer.
 *
 * @package App\Dto\Transformer
 * @template-extends AbstractDataTransformer<PlaylistDirectoryDto>
 *
 * @author  Codememory
 */
final class PlaylistDirectoryTransformer extends AbstractDataTransformer
{
    private PlaylistDirectoryDto $playlistDirectoryDto;

    #[Pure]
    public function __construct(Request $request, PlaylistDirectoryDto $playlistDirectoryDto)
    {
        parent::__construct($request);

        $this->playlistDirectoryDto = $playlistDirectoryDto;
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->playlistDirectoryDto
            ->setEntity($entity ?: new PlaylistDirectory())
            ->collect($this->request->all());
    }
}