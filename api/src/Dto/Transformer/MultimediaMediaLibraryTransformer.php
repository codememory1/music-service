<?php

namespace App\Dto\Transformer;

use App\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\MultimediaMediaLibraryDto;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\MultimediaMediaLibrary;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * Class MultimediaMediaLibraryTransformer.
 *
 * @package App\Dto\Transformer
 * @template-extends AbstractDataTransformer<MultimediaMediaLibraryDto>
 *
 * @author  Codememory
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
                'image' => $this->request?->request->files->get('image'),
            ]);
    }
}