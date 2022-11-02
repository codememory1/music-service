<?php

namespace App\Dto\Transformer;

use App\Dto\Transfer\PlaylistDirectoryDto;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\PlaylistDirectory;
use App\Infrastucture\Dto\AbstractDataTransformer;
use App\Infrastucture\Dto\Interfaces\DataTransferInterface;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataTransformer<PlaylistDirectoryDto>
 */
final class PlaylistDirectoryTransformer extends AbstractDataTransformer
{
    #[Pure]
    public function __construct(
        Request $request,
        private readonly PlaylistDirectoryDto $playlistDirectoryDto
    ) {
        parent::__construct($request);
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->baseTransformFromRequest($this->playlistDirectoryDto, $entity ?: new PlaylistDirectory());
    }
}